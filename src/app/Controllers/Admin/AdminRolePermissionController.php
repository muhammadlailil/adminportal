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
    protected $crudService = RolePermissionService::class;

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
        $moduls = $this->rolePermissionService->listModuls();
        if(empty($moduls)) return back()->with(['error'=> 'Please add at least one module']);
        $this->data =  ['moduls' => $moduls];
        return parent::create($request);
    }

    public function edit(Request $request,$id)
    {
        $moduls = $this->rolePermissionService->listModuls();
        if(empty($moduls)) return back()->with(['error'=> 'Please add at least one module']);
        $this->data =  ['moduls' => $moduls];
        return parent::edit($request,$id);
    }
}
