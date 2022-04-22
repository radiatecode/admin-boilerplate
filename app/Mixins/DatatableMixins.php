<?php


namespace App\Mixins;


use Carbon\Carbon;
use Closure;

class DatatableMixins
{
    public function upsertTimeToLocal(): Closure
    {
        return function (){
            return $this->editColumn('created_at', function ($row) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at, config('app.timezone'))
                        ->setTimezone('Asia/Dacca');
                })->editColumn('updated_at', function ($row) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $row->updated_at, config('app.timezone'))
                        ->setTimezone('Asia/Dacca');
                });
        };
    }
}