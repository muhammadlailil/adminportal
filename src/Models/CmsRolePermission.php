<?php

namespace Laililmahfud\Adminportal\Models;

use Illuminate\Support\Facades\Blade;
use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Traits\HasUuid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Laililmahfud\Adminportal\Traits\HasDatatable;

class CmsRolePermission extends Model
{
    use HasUuid, HasDatatable;

    protected $casts = [
        'permissions' => 'array'
    ];
    
    protected function badgeSuperadmin(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                return Blade::render('<x-portal::badge :color="$type">{{ $label }}</x-portal::badge>', [
                    'type' => $attributes['is_superadmin'] == 0 ? 'yellow' : 'green',
                    'label' => $attributes['is_superadmin'] == 1 ? 'Yes' : 'No',
                ]);
            }
        );
    }
}
