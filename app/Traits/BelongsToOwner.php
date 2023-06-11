<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait BelongsToOwner
{
    protected static function bootBelongsToOwner()
    {
        if (auth()->check()) {
            static::creating(function (Model $model) {
                $model->created_by = auth()->id();
            });

            static::updating(function (Model $model) {
                $model->updated_by = auth()->id();
            });
        }
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopeCreatorAware($query)
    {
        return $query->where('created_by', auth()->id());
    }

    public function scopeUpdaterAware($query)
    {
        return $query->where('updated_by', auth()->id());
    }
}
