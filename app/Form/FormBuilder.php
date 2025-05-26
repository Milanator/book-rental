<?php

namespace App\Form;

use App\Interfaces\FormFieldInterface;

class FormBuilder implements FormFieldInterface
{
    public function __construct(protected array $formSchema)
    {
    }

    public function toArray(): array
    {
        return [
            'title' => $this->formSchema['title'],
            'subtitle' => $this->formSchema['subtitle'] ?? null,
            'fields' => array_map(fn($field) => $field->toArray(), $this->formSchema['fields']),
        ];
    }
}