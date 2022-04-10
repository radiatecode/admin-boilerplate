<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;

class RepositoryMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name} {--interface=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a repository';

    /**
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * The name of class being generated.
     * Default class
     *
     * @var string
     */
    private $defaultFileType = 'class';

    /**
     * How many types of file will be created
     *
     * @var string[]
     */
    private $fileTypes = [
        'interface', 'class'
    ];

    /**
     * The name of class being generated.
     *
     * @var string
     */
    private $repositoryClass;

    /**
     * The name of interface being generated.
     *
     * @var string
     */
    private $repositoryInterface;

    /**
     * Replace repository class implemented interface name
     *
     * @var string
     */
    private $replaceImplementedName;

    /**
     * Execute the console command.
     *
     * @return int
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $this->setRepository();

        if ($this->option('interface') == 0) { // without interface
            $this->fileCreate($this->repositoryClass);
        } else { // with interface
            foreach ($this->fileTypes as $val) {
                $this->defaultFileType = $val;
                $name = $this->defaultFileType == 'interface' ? $this->repositoryInterface : $this->repositoryClass;
                $this->fileCreate($name);
            }
        }

        $this->info($this->type . ' created successfully.');

        $this->line("<info>Created Repository :</info> $this->repositoryClass");
    }

    /**
     * Create file from stub files
     *
     * @param $name
     *
     * @return false
     * @throws FileNotFoundException
     */
    protected function fileCreate($name): bool
    {
        $path = $this->getPath($name);

        if ((!$this->hasOption('force') ||
                !$this->option('force')) &&
            $this->alreadyExists($name)) {
            $this->error($this->type . ' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($name)));

        return true;
    }



    /**
     * Set repository class & interface name
     */
    private function setRepository()
    {
        $this->replaceImplementedName = $this->argument('name') . 'Interface';

        $repoName = $this->qualifyClass($this->getNameInput());

        $this->repositoryClass = $repoName . 'Repository';

        $this->repositoryInterface = $repoName . 'Interface';

        return $this;
    }

//    /**
//     * Replace the class name for the given stub.
//     *
//     * @param string $stub
//     * @param string $name
//     * @return string
//     */
//    protected function replaceClass($stub, $name)
//    {
//        if (!$this->argument('name')) {
//            throw new InvalidArgumentException("Missing required argument name");
//        }
//
//        $stub = parent::replaceClass($stub, $name);
//
//        // replace the interface name in repository class
//        if ($this->option('interface') == 1) { // with interface
//            $interfaceRemoveDir = explode('/', $this->replaceImplementedName);
//            return str_replace(['DummyInterface', '{{ interface }}', '{{interface}}'], 'implements ' . $interfaceRemoveDir[count($interfaceRemoveDir) - 1], $stub);
//        }
//        return str_replace(['DummyInterface', '{{ interface }}', '{{interface}}'], '', $stub); // without interface
//    }


    protected function buildClass($name)
    {
        $replace = [
            "{{ DummyModelClass }}" => $this->argument('name'),
            "{{ DummyQueryClass }}" => $this->argument('name').'Queries'
        ];

        // replace the interface name in repository class
        if ($this->option('interface') == 1) { // with interface
            $interfaceRemoveDir = explode('/', $this->replaceImplementedName);

            $replace["{{interface}}"] = 'implements ' . $interfaceRemoveDir[count($interfaceRemoveDir) - 1];
        }else{ // without interface
            $replace["{{interface}}"] = '';
        }

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    protected function getStub()
    {
        return $this->defaultFileType === 'interface' ? base_path('stubs/Repositories/Interface.stub') :
            base_path('stubs/Repositories/Repository.stub');
    }

    /**
     * Get the default namespace for the class.
     * this help to create a folder based on namespace
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repositories';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the repository class.'],
        ];
    }
}
