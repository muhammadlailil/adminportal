<?php
namespace Laililmahfud\Adminportal\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laililmahfud\Adminportal\Helpers\AdminPortal;
use Laililmahfud\Adminportal\Helpers\ModuleBuilder;
use Laililmahfud\Adminportal\Services\CmsModuleService;

class AdminModulsController extends Controller
{
    public function __construct(
        public $moduleBuilder = new ModuleBuilder,
        public $cmsModuleService = new CmsModuleService,
    ) {}

    public function index(Request $request)
    {
        return view('portalmodule::app-module.index',[
            'icons' => listIcons(),
            'moduls' => $this->cmsModuleService->treeModuls()
        ]);
    }

    public function builder(Request $request){
        return view('portalmodule::app-module.builder.index',[
            'tables' => AdminPortal::listDatabaseTables(),
            'icons' => listIcons()
        ]);
    }

    public function loadColumns(Request $request,$table_name){
        return response()->json([
            'data' => AdminPortal::getAllColumTable($table_name,[]),
        ]);
    }

    public function create(Request $request){
        $this->cmsModuleService->updateOrCreate([
            'name' => $request->menu_name,
            'path' => $request->menu_path,
            'icon' => "isax {$request->menu_icon}",
        ],$request->id);
        $this->syncModulsSession();
        return to_route('admin.cms-moduls.index')->with([
            'success' => __('adminportal.data_success_add'),
        ]);
    }

    public function delete(Request $request,$id){
        $this->cmsModuleService->findBy([
            ['parent_id',$id]
        ])->update(['parent_id'=>null]);

        $this->cmsModuleService->delete($id);
        $this->syncModulsSession();
        return to_route('admin.cms-moduls.index')->with([
            'success' => __('adminportal.data_success_delete'),
        ]);
    }

    public function sortingMenu(Request $request){
        $data = json_decode($request->data);
        foreach($data as $i => $row){
            $sorting = $i+1;
            $this->cmsModuleService->update([
                'sorting' => $sorting,
                'parent_id' => @$row->parent
            ],$row->id);
        }
        $this->syncModulsSession();
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function buildModule(Request $request){
        $actions = [];
        $except = ['show'];

        $controller = $this->moduleBuilder->generate();
        if(!$request->has_create) array_push($except,"create","store");
        if(!$request->has_edit) array_push($except,"edit","update");
        if($request->has_import) array_push($actions,"import");
        if($request->has_export) array_push($actions,"export");
        if($request->bulk_action) array_push($actions,"bulk-action");
        
        $this->cmsModuleService->create([
            'name' => $request->module_name,
            'path' => $request->module_path,
            'icon' => "isax {$request->module_icon}",
            'type' => "module",
            'controller' => $controller,
            'except_route' => $except,
            'actions' => $actions
        ]);
        $this->syncModulsSession();
        return to_route('admin.cms-moduls.index')->with([
            'success' => __('adminportal.generate_module_success'),
        ]);
    }


    private function syncModulsSession(){
        $prefix = portal_config('auth.session_name_prefix');
        $roles = admin()->role;
        session()->put("{$prefix}.modules",AdminPortal::userModuls($roles->is_superadmin,$roles->permission_modules));
    }
}
