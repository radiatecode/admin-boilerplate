<?php


namespace App\Mixins;


use Closure;

class BlueprintMixins
{
    /**
     * Ownership columns for migration
     *
     * @return Closure
     */
    public function ownerships(){
        return function (){
            $this->integer('created_by')->nullable();
            $this->integer('updated_by')->nullable();
        };
    }
}
