<?php
namespace Laililmahfud\Adminportal\Models;


use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Traits\HasUuid;
use Laililmahfud\Adminportal\Traits\HasDatatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolesPermission extends Model
{
    use HasFactory,HasUuid,HasDatatable;

    protected $table = 'roles_permission';
    protected $fillable = ['name', 'is_superadmin','permissions','permission_modules'];

    protected $casts = [
        'permissions' => 'array',
        'permission_modules' => 'array',
    ];
}
