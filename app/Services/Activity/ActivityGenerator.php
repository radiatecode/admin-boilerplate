<?php


namespace App\Services\Activity;


use Illuminate\Database\Eloquent\Model;

class ActivityGenerator
{
    protected array $createEvent = [];

    protected array $updateEvent = [];

    protected array $deleteEvent = [];

    protected string $icon = '';

    protected string $url = '#';

    protected Model $model;

    public static function instance(): ActivityGenerator
    {
        return new self();
    }

    public function model(Model $model): ActivityGenerator
    {
        $this->model = $model;

        return $this;
    }

    public function icon(string $icon): ActivityGenerator
    {
        $this->icon = $icon;

        return $this;
    }

    public function url(string $url): ActivityGenerator
    {
        $this->url = $url;

        return $this;
    }

    public function create(string $activity, string $details): ActivityGenerator
    {
        $this->createEvent = [
            'activity' => $activity,
            'details' => $details
        ];

        return $this;
    }

    public function update(string $activity, string $details): ActivityGenerator
    {
        $changes = $this->model->getDirty();

        $columns = array_keys($changes);

        $this->updateEvent = [
            'activity' => $activity,
            'details' => $details . ' <br>Following fileds are modified: <b>' . implode(", ", $columns) . "</b>"
        ];

        return $this;
    }

    public function delete(string $activity, string $details): ActivityGenerator
    {
        $this->deleteEvent = [
            'activity' => $activity,
            'details' => $details
        ];

        return $this;
    }

    /**
     * @param string $identicalAttribute
     * @return array
     */
    public function autoBuild(string $identicalAttribute): array
    {
        $name = class_basename($this->model);

        $this->create(
            $name . ' Created',
            "A " . strtolower($name) . " has been created, named : " . $this->model->{$identicalAttribute}
        )->update(
            $name . ' Updated',
            'A ' . strtolower($name) . ' has been updated to : ' . $this->model->{$identicalAttribute}
        )->delete(
            $name . ' Deleted',
            'A ' . strtolower($name) . ' name with [' . $this->model->{$identicalAttribute} . '] has been deleted'
        );

        return $this->build();
    }

    /**
     * @return array
     */
    public function build(): array
    {
        return [
            'create' => array_merge($this->createEvent, ['icon' => $this->icon, 'url' => $this->url]),
            'update' => array_merge($this->updateEvent, ['icon' => $this->icon, 'url' => $this->url]),
            'delete' => array_merge($this->deleteEvent, ['icon' => $this->icon, 'url' => '#'])
        ];
    }
}
