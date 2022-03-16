@extends('layout')

@section('title', 'Products')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.js@2.6.0/dist/instantsearch.min.css">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/instantsearch.js@2.6.0/dist/instantsearch-theme-algolia.min.css">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Shop</span>
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

    <div class="products-section container">
        <div class="sidebar">
            <h3>By Category</h3>
            <ul>
                <li class="active">
                    <a
                            href="{{ route('shop.index') }}">{{ __('All') }}</a>
                </li>
                @foreach ($categories as $category)
                    {{-- set active class on div element --}}
                    <li class="{{ setActiveCategory($category->slug) }}"><a
                                href="{{ route('shop.index', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div> <!-- end sidebar -->
        <div>
            <div class="products-header">
                <h1 class="stylish-heading">{{ $categoryName }}</h1>
                <div>
                    <strong>Price: </strong>
                    {{-- ['category' is request()-> category  --}}
                    <a href="{{ route('shop.index', ['category' => request()->category, 'sort' => 'low_high']) }}">
                        Low to High
                    </a> |
                    <a href="{{ route('shop.index', ['category' => request()->category, 'sort' => 'high_low']) }}">
                        High to Low
                    </a>
                </div>
            </div>

            <div class="products text-center">
                @forelse ($products as $product)
                    <div class="product">
                        <a href="{{ route('shop.show', $product->slug) }}"><img
                                    src="{{ $product->productImage() }}" alt="product"></a>
                        <a href="{{ route('shop.show', $product->slug) }}">
                            <div class="product-name">{{ $product->name }}</div>
                        </a>
                        <div class="product-price font-weight-bold">{{ $product->presentPrice() }} &euro;</div>
                    </div>
                @empty
                    <div style="text-align: left">No items found</div>
                @endforelse
            </div> <!-- end products -->

            <div class="spacer"></div>
            {{ $products->appends(request()->input())->links() }}
        </div>
    </div>

@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/npm/algoliasearch/dist/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>

    <script src="{{ asset('js/algolia-keys.js') }}"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
