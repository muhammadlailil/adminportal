<?php
namespace Laililmahfud\Adminportal\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

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

    public function scopeFirstByUuid(Builder $query, $uuid)
    {
        return $query->whereUuid($uuid)->firstOrFail();
    }
}
