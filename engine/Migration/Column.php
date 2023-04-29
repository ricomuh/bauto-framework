<?php

namespace Engine\Migration;

class Column
{
    /**
     * The columns
     * 
     * @var array
     */
    public $columns = [];

    /**
     * The current column
     * 
     * @var string
     */
    public $currentColumn = '';

    /**
     * The column types
     * 
     * @var array
     */
    public $columnTypes = [
        'id' => 'INT',
        'string' => 'VARCHAR',
        'integer' => 'INT',
        'boolean' => 'TINYINT',
        'datetime' => 'DATETIME',
        'text' => 'TEXT',
    ];

    /**
     * Get the column types
     * 
     * @return array
     */
    public static function getColumnTypes()
    {
        $column = new self();

        return $column->columnTypes;
    }

    /**
     * The id column type
     * 
     * @return self
     */
    public function id()
    {
        $this->columns[] = [
            'name' => 'id',
            'type' => 'INT',
            'auto_increment' => true,
            'primary' => true,
        ];

        $this->currentColumn = 'id';

        return $this;
    }

    /**
     * The string column type
     * 
     * @param string $name
     * @return self
     */
    public function string($name)
    {
        $this->columns[] = [
            'name' => $name,
            'type' => 'VARCHAR',
            'max' => 255,
        ];

        $this->currentColumn = $name;

        return $this;
    }

    /**
     * The integer column type
     * 
     * @param string $name
     * @return self
     */
    public function integer($name)
    {
        $this->columns[] = [
            'name' => $name,
            'type' => 'INT',
            'max' => 11,
        ];

        $this->currentColumn = $name;

        return $this;
    }

    /**
     * The boolean column type
     * 
     * @param string $name
     * @return self
     */
    public function boolean($name)
    {
        $this->columns[] = [
            'name' => $name,
            'type' => 'TINYINT',
            'max' => 1,
        ];

        $this->currentColumn = $name;

        return $this;
    }

    /**
     * The datetime column type
     * 
     * @param string $name
     * @return self
     */
    public function datetime($name)
    {
        $this->columns[] = [
            'name' => $name,
            'type' => 'DATETIME',
            'default' => 'CURRENT_TIMESTAMP',
        ];

        $this->currentColumn = $name;

        return $this;
    }

    /**
     * The text column type
     * 
     * @param string $name
     * @return self
     */
    public function text($name)
    {
        $this->columns[] = [
            'name' => $name,
            'type' => 'TEXT',
        ];

        $this->currentColumn = $name;

        return $this;
    }

    /**
     * The timestamps column type
     * 
     * @return self
     */
    public function timestamps()
    {
        $this->datetime('created_at');
        $this->datetime('updated_at');

        return $this;
    }

    /**
     * The foreignId column type
     * 
     * @param string $name
     * @return self
     */
    public function foreignId($name)
    {
        $this->columns[] = [
            'name' => $name,
            'type' => 'INT',
        ];

        $this->currentColumn = $name;

        return $this;
    }

    /**
     * Set the column as nullable
     * 
     * @return self
     */
    public function nullable()
    {
        $this->columns[$this->currentColumn]['nullable'] = true;

        return $this;
    }

    /**
     * Set the column max length
     * 
     * @param int $length
     * @return self
     */
    public function max($length)
    {
        $this->columns[$this->currentColumn]['length'] = $length;

        return $this;
    }
}
