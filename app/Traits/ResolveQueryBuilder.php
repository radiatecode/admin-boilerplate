<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;

trait ResolveQueryBuilder
{
    private $builder = null;

    public static function query()
    {
        return new self();
    }

    protected function builder(): Builder
    {
        if ($this->builder){
            return $this->builder;
        }

        return  $this->builder = $this->resolveBuilder();
    }

    protected function resolveBuilder(): Builder
    {
        $class = class_basename(__CLASS__);

        $model = str_replace('Queries','',$class);

        $namespace = "App\Models\\".$model;

        return (new $namespace())->newQuery();
    }
}
