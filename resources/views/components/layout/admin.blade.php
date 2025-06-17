<!doctype html>
<html class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ @$pageTitle }} - {{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ asset(portal('favicon')) }}" type="image/x-icon">
    @portalUI
    @include('admin.partials.css')

</head>

<body x-data="{
    pageTitle: '{{ @$pageTitle }}',
    createRoute: '{{ @$route['store'] }}',
    updateRoute: '{{ @$route['update'] }}',
    deleteRoute: '{{ @$route['delete'] }}',
    openDialog: '{{ session('openDialog') }}',
    ...admin()
}" class="duration-300">
    <x-portal::sidebar.provider>
        @php
            $navigations = navigations(config('adminportal.dashboard'));
        @endphp
        <x-portal::sidebar>
            <x-portal::sidebar.logo title="{{ config('app.name') }}" description="{{ admin()->permission->name }}"
                url="{{ url(portal('home_page')) }}" logo="{{ asset(portal('logo')) }}" />
            <x-portal::sidebar.content>
                <x-portal::sidebar.item.group>
                    @foreach ($navigations->top as $group => $topNavigations)
                        <x-portal::sidebar.item.label>
                            {{ $group }}
                        </x-portal::sidebar.item.label>
                        <x-portal::sidebar.items>
                            @foreach ($topNavigations as $topNav)
                                @if (count($topNav->childrens))
                                    <x-portal::sidebar.item.dropdown icon="{{ $topNav->icon }}"
                                        label="{{ $topNav->title }}" :active="is_active_main_menu($topNav->childrens)">
                                        @foreach ($topNav->childrens as $child)
                                            <x-portal::sidebar.item href="{{url($child->url)}}"  :active="is_active_menu($child->url)">
                                                {{$child->title}}
                                                @if($child->badge)
                                                    <x-portal::sidebar.item.badge label="{{$child->badge}}" class="absolute right-4"/>
                                                @endif
                                            </x-portal::sidebar.item>
                                        @endforeach
                                    </x-portal::sidebar.item.dropdown>
                                @else
                                    <x-portal::sidebar.item href="{{ url($topNav->url ?: '') }}"
                                        label="{{ $topNav->title }}"
                                        :active="is_active_menu($topNav->url)">
                                        @svg("tabler-{$topNav->icon}", [
                                            'class' => 'icon',
                                        ])
                                        {{ $topNav->title }}
                                        @if($topNav->badge)
                                            <x-portal::sidebar.item.badge label="{{$topNav->badge}}" class="absolute right-4"/>
                                        @endif
                                    </x-portal::sidebar.item>
                                @endif
                            @endforeach
                        </x-portal::sidebar.items>
                    @endforeach
                </x-portal::sidebar.item.group>


            </x-portal::sidebar.content>

            <x-portal::sidebar.footer>
                <x-portal::sidebar.items>
                    @foreach ($navigations->bottom as $bottomNav)
                        @if (count($bottomNav->childrens))
                            <x-portal::sidebar.item.dropdown icon="{{ $bottomNav->icon }}"
                                label="{{ $bottomNav->title }}" :active="is_active_main_menu($bottomNav->childrens)">
                                @foreach ($bottomNav->childrens as $bottomChild)
                                    <x-portal::sidebar.item href="{{url($bottomChild->url)}}"  :active="is_active_menu($bottomChild->url)">
                                        {{$bottomChild->title}}
                                        @if($bottomChild->badge)
                                            <x-portal::sidebar.item.badge label="{{$bottomChild->badge}}" class="absolute right-4"/>
                                        @endif
                                    </x-portal::sidebar.item>
                                @endforeach
                            </x-portal::sidebar.item.dropdown>
                        @else
                            <x-portal::sidebar.item href="{{ url($bottomNav->url ?: '') }}"
                                label="{{ $bottomNav->title }}"
                                :active="is_active_menu($bottomNav->url)">
                                @svg("tabler-{$bottomNav->icon}", [
                                    'class' => 'icon',
                                ])
                                {{ $bottomNav->title }}
                                @if($bottomNav->badge)
                                    <x-portal::sidebar.item.badge label="{{$bottomNav->badge}}" class="absolute right-4"/>
                                @endif
                            </x-portal::sidebar.item>
                        @endif
                    @endforeach
                </x-portal::sidebar.items>

                <x-portal::sidebar.footer.profile title="{{ admin()->name }}" description="{{ admin()->email }}"
                    alias="{{ str()->initial(admin()->name) }}">
                    <x-portal::dropdown-menu.separator />
                    <x-portal::dropdown-menu.item as="a" href="{{ route(config('adminportal.profile')) }}">
                        <x-tabler-settings class="h-4 w-4" />
                        Account
                    </x-portal::dropdown-menu.item>
                    @itcan('view', 'user-admin')
                        <x-portal::dropdown-menu.item as="a" href="{{ route('admin.user-admin.index') }}">
                            <x-tabler-rosette-discount-check class="h-4 w-4" />
                            User Admin
                        </x-portal::dropdown-menu.item>
                    @enditcan
                    @itcan('view', 'cms-role-permission')
                        <x-portal::dropdown-menu.item as="a" href="{{ route('admin.cms-role-permission.index') }}">
                            <x-tabler-shield-bolt class="h-4 w-4" />
                            Roles & Permission
                        </x-portal::dropdown-menu.item>
                    @enditcan
                    <x-portal::dropdown-menu.separator />
                    <x-portal::dropdown-menu.item as="button" type="button" variant="danger"
                        x-on:click="toggleConfirmation('logout-confirmation')" dismissible>
                        <x-tabler-logout class="h-4 w-4" />
                        Logout
                    </x-portal::dropdown-menu.item>
                </x-portal::sidebar.footer.profile>
            </x-portal::sidebar.footer>
        </x-portal::sidebar>

        <div
            class="w-full peer-data-[state=collapsed]:w-[calc(100%-var(--sidebar-width-icon)-1rem)] transition-[width] duration-200 ease-linear md:peer-data-[state=expanded]:w-[calc(100%-var(--sidebar-width))] flex flex-col">
            <x-portal::layout.header>
                <x-portal::sidebar.trigger />
                <x-portal::separator orientation="vertical" class="!h-4 me-2" />
                @if (@$breadcrumb)
                    <div class="md:block hidden">
                        <x-portal::breadcrumb>
                            @foreach ($breadcrumb as $bread)
                                <x-portal::breadcrumb.item href="{{ $bread['url'] }}">
                                    {{ $bread['label'] }}
                                </x-portal::breadcrumb.item>
                            @endforeach
                        </x-portal::breadcrumb>
                    </div>
                @endif

                <div class="ml-auto flex items-center gap-3">
                    @if (portal('darkmode'))
                        <x-portal::layout.theme-toggle />
                    @endif
                    <x-portal::layout.profile title="{{ admin()->name }}" description="{{ admin()->email }}"
                        alias="{{ str()->initial(admin()->name) }}">
                        <x-portal::dropdown-menu.separator />
                        <x-portal::dropdown-menu.item as="a" href="{{ route(config('adminportal.profile')) }}">
                            <x-tabler-settings class="h-4 w-4" />
                            Account
                        </x-portal::dropdown-menu.item>
                        @itcan('view', 'user-admin')
                            <x-portal::dropdown-menu.item as="a" href="{{ route('admin.user-admin.index') }}">
                                <x-tabler-rosette-discount-check class="h-4 w-4" />
                                User Admin
                            </x-portal::dropdown-menu.item>
                        @enditcan
                        @itcan('view', 'cms-role-permission')
                            <x-portal::dropdown-menu.item as="a"
                                href="{{ route('admin.cms-role-permission.index') }}">
                                <x-tabler-shield-bolt class="h-4 w-4" />
                                Roles & Permission
                            </x-portal::dropdown-menu.item>
                        @enditcan
                        <x-portal::dropdown-menu.separator />
                        <x-portal::dropdown-menu.item as="button" type="button" variant="danger"
                            x-on:click="toggleConfirmation('logout-confirmation')" dismissible>
                            <x-tabler-logout class="h-4 w-4" />
                            Logout
                        </x-portal::dropdown-menu.item>
                    </x-portal::layout.profile>
                </div>
            </x-portal::layout.header>

            <x-portal::layout.content>
                <div class="flex justify-between md:items-end flex-col md:flex-row items-start gap-2">
                    <div class="w-full">
                        <x-portal::heading size="xl" level="1"
                            class="!font-bold">{{ @$pageTitle }}</x-portal::heading>
                        @if (@$pageDescription)
                            <x-portal::heading.sub>{{ $pageDescription }}</x-portal::heading.sub>
                        @endif
                    </div>
                    <div class="flex space-x-2 w-full md:justify-end justify-between">
                        @yield('top-action')
                        {{ @$buttonAction }}
                    </div>
                </div>

                @stack('pre_html')
                {{ $slot }}
            </x-portal::layout.content>
        </div>
    </x-portal::sidebar.provider>

    <x-portal::alert-dialog id="logout-confirmation" class="sm:!max-w-md">
        <x-portal::alert-dialog.content method="POST" action="{{ route('admin.auth.logout') }}">
            @csrf
            <x-portal::alert-dialog.title>
                {{ __('adminportal.alert.confirmation.logout_title') }}
            </x-portal::alert-dialog.title>
            <x-portal::alert-dialog.description class="mb-5">
                {{ __('adminportal.alert.confirmation.logout_description') }}
            </x-portal::alert-dialog.description>

            <x-portal::alert-dialog.action>
                <x-portal::alert-dialog.cancel>
                    {{ __('adminportal.cancel') }}
                </x-portal::alert-dialog.cancel>
                <x-portal::alert-dialog.confirm variant="danger">
                    {{ __('adminportal.continue') }}
                </x-portal::alert-dialog.confirm>
            </x-portal::alert-dialog.action>

        </x-portal::alert-dialog.content>
    </x-portal::alert-dialog>
    <x-portal::toast position="{{ portal('toast') }}" />
    @if ($toast = session('toast'))
        <script>
            window.addEventListener("load", (event) => {
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: {
                        title: `{{ @$toast['title'] }}`,
                        message: `{!! @$toast['message'] !!}`,
                        variant: `{{ @$toast['variant'] ?: 'default' }}`,
                        position: `{{ @$toast['position'] ?: portal('toast') }}`,
                        duration: 5000
                    }
                }))
            })
        </script>
    @endif
    <script>
        const LANG = @json(__('adminportal.expose'))
    </script>
    <script src="{{ asset('adminportal/js/admin.js') }}"></script>
    @include('admin.partials.js')
</body>

</html>
