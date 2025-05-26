<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Boolean implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return !empty($value) ? __('Yes') : __('No');
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
