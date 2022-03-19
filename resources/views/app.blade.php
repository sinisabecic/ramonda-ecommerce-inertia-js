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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>



        <!-- Scripts -->
{{--        @routes--}}
        <script src="{{ mix('js/app.js') }}" defer></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    </head>
    <body class="font-sans antialiased">
        @inertia

        @env ('local')
{{--            <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>--}}
        @endenv

        <script>
          $("#permission").select2();
        </script>

    </body>
</html>
