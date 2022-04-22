<?php


namespace App\Services\Activity;


use ErrorException;
use App\Models\Activity;
use InvalidArgumentException;
use App\Contracts\WithActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ActivityService
{
    private Model $model;

    private bool $queue = false;

    public static function instance(): ActivityService
    {
        return new self();
    }

    /**
     * @param Model $model
     * @return $this
     */
    public function model(Model $model): ActivityService
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Use to set activity via event
     *
     * @param string $name // create, update, delete
     *
     * @return mixed
     * @throws ErrorException
     */
    public function event(string $name){
        if (! $this->model instanceof WithActivity){
            throw new ErrorException('Model does not implement the WithActivity Contract');
        }

        if ($this->queue){
            return dispatch(function () use ($name){
                $this->createActivity($name);
            });
        }

        return $this->createActivity($name);
    }

    /**
     * Used to set custom activity manually
     *
     * @param string $activity
     * @param string $details
     * @param string $url
     * @param string $icon
     *
     * @return Builder|Model|mixed
     */
    public function activity(string $activity,string $details = 'N/A', string $url = '#', string $icon = ''){

        $data = [
            'tenant_id' => auth()->user()->tenant_id,
            'icon' => $icon,
            'activity' => $activity,
            'details' => $details,
            'url' => $url
        ];

        if ($this->queue){
            return dispatch(function () use ($data){
                Activity::query()->create($data);
            });
        }

        return Activity::query()->create($data);
    }

    public function queue(): ActivityService
    {
        $this->queue = true;

        return $this;
    }


    protected function createActivity($name){
        $activity = $this->model->activity();

        if (! $activity){
            return null;
        }

        if (! array_key_exists($name,$activity)){
            throw new InvalidArgumentException('Event name is not found!');
        }

        return $this->model->activities()->create(
            array_merge($activity[$name],[
                'tenant_id' => auth()->user()->tenant_id
            ])
        );
    }
}
