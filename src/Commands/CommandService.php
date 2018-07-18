<?php

namespace AmtTmg\CRUD\Commands;

use AmtTmg\CRUD\Constants\Field;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;

class CommandService
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    private $modelStubUrl      = __DIR__.'/../resources/views/crud/model.stub';
    private $controllerStubUrl = __DIR__.'/../resources/views/crud/controller.stub';
    private $serviceStubUrl    = __DIR__.'/../resources/views/crud/service.stub';
    private $requestStubUrl    = __DIR__.'/../resources/views/crud/request.stub';
    private $migrationStubUrl  = __DIR__.'/../resources/views/crud/migration.stub';


    private $inputText = __DIR__.'/../resources/views/crud/views/inputs/text.stub';

    /**
     * CommandService constructor.
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function getModelPath($model)
    {
        return 'app/'.$model.'.php';
    }

    public function getControllerPath($model)
    {
        return 'app/Http/Controllers/'.$model.'Controller.php';
    }

    public function getServicePath($model)
    {
        return 'app/Services/'.$model.'Services.php';
    }

    public function getRequestPath($model)
    {
        return 'app/Http/Requests/'.$model.'Request.php';
    }

    public function getMigrationPath($model)
    {
        return 'database/migrations/'.Carbon::now()->format('Y_m_d_His').'_create_'.str_plural($model).'_table.php';
    }

    public function makeModel($model, $fields)
    {
        $template = $this->filesystem->get($this->modelStubUrl);
        $template = str_replace(['@modelCapital', '@fields'], [ucfirst($model), $fields], $template);
        $this->filesystem->put($this->getModelPath($model), $template);
    }

    public function makeController($model)
    {
        $template = $this->filesystem->get($this->controllerStubUrl);
        $template = str_replace(['@modelCapital', '@modelSmall', '@modelPlural'], [ucfirst($model), strtolower($model), strtolower(str_plural($model))], $template);
        $this->filesystem->put($this->getControllerPath($model), $template);
    }

    public function makeService($model)
    {
        $template = $this->filesystem->get($this->serviceStubUrl);
        $template = str_replace(['@modelCapital', '@modelSmall'], [ucfirst($model), strtolower($model)], $template);
        $this->filesystem->put($this->getServicePath($model), $template);
    }

    public function makeRequest($model, $fields)
    {
        $template = $this->filesystem->get($this->requestStubUrl);
        $template = str_replace(['@modelCapital', '@fields'], [ucfirst($model), $this->generateFieldsForRequest($fields)], $template);
        $this->filesystem->put($this->getRequestPath($model), $template);
    }

    public function makeMigration($model, $fields)
    {
        $fields = $this->generateFieldsForMigration($fields);

        $model    = str_plural($model);
        $template = $this->filesystem->get($this->migrationStubUrl);
        $template = str_replace(['@modelCapital', '@modelSmall', '@fields'], [ucfirst($model), strtolower($model), $fields], $template);
        $this->filesystem->put($this->getMigrationPath($model), $template);
    }

    public function makeViews($model, $fields)
    {

    }

    private function generateFieldsForMigration($fields)
    {
        $master = [];
        foreach ($fields as $field) {
            $str = '$table->'.$field['migration'].'(\''.$field['field'].'\')';

            if ($field['null']) {
                $str .= '->nullable()';
            }
            $str .= ';';
            array_push($master, $str);
        }

        return implode('
        ', $master);
    }

    private function generateFieldsForRequest($fields)
    {
        $master = [];
        foreach ($fields as $field) {
            $str = '\''.$field['field'].'\'=>\''.$field['rule'].'\',';
            array_push($master, $str);
        }

        return implode('
        ', $master);
    }
}
