<?php

namespace App\Models;

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

    /**
     * Relations
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public static function store(): Model
    {

        dd('test');
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
