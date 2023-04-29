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

        $this->createModel($name);

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
        $name = 'create_' . str($tableName)->plural()->snakeCase() . '_table';
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
     * Execute the new:controller command
     * 
     * @return void
     */
    public function newController()
    {
        $name = Logger::ask('Controller name: ');
        $this->createController($name);
    }

    /**
     * Create a new migration
     * 
     * @param string $name
     * @param string $tableName
     * @param string $table
     * @return void
     */
    public function createMigration(string $name, string $tableName, string $table)
    {
        $this->copyFileFromStubThenPutInFile('migration_cell', $this->appDir . 'Database/Migrations/Migration.php', [
            '{{table}}' => str($tableName)->plural()->snakeCase(),
            '{{columns}}' => $table,
        ], 2, true);
    }

    /**
     * Create a new model
     * 
     * @param string $name
     * @return void
     */
    public function createModel(string $name)
    {
        $this->copyFileFromStub('model',  $this->appDir . 'Database/Models/' . $name . '.php', [
            '{{name}}' => str($name)->studlyCase(),
        ]);
    }

    /**
     * Create a new controller
     * 
     * @param string $name
     * @return void
     */
    public function createController(string $name)
    {
        $this->copyFileFromStub('controller',  $this->appDir . 'Controllers/' . $name . 'Controller.php', [
            '{{controller}}' => str($name)->studlyCase(),
        ]);
    }
}
