<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class MakeActionCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:action {name} {--dto=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an action class';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $this->makeActionClass();

        $this->info('Action created successfully.');

        return Command::SUCCESS;
    }

    /**
     * @throws FileNotFoundException
     */
    protected function makeActionClass(): bool
    {
        $name = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($name);

        if ((!$this->hasOption('force') ||
                !$this->option('force')) &&
            $this->alreadyExists($this->getNameInput())
        ) {
            $this->error($this->type . ' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($name)));

        return true;
    }

    protected function buildClass($name)
    {
        $option = $this->option('dto');

        if ($option) {
            $namespace = 'use App\\DTOs\\' . str_replace("/", "\\", $option) . ';';

            $baseName = explode("/", $option);

            $class = $baseName[count($baseName) - 1];

            $replace = [
                "{{ DTOnamespace }}" => $namespace,
                "{{ DTOarg }}" => $class . ' ' . '$' . lcfirst($class)
            ];

            return str_replace(
                array_keys($replace),
                array_values($replace),
                parent::buildClass($name)
            );
        }

        $replace = [
            "{{ DTOnamespace }}" => '',
            "{{ DTOarg }}" => ''
        ];

        return str_replace(
            array_keys($replace),
            array_values($replace),
            parent::buildClass($name)
        );
    }

    protected function getStub()
    {
        return $this->resolveStubPath('stubs/Action.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Actions';
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param string $stub
     *
     * @return string
     */
    protected function resolveStubPath(string $stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }
}
