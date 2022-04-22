<?php


namespace App\Traits;


use App\Models\Tenant;

trait HasTenant
{
    public function tenant(){
        return $this->belongsTo(Tenant::class,'tenant_id');
    }
}
