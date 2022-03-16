<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app-shop.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

</head>

<body>
<div id="app">
    <header class="with-background">
        <div class="top-nav container">
            <div class="top-nav-left">
                <div class="logo">Ramonda E-commerce</div>
            </div>
            <div class="top-nav-right">
                @include('partials.menus.main-right')
            </div>
        </div> <!-- end top-nav -->
        <div class="hero container">
            <div class="hero-copy">
                <h1>Ramonda Ecommerce</h1>
                <p>Includes multiple products, categories, a shopping cart and a checkout system with Stripe
                    integration.</p>
                <div class="hero-buttons">
                    <a href="https://github.com/sinisabecic/ramonda-ecommerce"
                       class="button button-primary">GitHub</a>
                </div>
            </div> <!-- end hero-copy -->

            {{--            <div class="hero-image">--}}
            {{--                <img src="img/macbook-pro-laravel.png" alt="hero image">--}}
            {{--            </div> <!-- end hero-image -->--}}
        </div> <!-- end hero -->
    </header>

    <div class="featured-section">

        <div class="container">
            <h1 class="text-center">Laravel Ecommerce</h1>

            <p class="section-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore vitae nisi,
                consequuntur illum dolores cumque pariatur quis provident deleniti nesciunt officia est reprehenderit
                sunt aliquid possimus temporibus enim eum hic lorem.</p>

            <div class="text-center button-container">
                <a href="#" class="button button-black-2">Featured</a>
                <a href="#" class="button">On Sale</a>
            </div>

            {{-- <div class="tabs">
                <div class="tab">
                    Featured
                </div>
                <div class="tab">
                    On Sale
                </div>
            </div> --}}

            <div class="products text-center">
                @foreach ($products as $product)
                    <div class="product">
                        <a href="{{ route('shop.show', $product->slug) }}"><img
                                    src="{{ $product->productImage() }}" alt="product"></a>
                        <a href="{{ route('shop.show', $product->slug) }}">
                            <div class="product-name">{{ $product->name }}</div>
                        </a>
                        <div class="product-price">{{ $product->presentPrice() }} &euro;</div>
                    </div>
                @endforeach

            </div> <!-- end products -->

            <div class="text-center button-container">
                <a href="{{ route('shop.index') }}" class="button">View more products</a>
            </div>

        </div> <!-- end container -->

    </div> <!-- end featured-section -->

    {{--    <blog-posts></blog-posts>--}}

    @include('partials.footer')

</div> <!-- end #app -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
