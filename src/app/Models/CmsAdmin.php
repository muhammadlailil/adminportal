<?php
namespace Laililmahfud\Adminportal\Models;

use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Traits\HasDatatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Laililmahfud\Adminportal\Models\RolesPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CmsAdmin extends Model
{
    use HasFactory,HasUuids,HasDatatable;

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
