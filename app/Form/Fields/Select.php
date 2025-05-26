<?php

namespace App\Form\Fields;

class Select extends BaseField
{
    protected string $type = 'Select';

    protected array $options = [];

    public function options(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'options' => $this->options,
        ]);
    }
}