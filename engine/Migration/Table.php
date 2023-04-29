<?php

namespace Engine\Migration;

class Table
{
    /**
     * The table name
     * 
     * @var string
     */
    public $name = '';

    /**
     * The table columns
     * 
     * @var array
     */
    public $columns = [];

    /**
     * Create a new table
     * 
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Create a new column
     * 
     * @param string $name
     * @param string $type
     * @return void
     */
    public function create($callback)
    {
        $columns = new Column();
        $callback($columns);

        $this->columns = $columns->columns;
    }
}
