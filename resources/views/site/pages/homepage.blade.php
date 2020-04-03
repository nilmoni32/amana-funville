@extends('site.app')
@section('title', 'Homepage')
@section('content')

<!-- Slider Start -->
<div class="slide">
    <div class="slideshow owl-carousel">
        <!-- Slider Backround Image Start -->
        <div class="item">
            <img src="{{ asset('frontend') }}/images/background/banner-1.jpg" alt="banner" title="banner"
                class="img-responsive" />
        </div>
        <div class="item">
            <img src="{{ asset('frontend') }}/images/background/banner-2.jpg" alt="banner" title="banner"
                class="img-responsive" />
        </div>
        <!-- Slider Backround Image End -->
    </div>

    <!-- Slide Detail Start  -->
    <div class="slide-detail">
        <div class="container">
            <div class="cd-headline clip">
                <h4>LOVES <span class="cd-words-wrapper">
                        <b class="is-visible">HEALTHY</b>
                        <b>QUALITY</b>
                        <b>TESTY</b>
                    </span>FOOD</h4>
            </div>
            <h5 class="text-white">Lets uncover the best places to eat and drink nearest to you.</h5>
        </div>
    </div>
    <!-- Slide Detail End  -->
</div>
<!-- Slider End  -->

<!-- Popular Dishes Start -->
<div class="dishes">
    <div class="container">
        <div class="row">
            <!-- Title Content Start -->
            <div class="col-sm-12 commontop text-center">
                <h4>Our Popular Dishes</h4>
                <div class="divider style-1 center">
                    <span class="hr-simple left"></span>
                    <i class="icofont icofont-ui-press hr-icon"></i>
                    <span class="hr-simple right"></span>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam efficitur placerat nulla, in
                    suscipit erat sodales id. Nullam ultricies eu turpis at accumsan. Mauris a sodales mi, eget
                    lobortis nulla.</p>
            </div>
            <!-- Title Content End -->
            <div class="col-sm-12">
                <div class="dish owl-carousel">
                    <div class="item">
                        <!-- Box Start -->
                        <div class="box">
                            <a href="#"><img src="{{ asset('frontend') }}/images/dishes/01.jpg" alt="image"
                                    title="image" class="img-fluid" /></a>
                            <div class="caption">
                                <h4>Dish Name Here</h4>
                                <span>Lorem ipsum is simply dummy text of the printing and type setting
                                    industry.</span>
                                <p>$100</p>
                            </div>
                        </div>
                        <!-- Box End -->
                    </div>
                    <div class="item">
                        <!-- Box Start -->
                        <div class="box">
                            <a href="#"><img src="{{ asset('frontend') }}/images/dishes/02.jpg" alt="image"
                                    title="image" class="img-fluid" /></a>
                            <div class="caption">
                                <h4>Dish Name Here</h4>
                                <span>Lorem ipsum is simply dummy text of the printing and type setting
                                    industry.</span>
                                <p>$100</p>
                            </div>
                        </div>
                        <!-- Box End -->
                    </div>
                    <div class="item">
                        <!-- Box Start -->
                        <div class="box">
                            <a href="#"><img src="{{ asset('frontend') }}/images/dishes/03.jpg" alt="image"
                                    title="image" class="img-fluid" /></a>
                            <div class="caption">
                                <h4>Dish Name Here</h4>
                                <span>Lorem ipsum is simply dummy text of the printing and type setting
                                    industry.</span>
                                <p>$100</p>
                            </div>
                        </div>
                        <!-- Box End -->
                    </div>
                    <div class="item">
                        <!-- Box Start -->
                        <div class="box">
                            <a href="#"><img src="{{ asset('frontend') }}/images/dishes/04.jpg" alt="image"
                                    title="image" class="img-fluid" /></a>
                            <div class="caption">
                                <h4>Dish Name Here</h4>
                                <span>Lorem ipsum is simply dummy text of the printing and type setting
                                    industry.</span>
                                <p>$100</p>
                            </div>
                        </div>
                        <!-- Box End -->
                    </div>
                    <div class="item">
                        <!-- Box Start -->
                        <div class="box">
                            <a href="#"><img src="{{ asset('frontend') }}/images/dishes/05.jpg" alt="image"
                                    title="image" class="img-fluid" /></a>
                            <div class="caption">
                                <h4>Dish Name Here</h4>
                                <span>Lorem ipsum is simply dummy text of the printing and type setting
                                    industry.</span>
                                <p>$100</p>
                            </div>
                        </div>
                        <!-- Box End -->
                    </div>
                    <div class="item">
                        <!-- Box Start -->
                        <div class="box">
                            <a href="#"><img src="{{ asset('frontend') }}/images/dishes/01.jpg" alt="image"
                                    title="image" class="img-fluid" /></a>
                            <div class="caption">
                                <h4>Dish Name Here</h4>
                                <span>Lorem ipsum is simply dummy text of the printing and type setting
                                    industry.</span>
                                <p>$100</p>
                            </div>
                        </div>
                        <!-- Box End -->
                    </div>
                    <div class="item">
                        <!-- Box Start -->
                        <div class="box">
                            <a href="#"><img src="{{ asset('frontend') }}/images/dishes/02.jpg" alt="image"
                                    title="image" class="img-fluid" /></a>
                            <div class="caption">
                                <h4>Dish Name Here</h4>
                                <span>Lorem ipsum is simply dummy text of the printing and type setting
                                    industry.</span>
                                <p>$100</p>
                            </div>
                        </div>
                        <!-- Box End -->
                    </div>
                    <div class="item">
                        <!-- Box Start -->
                        <div class="box">
                            <a href="#"><img src="{{ asset('frontend') }}/images/dishes/03.jpg" alt="image"
                                    title="image" class="img-fluid" /></a>
                            <div class="caption">
                                <h4>Dish Name Here</h4>
                                <span>Lorem ipsum is simply dummy text of the printing and type setting
                                    industry.</span>
                                <p>$100</p>
                            </div>
                        </div>
                        <!-- Box End -->
                    </div>
                    <div class="item">
                        <!-- Box Start -->
                        <div class="box">
                            <a href="#"><img src="{{ asset('frontend') }}/images/dishes/04.jpg" alt="image"
                                    title="image" class="img-fluid" /></a>
                            <div class="caption">
                                <h4>Dish Name Here</h4>
                                <span>Lorem ipsum is simply dummy text of the printing and type setting
                                    industry.</span>
                                <p>$100</p>
                            </div>
                        </div>
                        <!-- Box End -->
                    </div>
                    <div class="item">
                        <!-- Box Start -->
                        <div class="box">
                            <a href="#"><img src="{{ asset('frontend') }}/images/dishes/05.jpg" alt="image"
                                    title="image" class="img-fluid" /></a>
                            <div class="caption">
                                <h4>Dish Name Here</h4>
                                <span>Lorem ipsum is simply dummy text of the printing and type setting
                                    industry.</span>
                                <p>$100</p>
                            </div>
                        </div>
                        <!-- Box End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Popular Dishes End -->

