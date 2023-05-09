<x-portal::layout.admin page="Profile">
    <div class="row">
        <div class="col-sm-5">
            <section class="app-content shadow-sm">
                <div class="profile-section p-3">
                    <div class="d-flex justify-content-center mb-3">
                        <div class="form-image-upload rounded"
                            style="background-image: url('{{asset(admin()->user->profile)}}');">
                            <input type="file" name="" class="form-control" id="">
                        </div>
                    </div>
                    <ul class="list-group group-link">
                        <li class="list-group-item ">
                            <a href="{{route('admin.profile',['view'=>'change-password'])}}">
                                <i class="isax-b icon-lock-1 icon"></i>
                                @lang('adminportal.change_password')
                            </a>
                        </li>
                        @if(portal_config('nofitication') && portal_config('nofitication_path')=='admin.notification.index')
                        <li class="list-group-item">
                            <a href="{{route(portal_config('nofitication_path'))}}">
                                <i class="isax-b icon-notification icon"></i>
                                @lang('adminportal.notification')
                            </a>
                        </li>
                        @endif
                    </ul>
                    <h5 class="form-title mb-3 mt-4" style="margin-left: 15px;">@lang('adminportal.profile')</h5>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="group-detail d-flex align-items-center">
                                <i class="isax icon-user-tag icon"></i>
                                <div class="d-flex flex-column">
                                    <span class="title">Email</span>
                                    <span class="value">{{admin()->user->email}}</span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="group-detail d-flex align-items-center">
                                <i class="isax icon-profile-circle icon"></i>
                                <div class="d-flex flex-column">
                                    <span class="title">Nama</span>
                                    <span class="value">{{admin()->user->name}}</span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="group-detail d-flex align-items-center">
                                <i class="isax icon-user-octagon icon"></i>
                                <div class="d-flex flex-column">
                                    <span class="title">Role</span>
                                    <span class="value">{{admin()->role->name}}</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </section>
        </div>

        @if(request('view'))
        @include("portalmodule::profile.".request('view'))
        @endif
    </div>
</x-portal::layout.admin>