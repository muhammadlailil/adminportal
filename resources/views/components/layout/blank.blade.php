<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} - {{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ asset(portal('favicon')) }}" type="image/x-icon">
    @portalUI
</head>

<body x-data>

    {{ $slot }}
    <x-portal::toast />

    @if ($toast = session('toast'))
        <script>
            window.addEventListener("load", (event) => {
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: {
                        title: "{{ @$toast['title'] }}",
                        message: "{{ @$toast['message'] }}",
                        variant: "{{ @$toast['variant'] ?: 'default' }}",
                        position: "{{ @$toast['position'] ?: 'bottom-center' }}",
                    }
                }))
            })
        </script>
    @endif
</body>

</html>
