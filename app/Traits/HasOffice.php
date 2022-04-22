<?php


namespace App\Traits;


use App\Models\Office;

trait HasOffice
{
    public function office(){
        return $this->belongsTo(Office::class,'office_id');
    }
}
