<?php

namespace Laililmahfud\Adminportal\Traits;

trait HasDatatable
{
    public function scopeDatatable($query, $perpage = 10, $defaultSortField = "created_at")
    {
        $filter_column = request('filter_column') ?: [];
        $sortField = array_keys($filter_column)[0] ?? $defaultSortField;
        $sortDirection = array_values($filter_column)[0] ?? 'desc';

        $query->orderBy($sortField, $sortDirection);
        if ($perpage) {
            $start = request('start') ?: null;
            $length = request('length') ?: null;
            if ($start && $length) {
                $page = ($start / $length) + 1;
                return $query->paginate($perpage, ["*"], "page", $page);
            }
            return $query->paginate($perpage);
        } else {
            return $query->get();
        }
    }
}
