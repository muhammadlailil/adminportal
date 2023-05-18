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
        public $userJsTableResources = new UserJsTableResources
    ) {
    }

    public function datatable(Request $request, $perPage = 10)
    {
        $search = $request->search ?? '';
        return $this->model::join('roles_permission', 'cms_admin.role_permission_id', 'roles_permission.id')
            ->where(function ($q) use ($search) {
                $q->where('cms_admin.name', 'like', "%{$search}%");
                $q->orWhere('cms_admin.email', 'like', "%{$search}%");
                $q->orWhere('roles_permission.name', 'like', "%{$search}%");
            })
            ->select(['cms_admin.uuid', 'cms_admin.name', 'cms_admin.profile', 'cms_admin.email', 'cms_admin.status', 'roles_permission.name as role_name'])
            ->datatable($perPage, "cms_admin.created_at");
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

    public function update(Request $request, $uuid)
    {
        $data = $request->only(['name', 'email', 'role_permission_id', 'status',]);
        if ($request->filled('password'))  $data['password'] = Hash::make($request->password);
        if ($request->hasFile("profile")) $data['profile'] = AdminPortal::uploadFile($request->profile);

        return $this->model::whereUuid($uuid)->update($data);
    }
}
