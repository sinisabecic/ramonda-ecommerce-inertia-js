@extends('layout')

@section('title', 'Shopping Cart')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="#">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Shopping Cart</span>
    @endcomponent

    <div class="cart-section container">
        <div>
            @if (session('warning_message'))
                <div class="alert alert-warning">
                    {{ session('warning_message') }}
                </div>
            @elseif (session('success_message'))
                <div class="alert alert-success">
                    {{ session('success_message') }}
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

            @if (Cart::count() > 0)

                <h2>{{ Cart::count() }} item(s) in Shopping Cart</h2>

                <div class="cart-table">
                    @foreach (Cart::content() as $item)
                        <div class="cart-table-row">
                            <div class="cart-table-row-left">
                                <a href=""><img
                                            src="{{ $item->model->productImage() }}"
                                            alt="item"
                                            class="cart-table-img"></a>
                                <div class="cart-item-details">
                                    <div class="cart-table-item"><a
                                                href="{{ route('shop.show', $item->model->slug) }}">{{ $item->name }}</a>
                                    </div>
                                    <div class="cart-table-description">{{ $item->model->details }}</div>
                                </div>
                            </div>

                            <div class="cart-table-row-right">
                                <div class="cart-table-actions">
                                    <form action="{{ route('cart.destroy', $item->rowId) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cart-options">Remove</button>
                                    </form>

                                    <form action="{{ route('cart.switchToSaveForLater', $item->rowId) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="cart-options">Save for Later</button>
                                    </form>
                                </div>
                                <div>
                                    <select class="quantity" name="quantity" data-id="{{ $item->rowId }}"
                                            data-productQuantity="{{ $item->model->quantity }}">{{-- On stock real quantity --}}
                                        @for ($i = 1; $i < 6; $i++)
                                            <option value="{{ $i }}" {{ $item->qty == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div>{{ $item->model->presentPrice() }} &euro;</div>
                            </div>
                        </div> <!-- end cart-table-row -->
                    @endforeach

                </div> <!-- end cart-table -->

                @if (!session()->has('coupon')) <!--only one coupon can be applied -->

                <a href="#" class="have-code">Have a Code?</a>

                <div class="have-code-container">
                    <form action="{{ route('coupon.store') }}" method="POST">
                        @csrf
                        <input type="text" name="coupon_code" id="coupon_code">
                        <button type="submit" class="button button-plain">Apply</button>
                    </form>
                </div> <!-- end have-code-container -->
                @endif

                <div class="cart-totals">
                    <div class="cart-totals-left">
                        Shipping is free.
                    </div>

                    <div class="cart-totals-right">
                        <div>
                            Subtotal <br>
                            @if (session('coupon'))
                                {{-- like: session()->has('coupon')--}}
                                Code (<strong>{{ session('coupon')['name'] }}</strong>)
                                {{-- like: session()->get('coupon')['name']--}}
                                <form action="{{ route('coupon.destroy') }}" method="POST" style="display:block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="font-size:14px;">Remove</button>
                                </form>
                                <hr>
                                New Subtotal <br>
                            @endif
                            Tax/PDV ({{config('cart.tax')}}%)<br>
                            <span class="cart-totals-total">Total</span>
                        </div>
                        <div class="cart-totals-subtotal">
                            {{ presentPrice(Cart::subtotal()) }} &euro;<br>


                            @if (session()->has('coupon')){{-- like: session('coupon) --}}

                            -{{ presentPrice($discount) }} &euro;<br>&nbsp;<br>
                            <hr>
                            {{ presentPrice($newSubtotal) }} &euro;<br>
                            @endif

                            {{ presentPrice($newTax) }} &euro;<br>
                            <span class="cart-totals-total">{{ presentPrice($newTotal) }} &euro;</span>
                        </div>
                    </div>
                </div> <!-- end cart-totals -->

                <div class="cart-buttons">
                    <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
                    <a href="{{ route('checkout.index') }}" class="button-primary">Proceed to Checkout</a>
                </div>

            @else

                <h3>No items in Cart!</h3>
                <div class="spacer"></div>
                <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
                <div class="spacer"></div>

            @endif


            {{--!  "Save for later" section  --}}
            @if (Cart::instance('saveForLater')->count() > 0)

                <h2>{{ Cart::instance('saveForLater')->count() }} item(s) Saved For
                    Later</h2>

                <div class="saved-for-later cart-table">
                    @foreach (Cart::instance('saveForLater')->content() as $item)
                        <div class="cart-table-row">
                            <div class="cart-table-row-left">
                                <a href="{{ route('shop.show', $item->model->slug) }}"><img
                                            src="{{ $item->model->productImage() }}" alt="item"
                                            class="cart-table-img"></a>
                                <div class="cart-item-details">
                                    <div class="cart-table-item"><a
                                                href="{{ route('shop.show', $item->model->slug) }}">{{ $item->name }}</a>
                                    </div>
                                    <div class="cart-table-description">{{ $item->model->details }}</div>
                                </div>
                            </div>
                            <div class="cart-table-row-right">
                                <div class="cart-table-actions">
                                    <form action="{{ route('saveForLater.destroy', $item->rowId) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="cart-options">Remove</button>
                                    </form>

                                    <form action="{{ route('saveForLater.switchToCart', $item->rowId) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="cart-options">Move to Cart</button>
                                    </form>
                                </div>

                                <div>{{ $item->model->presentPrice() }} &euro;</div>
                            </div>
                        </div> <!-- end cart-table-row -->
                    @endforeach

                </div> <!-- end saved-for-later -->

            @else

                <h3>You have no items Saved for Later.</h3>

            @endif

        </div>

    </div> <!-- end cart-section -->

    @include('partials.might-like')
@endsection


@section('extra-js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        (function () {
            const quantity = document.querySelectorAll('.quantity')

            Array.from(quantity).forEach(function (element) {
                element.addEventListener('change', function () {
                    const id = element.getAttribute('data-id')
                    const productQuantity = element.getAttribute('data-productQuantity')

                    axios.patch(`/cart/${id}`, {
                        quantity: this.value,
                        productQuantity: productQuantity
                    })
                        .then(function (response) {
                            // console.log(response);
                            window.location.href = '{{ route('cart.index') }}'
                        })
                        .catch(function (error) {
                            // console.log(error);
                            window.location.href = '{{ route('cart.index') }}'
                        });
                })
            })
        })();
    </script>

    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
