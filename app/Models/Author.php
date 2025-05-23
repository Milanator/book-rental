<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

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
     * Scopes
     */
    #[Scope]
    protected function listing(Builder $query, Request $request): void
    {
        $query
            ->select('id', 'name', 'surname')
            ->withCount('books')
            ->when($request->name, fn(Builder $query) => $query->where('name', 'LIKE', "{$request->name}%"))
            ->when($request->surname, fn(Builder $query) => $query->where('surname', 'LIKE', "{$request->surname}%"))
            ->orderByDesc('id');
    }

    #[Scope]
    protected function detail(Builder $query): void
    {
        $query->select('id', 'name', 'surname');
    }
}
