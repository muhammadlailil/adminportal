<!doctype html>
<html lang="en">

<head>    
    <meta name="notification-interval" content="{{portalconfig('notification.interval')}}">
    <meta name="app-notification" content="{{portalconfig('notification.display')}}">
    <meta name="app-notification-path" content="{{portalconfig('notification.ajax_path')}}">
    <meta name="admin-base-url" content="{{url(portalconfig('admin_path'))}}">
    @include('portal::partials.css')
    @include('admin.partials.css')
</head>

<body>
    @include('portal::partials.sidebar')
    <section class="app-wrapper">
        @include('portal::partials.header')
        <main class="app-content-wrapper">
            @if(session('alert_error'))
            <div class="alert alert-warning alert-dismissible d-flex align-items-center mb-4" role="alert">
                <i class="isax-b icon-info-circle icon"></i>
                {{session('alert_error')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session('error') && portalconfig('alert_message_type')=='alert')
            <div class="alert alert-warning alert-dismissible d-flex align-items-center mb-4" role="alert">
                <i class="isax-b icon-info-circle icon"></i>
                {{session('error')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session('success') && portalconfig('alert_message_type')=='alert')
            <div class="alert alert-success alert-dismissible d-flex align-items-center mb-4" role="alert">
                <i class="isax-b icon-tick-circle icon"></i>
                {{session('success')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @stack('pre_html')
            {{$slot}}
        </main>
    </section>    

    <x-portal::alert.information></x-portal::alert.information>
    @include('portal::components.alert.confirmation')
    @include('portal::components.alert.confirm')
    @include('portal::partials.js')
    @include('admin.partials.js')
    @stack('js')
    <script src="{{asset('adminportal/js/notification.js?')}}"></script>

    @if(session('success') && portalconfig('alert_message_type')=='popup')
    <script>
        Information("{{session('success')}}")
    </script>
    @endif
    @if(session('error') && portalconfig('alert_message_type')=='popup')
    <script>
        Information("{{session('error')}}",'warning')
    </script>
    @endif
</body>

</html>