<!-- Food Menu Start -->
<div class="menu">
    <div class="menu-inner">
        <div class="container">
            <div class="row ">
                <!-- Title Content Start -->
                <div class="col-sm-12 col-xs-12 commontop text-center">
                    <h4>Our Menu</h4>
                    <div class="divider style-1 center">
                        <span class="hr-simple left"></span>
                        <i class="icofont icofont-ui-press hr-icon"></i>
                        <span class="hr-simple right"></span>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam efficitur placerat nulla,
                        in suscipit erat sodales id. Nullam ultricies eu turpis at accumsan. Mauris a sodales
                        mi, eget lobortis nulla.</p>
                </div>
                <!-- Title Content End -->
                <div class="col-sm-12 col-xs-12">
                    <!--  Menu Tabs Start  -->
                    <ul class="nav nav-tabs list-inline">
                        <li class="nav-item">
                            <a class="nav-link active" href="#all" data-toggle="tab" aria-expanded="true">all</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#breakfast" data-toggle="tab" aria-expanded="false">breakfast</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#lunch" data-toggle="tab" aria-expanded="false">lunch</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#dinner" data-toggle="tab" aria-expanded="false">dinner</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#drinks" data-toggle="tab" aria-expanded="false">drinks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#others" data-toggle="tab" aria-expanded="false">others</a>
                        </li>
                    </ul>
                    <!--  Menu Tabs Start  -->

                    <!--  Menu Tabs Content Start  -->
                    <div class="tab-content">
                        <!--  Menu Tab Start  -->
                        <div class="tab-pane show active" id="all">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/01.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/04.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/07.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/02.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/05.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/08.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/03.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/06.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                            </div>
                        </div>
                        <!--  Menu Tab End  -->

                        <!--  Menu Tab Start  -->
                        <div class="tab-pane" id="breakfast">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <div class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/07.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/02.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/01.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/04.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/05.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/06.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/09.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/08.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                            </div>
                        </div>
                        <!--  Menu Tab End  -->

                        <!--  Menu Tab Start  -->
                        <div class="tab-pane" id="lunch">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/01.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/04.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/07.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/02.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/05.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/08.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/03.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/06.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                            </div>
                        </div>
                        <!--  Menu Tab End  -->

                        <!--  Menu Tab Start  -->
                        <div class="tab-pane" id="dinner">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/07.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/02.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/01.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/04.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/05.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/08.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/03.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/09.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                            </div>
                        </div>
                        <!--  Menu Tab End  -->

                        <!--  Menu Tab Start  -->
                        <div class="tab-pane" id="drinks">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/01.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/04.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/07.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/02.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/05.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/08.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/03.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/06.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                            </div>
                        </div>
                        <!--  Menu Tab End  -->

                        <!--  Menu Tab Start  -->
                        <div class="tab-pane" id="others">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/07.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/02.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/01.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/04.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/05.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/08.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/09.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <!-- Box Start -->
                                    <diV class="box">
                                        <div class="image">
                                            <img src="{{ asset('frontend') }}/images/our-menu/03.jpg" alt="image"
                                                title="image" class="img-fluid" />
                                        </div>
                                        <div class="caption">
                                            <h4>Food Title Here</h4>
                                            <p class="des">Cursus / Dictum / Risus</p>
                                            <span>Lorem ipsum is simply dummy text of the printing and type
                                                setting industry.</span>
                                            <div class="price">$35.00</div>
                                        </div>
                                    </div>
                                    <!-- Box End -->
                                </div>
                            </div>
                        </div>
                        <!--  Menu Tab End  -->
                    </div>
                    <!--  Menu Tabs Content End  -->
                    <div class="text-center padbot30">
                        <a class="btn btn-theme-alt btn-wide" href='menu.html'>view more <i
                                class="icofont icofont-curved-double-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Food Menu End -->

