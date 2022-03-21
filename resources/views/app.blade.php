<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
{{--        @routes--}}
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>


    <style>
        .multiselect {
            border: none!important;
            top: -8px!important;
            left: -7px!important;
        }

        .multiselect__option--highlight multiselect__option--selected multiselect__option{
            z-index: 9999;
        }

        .multiselect__content-wrapper {
            position: absolute;
            display: block;
            background: #fff;
            width: 100%;
            max-height: 500px;
            overflow: auto;
            /*border: 1px solid #e8e8e8;*/
            border-top: none;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            z-index: 999 !important;
            -webkit-overflow-scrolling: touch;
        }

        .multiselect__content {
            z-index: 999 !important;
        }
    </style>


    <body class="font-sans antialiased">
        @inertia

        @env ('local')
{{--            <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>--}}
        @endenv
    </body>
</html>
