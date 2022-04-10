<?php


namespace App\Console\Commands;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class MakeCrudBoilerplateCommand extends GeneratorCommand
{
    protected $indexBladePath;

    protected $signature = "make:crud {name}";

    protected $description = "This command will create model, migration, controller, repository, blade files";

    public function handle()
    {
        $name = $this->argument('name');

        Artisan::call('make:model '.$name.' -m');
        $this->info(Artisan::output());

        Artisan::call('make:query '.$name);
        $this->info(Artisan::output());

        Artisan::call('make:repository '.$name.'/'.$name);
        $this->info(Artisan::output());

        Artisan::call('make:request '.$name.'Request');
        $this->info(Artisan::output());

        $this->makeCrudBladeFile();
        $this->info('Crud blade files created successfully');

        $this->makeController();
        $this->info('Controller created successfully');

        return 0;
    }

    private function makeCrudBladeFile(){
        $folder = camelCaseToSnakeCase($this->argument('name'));

        $dir = resource_path('views/module/'.$folder);

        $createFile = resource_path('views/sample/create.blade.php');
        $editFile = resource_path('views/sample/edit.blade.php');
        $listFile = resource_path('views/sample/index.blade.php');

        mkdir($dir);

        File::copy($listFile,$dir.'/index.blade.php');
        File::copy($createFile,$dir.'/create.blade.php');
        File::copy($editFile,$dir.'/edit.blade.php');

        $this->indexBladePath = 'module.'.$folder.'.index';
    }

    /**
     * @return bool|null
     * @throws FileNotFoundException
     */
    protected function makeController(): bool
    {
        $name = $this->qualifyClass($this->getNameInput());

        $nameOfTheController = $name.'Controller';

        $path = $this->getPath($nameOfTheController);

        if ((! $this->hasOption('force') ||
                ! $this->option('force')) &&
            $this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($nameOfTheController)));

        return true;
    }

    protected function buildClass($name)
    {
        $controllerNamespace = $this->getNamespace($name);

        $replace = [
            "use {$controllerNamespace}\Controller;\n" => '',
            "{{ RequestClass }}" => $this->argument('name').'Request',
            "{{ RepoName }}" => $this->argument('name'),
            "{{ InterfaceName }}" => $this->argument('name').'Interface',
            "{{ index_blade_path }}" => "'".$this->indexBladePath."'"
        ];

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }


    protected function getStub()
    {
        return $this->resolveStubPath('stubs/Controller.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param string $stub
     *
     * @return string
     */
    protected function resolveStubPath(string $stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }
}
