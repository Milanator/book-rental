<?php

namespace App\Table\Columns;

use App\Interfaces\FormFieldInterface;

class BaseColumn implements FormFieldInterface
{
    protected string $type;

    public function __construct(
        protected string $name,
        protected string $label
    ) {
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'label' => $this->label,
        ];
    }
}