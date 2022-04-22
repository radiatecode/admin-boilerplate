<?php

namespace App\Traits;

use ErrorException;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use App\Services\Activity\ActivityService;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasActivity
{
    public function activities(): MorphMany{
        return $this->morphMany(Activity::class,'activitiesable');
    }

    /**
     * @throws ErrorException
     */
    public static function bootHasActivity(){
        static::created(
            function (Model $model) {
                ActivityService::instance()->model($model)->event('create');
            }
        );

        static::updated(
            function (Model $model) {
                ActivityService::instance()->model($model)->event('update');
            }
        );

        static::deleted(
            function (Model $model) {
                ActivityService::instance()->model($model)->event('delete');
            }
        );
    }
}
