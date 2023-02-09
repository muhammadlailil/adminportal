<?php
namespace Laililmahfud\Adminportal\Models;


use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Traits\HasDatatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolesPermission extends Model
{
    use HasFactory,HasUuids,HasDatatable;

    protected $table = 'roles_permission';
    protected $fillable = ['name', 'is_superadmin','permissions'];

    protected $casts = [
        'permissions' => 'array',
    ];
}
