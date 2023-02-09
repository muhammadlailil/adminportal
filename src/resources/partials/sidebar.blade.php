<aside class="main-sidebar d-flex flex-column">
    <a href="" class="w-100 text-center p-3 d-block">
        <img src="{{asset(portal_config('app_icon'))}}" alt="" width="130px">
    </a>
    <nav>
        <ul class="nav-profile ps-0 mb-2">
            <li class="nav-section">Profile</li>
            <li>
                <a href="{{route('admin.profile')}}" class="d-flex align-items-center text-decoration-none">
                    <img src="{{asset(admin()->user->profile)}}" class="rounded-circle" width="50px"
                        alt="">
                    <div class="text-white ms-2 d-flex flex-column">
                        <span class="name">{{admin()->user->name}}</span>
                        <span class="fs-sm">{{admin()->role->name}}</span>
                    </div>
                </a>
            </li>
        </ul>
    </nav>
    <nav class="h-full d-flex flex-column flex-grow-1 main-navbar sidebar">
        <ul class="nav flex-column navbar-menu flex-grow-1 ps-0" id="nav_accordion">
            <li class="nav-section pb-1">Menu</li>
            <li class="nav-item">
                <a class="nav-link {{(request()->is(config('adminportal.admin_path'))) ? 'active' : ''}}" href="{{route('admin.dashboard')}}">
                    <i class="isax icon-home nav-icon"></i>
                    Dashboard
                </a>
            </li>

            @foreach(admin()->modules as $modul)
            <li class="nav-item {{(count($modul->sub))?'has-submenu':''}}">
                <a class="nav-link 
                    {{(count($modul->sub))?'nav-parent':''}} 
                    {{activeMenu($modul->path)}}"
                    href="{{adminurl($modul->path)}}"
                >
                    <i class="{{$modul->icon}} nav-icon"></i>
                    {{$modul->name}}
                </a>
                @if(count($modul->sub))
                <ul class="submenu collapse">
                    @foreach ($modul->sub as $sub)
                        <li>
                            <a href="{{adminurl($sub->path)}}" class="nav-link {{activeMenu($sub->path)}}">
                                {{$sub->name}}
                            </a>
                        </li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach
            @if(admin()->role->is_superadmin)
                <li class="nav-section pb-1">Admin Portal</li>
                <li class="nav-item has-submenu">
                    <a href="{{route('admin.user-admin.index')}}" class="nav-link nav-parent {{activeMenu('portal')}}">
                        <i class="isax icon-user-octagon nav-icon"></i>
                        User Management
                    </a>
                    <ul class="submenu collapse">
                        <li>
                            <a href="{{route('admin.user-admin.index')}}" class="nav-link {{activeMenu('portal/user-admin')}}">
                                User Admin
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.role-permission.index')}}" class="nav-link {{activeMenu('portal/role-permission')}}">
                                Roles & Permission
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.cms-moduls.index')}}" class="nav-link {{activeMenu('app-moduls')}}">
                        <i class="isax icon-book nav-icon"></i>
                        Module Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('apdoc.api-documentation')}}" target="_blank" class="nav-link {{activeMenu('api-management')}}">
                        <i class="isax icon-book nav-icon"></i>
                        API Documentation
                    </a>
                </li>
            @endif
        </ul>
    </nav>
    <div class="nav-navigation-bottom text-white text-center ps-0">
        <a href="javascript:;" data-toggle="confirmation" data-message="{{__('adminportal.logout_confirmation')}}" data-action="{{route('admin.auth.logout')}}"
            class="nav-link justify-content-center d-flex align-items-center p-3">
            <i class="isax icon-logout nav-icon me-2"></i>
            Log out
        </a>
    </div>
</aside>