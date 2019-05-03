<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title --> 
    <title>@yield('head-title')</title> 
    @include('head')
</head>
<body>
    @include('header')
    @include('navigation')
    @yield('body')
    @include('footer')
</body>
</html>