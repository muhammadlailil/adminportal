<?php
namespace Laililmahfud\Adminportal\Services;

use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Helpers\AdminPortal;

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

    public function bulkDelete($ids)
    {
        return $this->model::whereIn('id',$ids)->delete();
    }

}
