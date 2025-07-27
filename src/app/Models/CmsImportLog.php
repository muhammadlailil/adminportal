<?php
namespace Laililmahfud\Adminportal\Models;


use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Models\CmsAdmin;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CmsImportLog extends Model
{
    use HasFactory,HasUuids;

    protected $table = 'cms_import_log';
    protected $fillable = ['filename', 'import_by','data','row_count','progres','complete_at'];
    protected $casts = [
        'data' => 'array',
    ];

    public function admin()
    {
        return $this->belongsTo(CmsAdmin::class, 'import_by', 'id');
    }

}
