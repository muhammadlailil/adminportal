<?php
namespace Laililmahfud\Adminportal\Services;

use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Services\AdminService;
use Laililmahfud\Adminportal\Models\CmsNotification;

class CmsNotificationService extends AdminService{
    public function __construct(
        public $model = CmsNotification::class,
    ) {}

    public function datatable(Request $request, $perPage = 10)
    {
        $search = $request->search ?? '';

        return $this->model::join('cms_admin', 'cms_admin.id', 'cms_notifications.admin_id')
            ->where(function ($q) use ($search) {
                $q->where('cms_admin.name', 'like', "%{$search}%");
                $q->orWhere('cms_notifications.title', 'like', "%{$search}%");
                $q->orWhere('cms_notifications.description', 'like', "%{$search}%");
            })
            ->when(!admin()->role->is_superadmin,function($q){
                $q->where('admin_id',admin()->user->id);
            })
            ->select(['cms_notifications.*', 'cms_admin.name', 'cms_admin.profile'])
            ->datatable($perPage, "cms_notifications.created_at");

    }
    

    public function unreadNotification($limit=10){
        $query = $this->model::select('title','description','id','created_at')
            ->when(!admin()->role->is_superadmin,function($q){
                $q->where('admin_id',admin()->user->id);
            })
            ->where('is_read',0)
            ->latest('created_at');
        $total = $query->clone()->count();
        $list = $query->limit($limit)
                ->get()
                ->map(function($row){
                    $row->date = date('D, d M Y. H:i',strtotime($row->created_at));
                    return $row;
                })->values();
        return [
            'total' => $total,
            'items' => $list,
        ];
    }
}