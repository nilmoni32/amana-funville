<!-- Footer Start -->
<footer class="top-border">
    <div class="container">
        <div class="row inner">
            <div class="col-sm-6 col-md-6 col-lg-4">
                <!-- Footer Widget Start -->
                <h5 class="mid-menu">About Us</h5>
                <img src="{{ asset('storage/'.config('settings.site_logo')) }}" class="img-fluid mb-3" title="logo"
                    style="max-height:75px" alt="logo">
                <ul class="list-unstyled">
                    <li class="paragraph">
                        Amana Funville restaurant features sophisticated interpretations of traditional fare that is
                        accented with artistic touches, presenting one of the most unique dining experiences in
                        Rajshahi.
                    </li>
                </ul>
                <!--  Footer Social Start -->
                <ul class="list-inline social">
                    <li class="list-inline-item"><a href="{{ config('settings.social_facbook') }}" target="_blank"><i
                                class="icofont icofont-social-facebook"></i></a></li>
                    <li class="list-inline-item"><a href="{{ config('settings.social_twitter') }}" target="_blank"><i
                                class="icofont icofont-social-twitter"></i></a></li>
                    <li class="list-inline-item"><a href="{{ config('settings.social_instagram') }}" target="_blank"><i
                                class="icofont icofont-social-instagram"></i></a></li>
                    <li class="list-inline-item"><a href="{{ config('settings.social_youtube') }}" target="_blank"><i
                                class="icofont icofont-social-youtube-play"></i></a></li>
                </ul>
                <!--  Footer Social End -->

                <!-- Footer Widget End -->
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 hidden-sm hidden-xs">
                <!-- Footer Widget Start -->
                <h5 class="mid-menu">Site Map</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Food Menu</a></li>
                    <li><a href="#">Reservation</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
                <!-- Footer Widget End -->
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4">
                <!-- Footer Widget Start -->
                <h5 class="mid-menu">Contact Us</h5>
                <ul class="list-unstyled contact">
                    <li><i class="icofont icofont-social-google-map"></i> {{ config('settings.contact_address') }}</li>
                    <li><i class="icofont icofont-phone"></i> {{ config('settings.phone_no') }} </li>
                    <li><a href="#"><i
                                class="icofont icofont-ui-message"></i>{{ config('settings.default_email_address') }}</a>
                    </li>
                </ul>
                <!-- Footer Widget End -->
            </div>
        </div>

    </div>
    <div class="footer-bottom footer-bg">
        <div class="container">
            <div class="row powered">
                <!--  Copyright Start -->
                <div class="col-md-3 col-sm-6 order-md-1">
                </div>
                <div class="col-md-6 col-sm-12 text-center order-md-2">
                    <p>{{ config('settings.footer_copyright_text') }}
                        &nbsp;2019-<?php echo date("Y"); ?>.&nbsp;&nbsp;All Rights Reserved.</p>
                </div>
                <div class="col-md-3 col-sm-6 text-right order-md-3">
                </div>
                <!--  Copyright End -->
            </div>
        </div>
    </div>
</footer>
<!-- Footer End  -->