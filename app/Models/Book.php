<?php

namespace App\Models;

use App\Casts\Boolean;
use App\Http\Requests\Book\SaveRequest;
use App\Observers\BookObserver;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Database\{
    Eloquent\Model,
    Eloquent\Relations\BelongsTo,
    Eloquent\Attributes\Scope,
    Eloquent\Attributes\ObservedBy,
    Eloquent\Casts\Attribute,
};

#[ObservedBy([BookObserver::class])]
class Book extends Model
{
    protected $fillable = [
        'author_id',
        'title',
        'is_borrowed'
    ];

    protected $appends = [
        'is_borrowed_text'
    ];

    protected function casts(): array
    {
        return [
            'is_borrowed' => Boolean::class,
        ];
    }

    /**
     * Relations
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Static
     */
    public static function store(SaveRequest $request): Model
    {
        return Book::create($request->rData());
    }

    // update model - named because of method name collision
    public static function modify(SaveRequest $request, int $id): void
    {
        Book::whereId($id)->first()->update($request->rData());
    }

    /**
     * Accessors
     */
    protected function isBorrowedText(): Attribute
    {
        return Attribute::make(get: fn() => $this->is_borrowed ? __('Yes') : __('No'));
    }

    /**
     * Scopes
     */
    #[Scope]
    protected function listing(Builder $query, Request $request): void
    {
        $query
            ->select('id', 'title', 'author_id', 'is_borrowed')
            ->with('author:id,name,surname')
            ->when(is_string($request->title), fn(Builder $query) => $query->where('title', 'LIKE', "{$request->title}%"))
            ->when(is_numeric($request->is_borrowed), fn(Builder $query) => $query->whereIsBorrowed($request->is_borrowed))
            ->when(is_string($request->author), callback:
                fn(Builder $query) => $query->whereHas(
                    'author',
                    fn(Builder $q) =>
                    $q->where('name', 'LIKE', "{$request->author}%")->orWhere('surname', 'LIKE', "{$request->author}%")
                ))
            ->orderByDesc('id');
    }

    #[Scope]
    protected function detail(Builder $query): void
    {
        $query
            ->select('id', 'title', 'author_id', 'is_borrowed')
            ->with('author:id,name,surname');
    }
}
