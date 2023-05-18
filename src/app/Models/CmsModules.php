<?php
namespace Laililmahfud\Adminportal\Models;


use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CmsModules extends Model
{
    use HasFactory,HasUuid;

    protected $table = 'cms_modules';
    protected $fillable = ['name', 'path','icon','type','controller','except_route','parent_id','sorting','actions'];
    protected $casts = [
        'except_route' => 'array',
        'actions' => 'array',
    ];
}
