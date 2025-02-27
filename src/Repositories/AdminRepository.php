<?php
namespace Laililmahfud\Adminportal\Repositories;

class AdminRepository
{
     public $model;

     public function findByUuid($uuid)
     {
          return $this->model::query()->where('uuid', $uuid)->firstOrFail();
     }
}