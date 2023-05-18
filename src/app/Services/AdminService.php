<?php
namespace Laililmahfud\Adminportal\Services;


class AdminService
{
    public $model;
    
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function delete($id)
    {
        return $this->model::findOrFail($id)->delete();
    }

    public function findById($id)
    {
        return $this->model::findOrFail($id);
    }

    public function findByUuId($uuid)
    {
        return $this->model::whereUuid($uuid)->firstOrFail();
    }

    public function deleteByUuid($uuid)
    {
        return $this->model::whereUuid($uuid)->delete();
    }

    public function bulkDelete($ids)
    {
        return $this->model::whereIn('id',$ids)->delete();
    }

    public function bulkDeleteByUuid($uuids)
    {
        return $this->model::whereIn('uuid',$uuids)->delete();
    }

}
