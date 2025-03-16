<?php
namespace Laililmahfud\Adminportal\Repositories;

class AdminRepository
{
     public $model;

     public function findByUuid($uuid)
     {
          return $this->model::query()->where('uuid', $uuid)->firstOrFail();
     }

     public function deleteByListId(array $id)
     {
          return $this->model::query()
               ->whereIn('id', $id)
               ->delete();
     }

     public function deleteByUuid($uuid)
     {
          return $this->model::query()
               ->where('uuid', $uuid)
               ->delete();
     }
}