<?php
namespace Laililmahfud\Adminportal\Traits;

use Illuminate\Support\Str;
trait HasUuid
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }

}
