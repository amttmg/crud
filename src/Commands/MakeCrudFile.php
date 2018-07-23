<?php

namespace AmtTmg\CRUD\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * Class MakeCrudFile
 * @package AmtTmg\CRUD\Commands
 */
class MakeCrudFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud
    {model}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var Filesystem
     */
    private $filesystem;


    /**
     * MakeCrudFile constructor.
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $model    = $this->argument('model');
        $template = $this->filesystem->get(__DIR__.'/../resources/views/crud/views/crud.stub');
        $template = Helper::replaceKeyWords($template, $model);
        $this->filesystem->put($this->getPath($model), $template);
    }

    private function getPath($model)
    {
        $path = 'app/CrudGenerator';
        if (!$this->filesystem->exists($path)) {
            $this->filesystem->makeDirectory($path);
        }

        return $path.'/'.$model.'Crud.php';
    }
}
