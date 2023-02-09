<!doctype html>
<html lang="en">

<head>    
    @include('portal::partials.css')
</head>

<body>
    @include('portal::partials.sidebar')
    <section class="app-wrapper">
        @include('portal::partials.header')
        <main class="app-content-wrapper">
            @stack('pre_html')
            {{$slot}}
        </main>
    </section>    

    <x-portal::alert.information></x-portal::alert.information>
    @include('portal::components.alert.confirmation')
    @include('portal::partials.js')
    @if(session('success'))
    <script>
        Information("{{session('success')}}")
    </script>
    @endif
    @if(session('error'))
    <script>
        Information("{{session('error')}}",'warning')
    </script>
    @endif
</body>

</html>