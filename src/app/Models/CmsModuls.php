<?php
namespace Laililmahfud\Adminportal\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CmsModuls extends Model
{
    use HasFactory,HasUuids;

    protected $table = 'cms_moduls';
    protected $fillable = ['name', 'path','icon','type','controller','except_route','parent_id','sorting','actions'];
    protected $casts = [
        'except_route' => 'array',
        'actions' => 'array',
    ];
}
