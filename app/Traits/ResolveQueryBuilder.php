<?php


namespace App\Traits;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

trait ResolveQueryBuilder
{
    /**
     * @var Model $model
     */
    private Model $model;

    public static function query()
    {
        return new self();
    }

    protected function eloquentBuilder(): EloquentBuilder
    {
        $this->resolveBuilder();

        return  $this->model->newQuery();
    }

    protected function queryBuilder(): QueryBuilder
    {
        $this->resolveBuilder();

        return DB::table($this->model->getTable());
    }

    protected function resolveBuilder()
    {
        $class = class_basename(__CLASS__);

        $model = str_replace('Queries','',$class);

        $namespace = "App\Models\\".$model;

        $this->model = new $namespace();
    }
}
