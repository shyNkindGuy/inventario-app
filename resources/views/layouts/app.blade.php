<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title', 'Nova Salud')</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link href="{{ asset('metronic/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" />
        <link href="{{ asset('metronic/assets/css/style.bundle.css') }}" rel="stylesheet" />
        @livewireStyles
    </head>
<body>
    {{--@include('layouts.header')--}}
    {{--@include('layouts.sidebar')--}}
    <div class="content d-flex flex-column flex-column-fluid">
        <main class="py-4">
            {{ $slot }}
        </main>
    </div>
    <script src="{{ asset('metronic/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('metronic/assets/js/scripts.bundle.js') }}"></script>
    @livewireScripts
</body>
</html>