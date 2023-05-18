<?php
namespace Laililmahfud\Adminportal\Controllers\Admin;

use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\AdminController;
use Laililmahfud\Adminportal\Services\RolePermissionService;

class AdminRolePermissionController extends AdminController
{
    public function __construct(
        public $rolePermissionService = new RolePermissionService,
    ) {}

    protected $routePath = "admin.role-permission";
    protected $pageTitle = "Roles & Permission";
    protected $resourcePath = "portalmodule::role-permission";
    protected $moduleService = RolePermissionService::class;

    protected $tableColumns = [
        ["label" => "Name", "name" => "name"], ["label" => "Super Admin?", "name" => "is_superadmin"],
    ];

    protected $rules = [
        'name' => 'required',
        'is_superadmin' => 'required',
        'permissions' => 'required_if:is_superadmin,0|array'
    ];

    public function create(Request $request)
    {
        $modules = $this->rolePermissionService->listModules();
        if(empty($modules)) return back()->with(['error'=> 'Please add at least one module']);
        $this->data =  ['modules' => $modules];
        return parent::create($request);
    }

    public function edit(Request $request,$id)
    {
        $modules = $this->rolePermissionService->listModules();
        if(empty($modules)) return back()->with(['error'=> 'Please add at least one module']);
        $this->data =  ['modules' => $modules];
        return parent::edit($request,$id);
    }
}