<!-- Reservation Start -->
<div class="reservation">
    <div class="container">
        <div class="row ">
            <!-- Title Content Start -->
            <div class="col-sm-12 commontop white text-center">
                <h4>Book Your Table</h4>
                <div class="divider style-1 center">
                    <span class="hr-simple left"></span>
                    <i class="icofont icofont-ui-press hr-icon"></i>
                    <span class="hr-simple right"></span>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam efficitur placerat nulla, in
                    suscipit erat sodales id. Nullam ultricies eu turpis at accumsan. Mauris a sodales mi, eget
                    lobortis nulla.</p>
            </div>
            <!-- Title Content End -->
            <div class="col-md-12 col-xs-12">
                <!-- Reservation Form Start -->
                <form action="https://www.spheretheme.com/html/steam/mailer.php" method="post"
                    class="row reservation-form" novalidate="novalidate">
                    <div class="form-group col-md-4 col-sm-6">
                        <i class="icofont icofont-ui-user"></i><input name="name" placeholder="name" id="input-name"
                            class="form-control" type="text" required>
                    </div>
                    <div class="form-group col-md-4 col-sm-6">
                        <i class="icofont icofont-ui-message"></i><input name="email" placeholder="email"
                            id="input-email" class="form-control" type="text" required>
                    </div>
                    <div class="form-group col-md-4 col-sm-6">
                        <i class="icofont icofont-phone"></i><input name="mobile" placeholder="mobile number"
                            id="input-mobile" class="form-control" type="text" required>
                    </div>
                    <div class="form-group col-md-4 col-sm-6">
                        <i class="icofont icofont-ui-calendar"></i><input name="date" placeholder="date" id="input-date"
                            class="form-control" type="text" required>
                    </div>
                    <div class="form-group col-md-4 col-sm-6">
                        <i class="icofont icofont-clock-time"></i><input name="time" placeholder="time" id="input-time"
                            class="form-control" type="text" required>
                    </div>
                    <div class="form-group col-md-4 col-sm-6">
                        <i class="icofont icofont-users"></i><input name="persons" placeholder="number of persons"
                            id="input-persons" class="form-control" type="text" required>
                    </div>
                    <div class="form-group col-xs-12 col-md-12">
                        <div class="">
                            <div id="emailSend" class="alert alert-success" role="alert" style="display: none;">
                                <div class="success-text">Your Message has been successfully sent.</div>
                            </div>
                            <div id="emailError" class="alert alert-danger" role="alert" style="display: none;">
                                <div class="alert-text">Server error <br> Try again later.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-xs-12 col-md-12">
                        <div class="text-center">
                            <button type="submit" class="btn btn-theme btn-wide">book now</button>
                        </div>
                    </div>
                </form>
                <!-- Reservation Form End -->
            </div>
        </div>
    </div>
</div>
<!-- Reservation End  -->
@endsection