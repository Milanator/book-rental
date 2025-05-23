<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
