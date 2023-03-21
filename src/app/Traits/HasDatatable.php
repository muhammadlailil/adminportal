<?php
namespace Laililmahfud\Adminportal\Traits;

use Laililmahfud\Adminportal\JsTableResources\UserJsTableResources;

trait HasDatatable
{
    public function scopeDatatable($query,$perpage=10,$defaultSortField = "created_at")
    {
        $filter_column = request('filter_column') ?:[];
        $sortField = array_keys($filter_column)[0] ?? $defaultSortField;
        $sortDirection = array_values($filter_column)[0] ?? 'desc';

        $query->orderBy($sortField,$sortDirection);
        if($perpage){
            return $query->paginate($perpage);
        }else{
            return $query->get();
        }
    }

    public function scopeJstable($query,$defaultSortField = "created_at")
    {
        // $filter_column = request('filter_column') ?:[];
        // $sortField = array_keys($filter_column)[0] ?? $defaultSortField;
        // $sortDirection = array_values($filter_column)[0] ?? 'desc';

        // $query->orderBy($sortField,$sortDirection);
        // if($perpage){
        //     return $query->paginate($perpage);
        // }else{
        //     return $query->get();
        // }

        $start = request('start');
        $length = request('length');
        $total = $query->clone()->count();
        $data = $query->clone()->limit($length)->offset($start)->get();
        return (object)[
            'items' =>  $data,
            'total' => $total
        ];
    }
}
