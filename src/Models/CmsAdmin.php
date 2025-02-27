<?php

namespace Laililmahfud\Adminportal\Models;

use Illuminate\Notifications\Notifiable;
use Laililmahfud\Adminportal\Traits\HasUuid;
use Laililmahfud\Adminportal\Enums\UserStatus;
use Laililmahfud\Adminportal\Traits\HasDatatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laililmahfud\Adminportal\Traits\HasPermission;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laililmahfud\Adminportal\Notifications\ResetPasswordLinkNotification;

class CmsAdmin extends Authenticatable
{
    use HasUuid, Notifiable,HasPermission,HasDatatable;

    protected $casts = [
        'status' => UserStatus::class
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at'
    ];

    public function hasVerifiedEmail()
    {
        return !portal('authentication.verification') || !is_null($this->email_verified_at);
    }

    public function markEmailAsVerified()
    {
        $this->email_verified_at = now();
        return $this->save();
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordLinkNotification($token));
    }

    public function permission() : HasOne{
        return $this->hasOne(CmsRolePermission::class,'id','role_permission_id');
    }
}
