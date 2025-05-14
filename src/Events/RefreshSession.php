<?php

namespace Laililmahfud\Adminportal\Events;

use Illuminate\Queue\SerializesModels;

class RefreshSession
{
    use SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
}
