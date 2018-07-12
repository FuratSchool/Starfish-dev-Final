<footer class="card-footer footer-color">
    <div class="card-body">
        <div class="container">
            <div class="row justify-content-center social-media-icons-positions">
                <button class="btn btn-socialmedia-circle"><img class="social-media-icons"
                                                                src="{{asset('../images/twitter-icon.png')}}"></button>
                <button class="btn btn-socialmedia-circle"><img class="social-media-icons"
                                                                src="{{asset('../images/facebook-icon.png')}}"></button>
                <button class="btn btn-socialmedia-circle"><img class="social-media-icons"
                                                                src="{{asset('../images/instagram-icon.png')}}"></button>
                <button class="btn btn-socialmedia-circle"><img class="social-media-icons"
                                                                src="{{asset('../images/pinterest-icon.png')}}"></button>
            </div>
            <hr class="footer-hr">
            <nav class="nav footer-navigation">
                <div class="">
                    <img class="footer-logo" src="{{asset('../images/starfish-logo-white.png')}}">
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <h3 class=" footer-nav-title">Contact</h3>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link footer-nav-link-color" href="{{route('faqs')}}">Faqs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link footer-nav-link-color" href="{{route('contact')}}">Get in touch</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link footer-nav-link-color" href="#">Kids</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link footer-nav-link-color" href="#">Pets</a>
                    </li>
                </ul>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <h3 class=" footer-nav-title">Discover</h3>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link footer-nav-link-color" href="#">Starfish Kids</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link footer-nav-link-color" href="#">Starfish Pets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link footer-nav-link-color" href="#">Starfish Giftcards</a>
                    </li>
                </ul>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <h3 class=" footer-nav-title">Professionals</h3>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link footer-nav-link-color" href="#">Register your venture</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link footer-nav-link-color" href="{{route('helpcentre')}}">Partner Help Centre</a>
                    </li>
                </ul>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <h3 class=" footer-nav-title">About Us</h3>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link footer-nav-link-color" href="#">Join our Team!</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link footer-nav-link-color" href="{{route('legal')}}">Legal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link footer-nav-link-color" href="#">Star Trust</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

</footer>
@section('scripts')
    <script src="{{asset('js/cookie_handler.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>

    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
@show