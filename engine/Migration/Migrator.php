<?php

namespace Engine\Migration;

class Migrator
{
    public $migrations = [];
    public $tables = [];
    public $queries = [];

    /**
     * Create a new migration
     * 
     * @param string $name
     * @return Table
     */
    public function table($name)
    {
        $this->tables[$name] = new Table($name);

        return $this->tables[$name];
    }

    /**
     * Set up the queries
     * 
     * @return void
     */
    public function setUpQueries()
    {
        foreach ($this->tables as $table) {
            $query = "CREATE TABLE {$table->name} (" . PHP_EOL;
            foreach ($table->columns as $column) {
                if (!isset($column['name']) || !isset($column['type'])) {
                    continue;
                }
                $query .= "{$column['name']} {$column['type']}";
                if (isset($column['max'])) {
                    $query .= "({$column['max']})";
                }
                if (isset($column['auto_increment'])) {
                    $query .= " AUTO_INCREMENT";
                }
                if (isset($column['primary'])) {
                    $query .= " PRIMARY KEY";
                }
                if (isset($column['nullable'])) {
                    $query .= " NULL";
                }
                $query .= "," . PHP_EOL;
            }
            $query = rtrim($query, ',' . PHP_EOL);
            $query .= PHP_EOL . ");" . PHP_EOL;
            $this->queries[] = $query;
            // echo $query . PHP_EOL . PHP_EOL;
        }
    }

    /**
     * Set down the queries
     * 
     * @return void
     */
    public function setDownQueries()
    {
        $query = '';
        foreach ($this->tables as $table) {
            $query .= "DROP TABLE {$table->name};" . PHP_EOL;
            $this->queries[] = $query;
        }
    }

    /**
     * Run the migration
     * 
     * @return void
     */
    public function migrate()
    {
        $this->run();
        $this->setUpQueries();
        foreach ($this->queries as $query) {
            $this->runQuery($query);
        }
    }

    /**
     * Rollback the migration
     * 
     * @return void
     */
    public function rollback()
    {
        $this->run();
        $this->setDownQueries();
        foreach ($this->queries as $query) {
            $this->runQuery($query);
        }
    }

    /**
     * Run the query
     * 
     * @param string $query
     * @return void
     */
    public function runQuery($query)
    {
        $db = $GLOBALS['db'];
        $db->query($query);
    }

    /**
     * Get all migrations
     */
    public function run()
    {
    }
}
