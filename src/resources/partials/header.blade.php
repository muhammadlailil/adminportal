<header class="navbar-header shadow-sm d-flex justify-content-between">
    <div class="module d-flex align-items-center">
        <div>
            <a id="btn-sidebar-toggle"><i class="isax icon-menu-1"></i></a>
        </div>
        <div class="py-2">
            <h5 class="page-title font-24px">{{@$page}}</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1 font-075rem">
                    <li class="breadcrumb-item"><a href="#">Database</a></li>
                    @if(@$type=="List")
                    <li class="breadcrumb-item active" aria-current="page">List {{@$page}}</li>
                    @elseif(@$type=='create')
                    <li class="breadcrumb-item"><a href="#">List {{@$page}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create {{@$page}}</li>
                    @elseif(@$type=='update')
                    <li class="breadcrumb-item"><a href="#">List {{@$page}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update {{@$page}}</li>
                    @else                    
                    <li class="breadcrumb-item active" aria-current="page">{{@$page}}</li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>
    <ul class="header-navigation">
        @if(portal_config('nofitication'))
        <li class="notification">
            <a href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-notification">
                <span class="new"></span>
                <i class="isax icon-notification icon"></i>
                <span class="text">@lang('adminportal.notification')</span>
                <span class="count">0</span>
            </a>
            <ul class="dropdown-menu notification-list p-0 shadow-sm dropdown-menu-end">
                <li class="title">
                    <a href="javascript:;">Notifikasi</a>
                </li>
                <li id="notification-list-items"></li>
                <li class="all p-2 text-center">
                    <a href="{{route(portal_config('nofitication_path'))}}" class="btn btn-light d-inline-block text-upper fw-bold">@lang('adminportal.see_all')</a>
                </li>
            </ul>
        </li>
        @endif
    </ul>
</header>
