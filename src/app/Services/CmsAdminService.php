<?php
namespace Laililmahfud\Adminportal\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laililmahfud\Adminportal\Models\CmsAdmin;
use Laililmahfud\Adminportal\Helpers\AdminPortal;
use Laililmahfud\Adminportal\Services\AdminService;
use Laililmahfud\Adminportal\JsTable\Resources\UserJsTableResources;

class CmsAdminService extends AdminService
{
    public function __construct(
        public $model = CmsAdmin::class,
        public $jsTableResource = new UserJsTableResources
    ) {}

    public function jstable(Request $request)
    {
        $search = $request->search ?? '';

        return $this->jsTableResource->send(
            $this->model::join('roles_permission', 'cms_admin.role_permission_id', 'roles_permission.id')
            ->where(function ($q) use ($search) {
                $q->where('cms_admin.name', 'like', "%{$search}%");
                $q->orWhere('cms_admin.email', 'like', "%{$search}%");
                $q->orWhere('roles_permission.name', 'like', "%{$search}%");
            })
            ->select(['cms_admin.id', 'cms_admin.name', 'cms_admin.profile', 'cms_admin.email', 'cms_admin.status', 'roles_permission.name as role_name'])
            ->jstable("cms_admin.created_at")
        );

    }
    
    public function store(Request $request)
    {
        return $this->model::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_permission_id' => $request->role_permission_id,
            'status' => $request->status,
            'profile' => AdminPortal::uploadFile($request->profile),
            'password' => Hash::make($request->password),
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'email', 'role_permission_id', 'status',]);
        if ($request->password)  $data['password'] = Hash::make($request->password);
        if ($request->profile) $data['profile'] = AdminPortal::uploadFile($request->profile);

        return $this->model::findOrFail($id)->update($data);
    }
}
