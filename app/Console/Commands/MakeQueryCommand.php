<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class MakeQueryCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:query {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A seperated query class create for each model';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $this->makeQueryClass();

        $this->info('Query created successfully.');

        return 0;
    }

    /**
     * @throws FileNotFoundException
     */
    protected function makeQueryClass(): bool
    {
        $name = $this->qualifyClass($this->getNameInput());

        $nameOfTheQuery = $name.'Queries';

        $path = $this->getPath($nameOfTheQuery);

        if ((! $this->hasOption('force') ||
                ! $this->option('force')) &&
            $this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($nameOfTheQuery)));

        return true;
    }

    protected function getStub()
    {
        return $this->resolveStubPath('stubs/Queries.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Queries';
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
            : __DIR__.$stub;
    }
}
