<ul>
    <li>
        <a href="{{ route('shop.index') }}">Shop</a>
    </li>
    @guest
        <li><a href="{{ route('register') }}">Sign Up</a></li>
        <li><a href="{{ route('login.asUser') }}">Login</a></li>
    @else
        @if(auth()->user()->is_admin)
            <li>
                <a href="/admin"><span class="text-warning">Admin</span></a>
            </li>
        @endif
        <li>
            <a href="{{ route('ecommerce.users.edit') }}">My Account</a>
        </li>
        <li>
            <a href="{{ route('logout.asUser') }}"
               onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                Logout
            </a>
        </li>

        <form id="logout-form" action="{{ route('logout.asUser') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endguest
    <li><a href="{{ route('cart.index') }}">{{ __('Cart') }}
            @if (Cart::instance('default')->count() > 0)
                <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span>
            @endif
        </a></li>
</ul>
