<?php

namespace Engine\Console;

class Console extends Kernel
{
    use TableConfiguration;

    /**
     * The available commands
     * 
     * @var array
     */
    protected $commands = [
        'new:crud' => 'newCrud',
        'new:controller' => 'newController',
        'new:model' => 'newModel',
        'new:migration' => 'newMigration',
        'serve' => 'serve',
    ];

    /**
     * Execute the serve command
     * 
     * @return void
     */
    public function serve()
    {
        $this->runCommand('php -S localhost:8000 -t public');
    }

    /**
     * Execute the new:model command
     * 
     * @return void
     */
    public function newModel()
    {
        $name = Logger::ask('Model name: ');

        if (Logger::confirm('Do you want to create a migration for this model?')) {
            $this->newMigration($name);
        }
    }

    /**
     * Execute the new:migration command
     * 
     * @return void
     */
    public function newMigration(string $tableName = '')
    {
        $name = 'create_' . $tableName . '_table';
        $table = [];

        if (empty($tableName)) {
            $name = Logger::ask('Migration name: ');
            $tableName = Logger::ask('Table name: ');
        }

        if (Logger::confirm('Do you want to configure the table?')) {
            $table = $this->configureTable($tableName);
        }
        $this->createMigration($name, $tableName, $table);
    }

    /**
     * Create a new migration
     * 
     * @param string $name
     * @param string $tableName
     * @param array $table
     * @return void
     */
    public function createMigration(string $name, string $tableName, array $table)
    {
        $this->copyFileFromStub('migration', __DIR__ . '/app/Database/Migrations/' . $name . '.php', [
            '{{name}}' => str($name)->studlyCase(),
            '{{table}}' => str($tableName)->plural()->snakeCase(),
            '{{columns}}' => $table,
        ]);
    }
}
