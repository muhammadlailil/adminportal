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
        $data = array_merge($request->only(['name','is_superadmin']),$this->getRequestPermission());
        return $this->model::create($data);
    }

    public function update(Request $request,$id){
        $data = array_merge($request->only(['name','is_superadmin']),$this->getRequestPermission());
        return $this->model::findOrFail($id)->update($data);
    }

    public function listModuls(){
        return json_decode($this->cmsModuleService->all()->values()->toJson());
    }

    private function getRequestPermission(){
        $permissions = ["view admin.dashboard"];
        $permission_module = [];
        foreach(request('permissions',[]) as $permission){
            $id = key($permission);
            $access = $permission[$id];
            array_push($permissions,$access);

            if(str_contains($access,"view admin.")){
                array_push($permission_module,$id);
            }
        }
        return  [
            'permissions' => $permissions,
            'permission_modules' => array_values(array_unique($permission_module)),
        ];
    }
}
