<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use InvalidArgumentException;

class Select2Service
{
    protected LengthAwarePaginator $pagniateResult;
    protected array $mapData = [];

    public function __construct(protected int $page, protected int $perPage = 25)
    {
    }

    public static function make(int $page, int $perPage = 25)
    {
        return new self($page, $perPage);
    }

    /**
     * Query to render the select2 results
     *
     * @param Builder|QueryBuilder|callable $query
     */
    public function query($query): Select2Service
    {
        if (is_callable($query)) {
            $query = $query();
        }

        if (!$query instanceof Builder && !$query instanceof QueryBuilder) {
            throw new InvalidArgumentException('Query arg is invalid!');
        }

        $this->pagniateResult = $query->paginate($this->perPage);

        return $this;
    }

    /**
     * Map the data to transform into select2 data
     *
     * @param callable $map
     * @return Select2Service
     */
    public function map(callable $map): Select2Service
    {
        foreach ($this->pagniateResult as $item) {
            $mapData = $map($item);

            if (is_array($mapData)) {
                $this->mapData[] = $mapData;
            }
        }

        return $this;
    }

    public function result()
    {
        return $this->response($this->mapData, $this->page, $this->pagniateResult->total());
    }

    protected function response($results, $page, $total): array
    {
        return [
            'results' => $results,
            'pagination' => [
                'more' => ($page * 25) < $total,
            ],
        ];
    }
}
