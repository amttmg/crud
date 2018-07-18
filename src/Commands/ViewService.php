<?php

namespace AmtTmg\CRUD\Commands;


use AmtTmg\CRUD\Constants\Field;
use Hamcrest\Thingy;
use Illuminate\Filesystem\Filesystem;

class ViewService
{
    private $layout        = 'app';
    private $createStubUrl = __DIR__.'/../resources/views/crud/views/create.stub';
    private $editStubUrl   = __DIR__.'/../resources/views/crud/views/edit.stub';
    private $indexStubUrl  = __DIR__.'/../resources/views/crud/views/index.stub';
    private $formStubUrl   = __DIR__.'/../resources/views/crud/views/form.stub';

    private $inputText = __DIR__.'/../resources/views/crud/views/inputs/text.stub';
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * ViewService constructor.
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    private function getViewPath($model, $fileName)
    {
        $viewPath = config('view.paths')[0].'/'.strtolower(str_plural($model));
        if (!$this->filesystem->exists($viewPath)) {
            $this->filesystem->makeDirectory($viewPath);
            if (!$this->filesystem->exists($viewPath.'/partials')) {
                $this->filesystem->makeDirectory($viewPath.'/partials');
            }
        }

        return $viewPath.'/'.$fileName;
    }

    private function generateFieldsForForm($fields)
    {
        $temp = '';
        foreach ($fields as $field) {
            if ($field['type'] == Field::TEXT) {
                $template = $this->filesystem->get($this->inputText);
                $temp     .= str_replace(['@fieldNameSmall', '@fieldNameCapital'], [strtolower($field['field']), ucfirst($field['field'])], $template);
            }
        }

        return $temp;
    }

    public function makeCreateView($model)
    {
        $template = $this->filesystem->get($this->createStubUrl);
        $template = Helper::replaceKeyWords($template, $model, ['@layout' => $this->layout]);
        $this->filesystem->put($this->getViewPath($model, 'create.blade.php'), $template);
    }

    public function makeEditView($model)
    {
        $template = $this->filesystem->get($this->editStubUrl);
        $template = Helper::replaceKeyWords($template, $model, ['@layout' => $this->layout]);
        $this->filesystem->put($this->getViewPath($model, 'edit.blade.php'), $template);
    }

    public function makeFormView($model, $fields)
    {
        $template = $this->filesystem->get($this->formStubUrl);
        $template = Helper::replaceKeyWords($template, $model, ['@fields' => $this->generateFieldsForForm($fields)]);
        $this->filesystem->put($this->getViewPath($model, 'partials/form.blade.php'), $template);
    }

    public function makeIndexView($model, $fields)
    {
        $template = $this->filesystem->get($this->indexStubUrl);
        $template = Helper::replaceKeyWords($template, $model, ['@layout' => $this->layout, '@tableHeader' => Helper::getTableHeaders($fields), '@tableBody' => Helper::getTableBody($model, $fields)]);
        $this->filesystem->put($this->getViewPath($model, 'index.blade.php'), $template);
    }
}
