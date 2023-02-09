<header class="navbar-header shadow-sm d-flex justify-content-between">
    <div class="module d-flex align-items-center">
        <div>
            <a id="btn-sidebar-toggle"><i class="isax icon-menu-1"></i></a>
        </div>
        <div>
            <h5 class="page-title">{{@$page}}</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
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
            <a href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="new"></span>
                <i class="isax icon-notification icon"></i>
                <span class="text">@lang('adminportal.notification')</span>
                <span class="count">0</span>
            </a>
            <ul class="dropdown-menu notification-list p-0 shadow-sm dropdown-menu-end">
                <li class="title">
                    <a href="javascript:;">Notifikasi</a>
                </li>
                <li class="items">
                    <a href="" class="d-flex unread">
                        <div class="icons">
                            <i class="isax-b icon-notification-bing"></i>
                        </div>
                        <div class="d-flex flex-column">
                            <p class="title">Request Non Active Toko</p>
                            <span class="desc">Toko PT Jaya Abadi</span>
                            <span class="date">Sabtu, 22 Jan 2023, 08.00</span>
                        </div>
                    </a>
                </li>
                <li class="items">
                    <a href="" class="d-flex unread">
                        <div class="icons">
                            <i class="isax-b icon-notification-bing"></i>
                        </div>
                        <div class="d-flex flex-column">
                            <p class="title">Request Non Active Toko</p>
                            <span class="desc">Toko PT Jaya Abadi</span>
                            <span class="date">Sabtu, 22 Jan 2023, 08.00</span>
                        </div>
                    </a>
                </li>
                <li class="items">
                    <a href="" class="d-flex">
                        <div class="icons">
                            <i class="isax-b icon-notification-bing"></i>
                        </div>
                        <div class="d-flex flex-column">
                            <p class="title">Request Non Active Toko</p>
                            <span class="desc">Toko PT Jaya Abadi</span>
                            <span class="date">Sabtu, 22 Jan 2023, 08.00</span>
                        </div>
                    </a>
                </li>
                <li class="all">
                    <a href="">Lihat Semua Notifikasi</a>
                </li>
            </ul>
        </li>
        @endif
    </ul>
</header>