<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="{{ str_replace('.', '-', Route::currentRouteName()) }} @stack('bodyClass')">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @yield('style')
    <!-- Styles -->
    @vite(['resources/scss/app.scss'])
</head>

<body>
    <main class="bg-gray-50">
        <!-- Page content -->
        <div id="app" data-component="{{ $component }}" data-props="{{ json_encode($props) }}"></div>
    </main>

    @vite($scriptYield ?? ['resources/js/app.js'])
</body>

</html>
