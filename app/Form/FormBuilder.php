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
            'breadcrumb' => $this->formSchema['breadcrumb'] ?? [],
            'submit_url' => $this->formSchema['submit_url'],
            'fields' => array_map(fn($field) => $field->toArray(), $this->formSchema['fields']),
        ];
    }
}