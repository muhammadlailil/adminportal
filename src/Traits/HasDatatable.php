<?php
namespace Laililmahfud\Adminportal\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Query\Builder;

trait HasDatatable
{
     public function scopeSorting(Builder $query, string $sortBy, string $direction = "desc")
     {
          $sortBy = request('sortBy', $sortBy);
          $direction = request('sortDirection', $direction) == 'desc' ? 'desc' : 'asc';

          return $query->orderBy($sortBy, $direction);
     }

     public function scopeSearch(Builder $query, $columns)
     {
          $operator = config('database.default') == 'pgsql' ? 'ILIKE' : 'LIKE';
          return $query->when(request('search'), function ($query, $search) use ($columns, $operator) {
               $query->whereAny($columns, $operator, "%$search%");
          });
     }

     public function scopeFilter(Builder $query, $scopes)
     {
          if ($filters = request('filter')) {
               foreach ($filters as $key => $filter) {
                    $scope = @$scopes[$key];
                    if ($scope && $filter) {
                         $scope($query, $filter);
                    }
               }
          }
     }
}