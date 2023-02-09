<?php
namespace Laililmahfud\Adminportal\Services;

use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Services\AdminService;
use Laililmahfud\Adminportal\Models\RolesPermission;
use Laililmahfud\Adminportal\Services\CmsModuleService;

class RolePermissionService extends AdminService
{
    public function __construct(
        public $model = RolesPermission::class,
        public $cmsModuleService = new CmsModuleService,
    ) {}

    public function datatable(Request $request, $perPage = 10)
    {
        $search = $request->search ?? '';

        return $this->model::where('name', 'like', "%{$search}%")
            ->select(['id','name','is_superadmin'])
            ->datatable($perPage, "created_at");
    }

    public function store(Request $request){
        return $this->model::create($request->only(['name','is_superadmin','permissions']));
    }

    public function update(Request $request,$id){
        return $this->model::findOrFail($id)->update($request->only(['name','is_superadmin','permissions']));
    }

    public function listModuls(){
        return json_decode($this->cmsModuleService->all()->values()->toJson());
    }
}
