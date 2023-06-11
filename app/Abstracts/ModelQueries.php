<?php

namespace App\Abstracts;

use App\Exceptions\DataNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder as QueryBuilder;

class ModelQueries
{
    private Model $modelClass;
    protected Builder $model;
    protected QueryBuilder $table;

    public function __construct($modelClass)
    {
        if (!class_exists($modelClass)) {
            throw new ModelNotFoundException('Class [' . $modelClass . '] is not found');
        }

        $this->modelClass =  new $modelClass();

        $this->model = $this->modelClass->newQuery();

        $this->table = DB::table($this->modelClass->getTable());
    }

    public function findById($id)
    {
        return $this->model->findOr(
            $id,
            fn () => throw DataNotFoundException::for(class_basename($this->modelClass))
        );
    }

    public function findByUuid(string $uuid)
    {
        return $this->model->where('uuid', $uuid)->firstOr(
            fn () => throw DataNotFoundException::for(class_basename($this->modelClass))
        );
    }
}
