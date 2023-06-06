<?php
namespace App\Http\Controllers\Admin;

use Laililmahfud\Adminportal\Controllers\AdminController;
use Laililmahfud\Adminportal\Services\CmsNotificationService;
use Illuminate\Http\Request;

class AdminNotificationController extends AdminController{
    public function __construct(
        public $cmsNotificationService = new CmsNotificationService,
    ) {}


    protected $routePath = "admin.notification";
    protected $pageTitle = "Notification";
    protected $resourcePath = "portalmodule::notification";
    protected $moduleService = CmsNotificationService::class;
    protected $add = false;
    protected $bulkAction = false;

    protected $tableColumns = [
        ["label" => "Admin", "name" => "cms_admin.name"],["label" => "Title", "name" => "cms_notifications.title"],
        ["label" => "Description", "name" => "cms_notifications.description"],["label" => "Is Read", "name" => "cms_notifications.is_read"], 
    ];


    public function read(Request $request,$uuid){
        $notification = $this->cmsNotificationService->findByUuId($uuid);
        $notification->is_read = 1;
        $notification->save();
        return redirect($notification->url_detail);
    }

    public function list(Request $request){
        $notification = $this->cmsNotificationService->unreadNotification();
        return response()->json($notification);
    }
}