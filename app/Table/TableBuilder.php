<?php

namespace App\Table;

use App\Interfaces\FormFieldInterface;

class TableBuilder implements FormFieldInterface
{
    public function __construct(protected array $tableSchema)
    {
    }

    public function toArray(): array
    {
        return [
            'title' => $this->tableSchema['title'],
            'columns' => array_map(fn($field) => $field->toArray(), $this->tableSchema['columns']),
            // [TODO]
            'row_actions' => [],
            'table_actions' => []
        ];
    }
}