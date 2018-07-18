<?php

namespace AmtTmg\CRUD\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GenerateCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:generate
    {class}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var CommandService
     */
    private $commandService;
    /**
     * @var ViewService
     */
    private $viewService;

    /**
     * Create a new command instance.
     *
     * @param CommandService $commandService
     * @param ViewService    $viewService
     */
    public function __construct(CommandService $commandService, ViewService $viewService)
    {
        parent::__construct();
        $this->commandService = $commandService;
        $this->viewService    = $viewService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $class         = $this->argument('class');
        $crud          = app("App\\CrudGenerator\\".$class);
        $fields        = $crud->fields();
        $modelSingular = str_singular($crud->model());
        $modelPlural   = str_plural($crud->model());
        $fieldsName    = array_pluck($fields, 'field');

        foreach ($fieldsName as &$value) {
            $value = "'$value'";
        }
        $fieldsCommaSeparated = implode(', ', $fieldsName);

        $this->commandService->makeModel($modelSingular, $fieldsCommaSeparated);
        $this->commandService->makeController($modelSingular);
        $this->commandService->makeService($modelSingular);
        $this->commandService->makeRequest($modelSingular, $fields);
        $this->commandService->makeMigration($modelSingular, $fields);
        $this->viewService->makeCreateView($modelSingular);
        $this->viewService->makeEditView($modelSingular);
        $this->viewService->makeFormView($modelSingular, $fields);
        $this->viewService->makeIndexView($modelSingular, $fields);
    }
}
