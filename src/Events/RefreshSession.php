<?php

namespace Laililmahfud\Adminportal\Events;

use Illuminate\Queue\SerializesModels;
use Laililmahfud\Adminportal\Models\CmsAdmin;

class RefreshSession
{
    use SerializesModels;

    public $user;

    public function __construct(CmsAdmin $user)
    {
        $this->user = $user;
    }
}
