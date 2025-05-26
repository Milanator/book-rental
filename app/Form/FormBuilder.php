<?php

namespace App\Form;

use App\Interfaces\FormFieldInterface;

class FormBuilder implements FormFieldInterface
{
    public function __construct(protected array $formBuilderSchema)
    {
    }

    public function toArray(): array
    {
        return array_map(fn($field) => $field->toArray(), $this->formBuilderSchema);
    }
}