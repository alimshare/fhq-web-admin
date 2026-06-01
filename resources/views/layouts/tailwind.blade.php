<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="FHQ Web Admin">
    <title>@yield('title', 'Dashboard') | {{ env('APP_NAME', 'FHQ Web Admin') }}</title>

    <link rel="icon" href="/materialized/images/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="apple-touch-icon-precomposed" href="/materialized/images/favicon/apple-touch-icon-152x152.png">

    <link href="{{ mix('css/tailwind.css') }}" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    @yield('header-style')
    @yield('header-script')
</head>
<body class="h-full" x-data="{ sidebarOpen: false }">

    <div class="min-h-full">

        {{-- Mobile sidebar overlay --}}
        <div x-show="sidebarOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 lg:hidden"
             @click="sidebarOpen = false">
            <div class="fixed inset-0 bg-gray-600/75"></div>
        </div>

        {{-- Sidebar --}}
        @include('layouts.tailwind.sidebar')

        {{-- Main content area --}}
        <div class="lg:pl-64">
            {{-- Top navbar --}}
            @include('layouts.tailwind.header')

            {{-- Page content --}}
            <main class="py-6">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                    {{-- Flash messages --}}
                    @include('layouts.tailwind.alert')

                    {{-- Page content --}}
                    @yield('content')

                </div>
            </main>
        </div>

    </div>

    @yield('footer-script')

    <script>
        function logout() {
            document.getElementById('logout-form').submit();
        }
    </script>

</body>
</html>
