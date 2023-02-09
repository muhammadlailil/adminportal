<!doctype html>
<html lang="en">
<head>
    @include('portal::partials.css')
</head>

<body>
    {{$slot}}

    @include('portal::partials.js')
</body>

</html>