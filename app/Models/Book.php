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
};

#[ObservedBy([BookObserver::class])]
class Book extends Model
{
    protected $fillable = [
        'author_id',
        'title',
        'is_borrowed'
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

    /**
     * Scopes
     */
    #[Scope]
    protected function listing(Builder $query, Request $request): void
    {
        $query
            ->select('id', 'title', 'author_id', 'is_borrowed')
            ->with('author:id,name,surname')
            ->when($request->title, fn(Builder $query) => $query->where('title', 'LIKE', "{$request->title}%"))
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
