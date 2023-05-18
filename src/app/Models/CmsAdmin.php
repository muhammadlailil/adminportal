<?php
namespace Laililmahfud\Adminportal\Models;

use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Traits\HasDatatable;
use Laililmahfud\Adminportal\Models\RolesPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laililmahfud\Adminportal\Traits\HasUuid;

class CmsAdmin extends Model
{
    use HasFactory,HasUuid,HasDatatable;

    protected $table = 'cms_admin';
    protected $fillable = ['name', 'email','password','profile','role_permission_id','status'];

    public function scopeActive($query) {
        return $query->where('status', true);
    }

    public function roles()
    {
        return $this->belongsTo(RolesPermission::class, 'role_permission_id', 'id');
    }
}
