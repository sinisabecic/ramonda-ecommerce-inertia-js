@extends('layout')

@section('title', 'Search Results')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Search</span>
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

    <div class="search-results-container container">
        <h1>Search Results</h1>
        {{-- $products->count() can also --}}
        <p class="search-results-count">{{ $products->total() }} result(s) for '{{ request()->input('query') }}'</p>

        {{-- $products->count() can also --}}
        @if ($products->total() > 0)
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Details</th>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td><a href="{{ route('shop.show', $product->slug) }}">
                                <img src="{{ $product->productImage() }}" class="img-cover" alt="{{$product->image}}"
                                     width="100px">
                            </a>
                        </td>
                        <td><a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                        </td>
                        <td>{{ $product->details }}</td>
                        <td>{!! str_limit($product->description, 80) !!}</td>
                        <td>{{ $product->presentPrice() }} &euro;</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $products->appends(request()->input())->links() }}
        @endif
    </div> <!-- end search-results-container -->

@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
