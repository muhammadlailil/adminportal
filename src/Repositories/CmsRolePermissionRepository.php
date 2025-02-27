<?php
namespace Laililmahfud\Adminportal\Repositories;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Models\CmsRolePermission;
use Laililmahfud\Adminportal\Repositories\AdminRepository;

class CmsRolePermissionRepository extends AdminRepository
{
     public function __construct(
          public $model = CmsRolePermission::class
     ) {
     }

     public function datatable(Request $request, $limit)
     {
          return $this->model::query()
               ->search(['name'])
               ->sorting("created_at")
               ->paginate($limit);
     }
     public function findAll()
     {
          return $this->model::select(['id', 'name'])->get();
     }
}