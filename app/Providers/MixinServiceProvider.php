<?php

namespace App\Providers;

use App\Mixins\BlueprintMixins;
use App\Mixins\DatatableMixins;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;
use ReflectionException;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\DataTables;

class MixinServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws ReflectionException
     */
    public function boot()
    {
        Blueprint::mixin(new BlueprintMixins());
        DataTableAbstract::mixin(new DatatableMixins());
    }
}
