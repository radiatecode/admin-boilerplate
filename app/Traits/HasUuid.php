<?php

namespace App\Traits;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUuid
{
    protected static function bootHasUuid()
    {
        if (auth()->check()) {
            static::creating(function (Model $model) {
                $model->uuid = Str::uuid();
            });
        }
    }

    public function scopeWhereUuid($query, string $uuid)
    {
        return $query->where('uuid', $uuid);
    }

    public function scopeFindByUuid($query, string $uuid, $columns = ['*'])
    {
        return $query->where('uuid', $uuid)->first($columns);
    }

    public function scopeFindByUuidOrFail($query, string $uuid, $columns = ['*'])
    {
        return $query->where('uuid', $uuid)->firstOrFail($columns);
    }

    public function scopeFindByUuidOr($query, string $uuid, $columns = ['*'], Closure $callback = null)
    {
        return $query->where('uuid', $uuid)->firstOr($columns, $callback);
    }
}
