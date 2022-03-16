<footer>
    <div class="footer-content container">
        <div class="made-with">
            <span><a href="{{ env('APP_URL') }}">Ramonda Ecommerce</a></span>
            by <span>
               <strong><a href="https://github.com/sinisabecic" target="_blank">Sinisa Becic</a></strong>
            </span>
        </div>
        {{--        {{ menu('footer', 'partials.menus.footer') }}--}}
        @include('partials.menus.footer')
    </div> <!-- end footer-content -->
</footer>
