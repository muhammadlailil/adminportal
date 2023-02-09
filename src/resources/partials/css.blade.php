<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{config('app.name')}} : {{@$page}}</title>
<link rel="icon" type="image/x-icon" href="{{asset(portal_config('app_favicon'))}}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://muhammadlailil.github.io/iconsax/style/iconsax.css" />
<link rel="stylesheet" href="{{asset('adminportal/css/app.css?'.date('YmdHis'))}}">
<style>
    :root {
        --app-primary-color: {{portal_config('theme_color')?:'#0A0A0A'}};
    }
</style>
@stack('css')