<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ramonda Ecommerce | @yield('title', '')</title>

    <link href="favicon.ico" rel="SHORTCUT ICON"/>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app-shop.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    @yield('extra-css')
</head>


<body class="@yield('body-class', '')">
@include('partials.nav')

@yield('content')

@include('partials.footer')

@yield('extra-js')

</body>
</html>
