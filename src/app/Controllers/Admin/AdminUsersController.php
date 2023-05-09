<?php
namespace Laililmahfud\Adminportal\Controllers\Admin;

use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\AdminController;
use Laililmahfud\Adminportal\Models\RolesPermission;
use Laililmahfud\Adminportal\Services\CmsAdminService;

class AdminUsersController extends AdminController
{
    protected $routePath = "admin.user-admin";
    protected $pageTitle = "Users Admin";
    protected $resourcePath = "portalmodule::user-admin";
    protected $crudService = CmsAdminService::class;
    protected $jstable = true;

    protected $tableColumns = [
        ["label" => "Name", "name" => "cms_admin.name"], ["label" => "Email", "name" => "cms_admin.email"],
        ["label" => "Role", "name" => "roles_permission.name"], ["label" => "Status", "name" => "cms_admin.status"],
    ];

    protected $rules = [
        "name" => "required",
        "email" => "required|email",
        'password' => 'min:8|max:50|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/',
        "role_permission_id" => "required|exists:roles_permission,id",
        "status" => "required|int|in:1,0",
    ];

    protected $createRules = [
        "email" => "unique:cms_admin,email",
        'password' => 'required',
    ];

    protected $updateRules = [
        "email" => "unique:cms_admin,email,{id}",
        'password' => 'nullable',
    ];


    public function create(Request $request)
    {
        $this->data =  [
            'roles' => RolesPermission::all(['name', 'id']),
        ];
        return parent::create($request);
    }
    
    public function edit(Request $request,$id)
    {
        $this->data =  [
            'roles' => RolesPermission::all(['name', 'id']),
        ];
        return parent::edit($request,$id);
    }
}
