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

    private $modelStubUrl;
    private $controllerStubUrl;
    private $serviceStubUrl;
    private $requestStubUrl;
    private $migrationStubUrl;


    private $inputText;

    /**
     * CommandService constructor.
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        if (config('crud.use_default_template')) {
            $path = __DIR__.'/../resources';
        } else {
            $path = resource_path();
        }

        $this->modelStubUrl      = $path.'/views/crud/model.stub';
        $this->controllerStubUrl = $path.'/views/crud/controller.stub';
        $this->serviceStubUrl    = $path.'/views/crud/service.stub';
        $this->requestStubUrl    = $path.'/views/crud/request.stub';
        $this->migrationStubUrl  = $path.'/views/crud/migration.stub';
        $this->inputText         = $path.'/views/crud/views/inputs/text.stub';
    }

    public function getModelPath($model)
    {
        return config('crud.model_path').$model.'.php';
    }

    public function getControllerPath($model)
    {
        return config('crud.controller_path').$model.'Controller.php';
    }

    public function getServicePath($model)
    {
        return config('crud.service_path').$model.'Services.php';
    }

    public function getRequestPath($model)
    {
        return config('crud.request_path').$model.'Request.php';
    }

    public function getMigrationPath($model)
    {
        return config('crud.migration_path').Carbon::now()->format('Y_m_d_His').'_create_'.str_plural($model).'_table.php';
    }

    public function makeModel($model, $fields)
    {
        $template = $this->filesystem->get($this->modelStubUrl);
        $template = Helper::replaceKeyWords($template, $model, $fields, config('crud.model_namespace'));
        $this->filesystem->put($this->getModelPath($model), $template);
    }

    public function makeController($model)
    {
        $template = $this->filesystem->get($this->controllerStubUrl);
        $template = Helper::replaceKeyWords($template, $model, null, config('crud.controller_namespace'));
        $this->filesystem->put($this->getControllerPath($model), $template);
    }

    public function makeService($model)
    {
        $template = $this->filesystem->get($this->serviceStubUrl);
        $template = Helper::replaceKeyWords($template, $model, null, config('crud.service_namespace'));
        $this->filesystem->put($this->getServicePath($model), $template);
    }

    public function makeRequest($model, $fields)
    {
        $template = $this->filesystem->get($this->requestStubUrl);
        $template = Helper::replaceKeyWords(
            $template,
            $model,
            $this->generateFieldsForRequest($fields),
            config('crud.request_namespace'));
        $this->filesystem->put($this->getRequestPath($model), $template);
    }

    public function makeMigration($model, $fields)
    {
        $fields = $this->generateFieldsForMigration($fields);

        $model    = str_plural($model);
        $template = $this->filesystem->get($this->migrationStubUrl);
        $template = Helper::replaceKeyWords($template, $model, $fields);
        $this->filesystem->put($this->getMigrationPath($model), $template);
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
