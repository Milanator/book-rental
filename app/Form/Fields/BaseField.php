<?php

namespace App\Form\Fields;

use App\Interfaces\FormFieldInterface;

class BaseField implements FormFieldInterface
{
    protected string $type;

    protected bool $required;

    protected string $placeholder;

    public function __construct(
        protected string $name,
        protected string $label
    ) {
    }

    public function required(): static
    {
        $this->required = true;

        return $this;
    }

    public function placeholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'label' => $this->label,
            'required' => $this->required,
            'placeholder' => $this->placeholder,
        ];
    }
}