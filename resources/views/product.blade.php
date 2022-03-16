@extends('layout')

@section('title', $product->name)

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span><a href="{{ route('shop.index') }}">Shop</a></span>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>{{ $product->name }}</span>
    @endcomponent

    <div class="container">
        @if (session()->has('success_message'))
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="product-section container">
        <div>
            <div class="product-section-image">
                <img src="{{ $product->productImage() }}" alt="product" class="active" id="currentImage">
            </div>
            <div class="product-section-images">
                <div class="product-section-thumbnail selected">
                    <img src="{{ $product->productImage() }}" alt="product">
                </div>

                @if ($product->images)
                    @foreach (json_decode($product->images) as $image)
                        <div class="product-section-thumbnail">
                            <img src="{{ $product->productImages($image) }}"
                                 alt="{{ $image }}">
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="product-section-information">
            <h1 class="product-section-title">{{ $product->name }}</h1>
            <div class="product-section-subtitle">{{ $product->details }}</div>
            <div>{!! $stockLevel !!}</div>
            <div class="product-section-price">{{ $product->price }} &euro;</div>

            @if ($product->quantity > 0)
                <form action="{{ route('cart.store', $product) }}" method="POST" class="mb-3">
                    @csrf
                    <button type="submit" class="button button-primary">Add to Cart</button>
                </form>
            @endif

            <hr style="margin-top: 5rem;">

            <h2>Description:</h2>
            <div class="mt-3">
                {!! $product->description !!}
            </div>

        </div>
    </div> <!-- end product-section -->
    @include('partials.might-like')

@endsection

@section('extra-js')
    <script>
        (function () {
            const currentImage = document.querySelector('#currentImage');
            const images = document.querySelectorAll('.product-section-thumbnail');

            images.forEach((element) => element.addEventListener('click', thumbnailClick));

            function thumbnailClick(e) {
                currentImage.classList.remove('active');

                currentImage.addEventListener('transitionend', () => {
                    currentImage.src = this.querySelector('img').src;
                    currentImage.classList.add('active');
                })

                images.forEach((element) => element.classList.remove('selected'));
                this.classList.add('selected');
            }
        })();
    </script>

    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/npm/algoliasearch/dist/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('/js/algolia-keys.js') }}"></script>
    <script src="{{ asset('/js/algolia.js') }}"></script>
@endsection
