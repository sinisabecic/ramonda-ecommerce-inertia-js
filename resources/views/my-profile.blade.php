@extends('layout')

@section('title', 'My Profile')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>My Profile</span>
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

            <ul>
                <li class="active"><a href="{{ route('ecommerce.users.edit') }}">My Profile</a></li>
                <li><a href="{{ route('orders.index') }}">My Orders</a></li>
            </ul>
        </div> <!-- end sidebar -->
        <div class="my-profile">
            <div class="products-header">
                <h1 class="stylish-heading">My Profile</h1>
            </div>

            <div>
                <form action="{{ route('ecommerce.users.update') }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <div class="form-control">
                        <input id="first_name" type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                               placeholder="First name" required>
                    </div>

                    <div class="form-control">
                        <input id="last_name" type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                               placeholder="Name" required>
                    </div>

                    <div class="form-control">
                        <input id="username" type="text" name="username" value="{{ old('username', $user->username) }}"
                               placeholder="Username" required>
                    </div>

                    <div class="form-control">
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}"
                               placeholder="Email" required>
                    </div>


                    <select class="form-control" name="country_id" id="country">
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>


                    <div class="form-control">
                        <input id="password" type="password" name="password" placeholder="Password">
                        <div>Leave password blank to keep current password</div>
                    </div>
                    <div class="form-control">
                        <input id="password-confirm" type="password" name="password_confirmation"
                               placeholder="Confirm Password">
                    </div>
                    <div>
                        <button type="submit" class="my-profile-button">Update Profile</button>
                    </div>
                </form>
            </div>

            <div class="spacer"></div>
        </div>
    </div>

@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
