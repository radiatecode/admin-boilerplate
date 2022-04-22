<?php


namespace App\Contracts;


use Illuminate\Database\Eloquent\Relations\MorphMany;

interface WithActivity
{
    public function activity(): array;

    public function activities(): MorphMany;
}
