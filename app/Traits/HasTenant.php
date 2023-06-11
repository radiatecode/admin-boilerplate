<?php

namespace App\Traits;

use App\Models\Scopes\MultiTenancyScope;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;

trait HasTenant
{
    protected static function bootHasTenant()
    {

        if (auth()->check()) {
            static::creating(function (Model $model) {
                $model->tenant_id = auth()->user()->tenant_id;
            });

            static::addGlobalScope(new MultiTenancyScope());
        }
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
