<?php
namespace Laililmahfud\Adminportal\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasUuid
{
    protected function uuid(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attribute) {
                return id_to_uuid($attribute['id']);
            },
        );
    }
}
