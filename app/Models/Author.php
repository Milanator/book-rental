<?php

namespace App\Models;

use App\Http\Requests\Author\SaveRequest;
use App\Observers\AuthorObserver;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Database\{
    Eloquent\Attributes\ObservedBy,
    Eloquent\Attributes\Scope,
    Eloquent\Casts\Attribute,
    Eloquent\Model,
    Eloquent\Relations\HasMany,
};

#[ObservedBy([AuthorObserver::class])]
class Author extends Model
{
    protected $fillable = [
        'name',
        'surname'
    ];

    protected $appends = [
        'full_name'
    ];

    /**
     * Relations
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Accessors
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(get: fn() => "{$this->name} {$this->surname}");
    }

    /**
     * Static
     */
    public static function getOptions(): array
    {
        return Author::select('id', 'name', 'surname')->get()->pluck('full_name', 'id')->toArray();
    }

    public static function store(SaveRequest $request): Model
    {
        return Author::create($request->rData());
    }

    // update model - named because of method name collision
    public static function modify(SaveRequest $request, int $id): void
    {
        Author::whereId($id)->first()->update($request->rData());
    }

    /**
     * Scopes
     */
    #[Scope]
    protected function listing(Builder $query, Request $request): void
    {
        $query
            ->select('id', 'name', 'surname')
            ->withCount('books')
            ->when(is_string($request->name), fn(Builder $query) => $query->where('name', 'LIKE', "{$request->name}%"))
            ->when(is_string($request->surname), fn(Builder $query) => $query->where('surname', 'LIKE', "{$request->surname}%"))
            ->orderByDesc('id');
    }

    #[Scope]
    protected function detail(Builder $query): void
    {
        $query->select('id', 'name', 'surname');
    }
}
