<?php
namespace Laililmahfud\Adminportal\Repositories;

class AdminRepository
{
     public $model;

     public function findByUuid($uuid)
     {
          return $this->model::query()->where('uuid', $uuid)->firstOrFail();
     }

     public function firstOrFail($id)
     {
          return $this->model::query()->where('id', $id)->firstOrFail();
     }

     public function deleteByListId(array $id)
     {
          return $this->model::query()
               ->whereIn('id', $id)
               ->delete();
     }

     public function delete($id)
     {
          return $this->model::query()
               ->where('id', $id)
               ->delete();
     }
}