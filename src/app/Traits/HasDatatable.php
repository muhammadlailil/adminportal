<?php

namespace Laililmahfud\Adminportal\Traits;

trait HasDatatable
{
    public function scopeDatatable($query, $perPage = 10, $defaultSortField = "created_at")
    {
        $filter_column = request('filter_column') ?: [];
        $sortField = array_keys($filter_column)[0] ?? $defaultSortField;
        $sortDirection = array_values($filter_column)[0] ?? 'desc';

        $query->orderBy($sortField, $sortDirection);
        if ($perPage) {
            $start = request('start') ?: null;
            $length = request('length') ?: null;
            if ($start && $length) {
                $page = ($start / $length) + 1;
                return $query->paginate($perPage, ["*"], "page", $page);
            }
            return $query->paginate($perPage);
        } else {
            return $query->get();
        }
    }
}
