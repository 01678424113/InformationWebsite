<!-- Navigation panel -->
<nav class="main-nav js-stick" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.1);">
    <div class="full-wrapper relative clearfix">
        <!-- Logo ( * your text or image into link tag *) -->
        <div class="nav-logo-wrap local-scroll">
            <a href="mp-index.html" class="logo">
                <img src="frontend/images/logo-dark.png" alt="" />
            </a>
        </div>
        <div class="mobile-nav">
            <i class="fa fa-bars"></i>
        </div>

        <!-- Main Menu -->
        <div class="inner-nav desktop-nav">
            <ul class="clearlist">

                <!-- Item With Sub -->
                <li>
                    <a href="#" class="mn-has-sub">Home <i class="fa fa-angle-down"></i></a>

                    <!-- Sub Multilevel -->
                    <ul class="mn-sub mn-has-multi">

                        <!-- Sub Column -->
                        <li class="mn-sub-multi">
                            <ul>
                                <li>
                                    <a href="mp-index.html">Main Demo</a>
                                </li>
                            </ul>

                        </li>
                        <!-- End Sub Column -->

                    </ul>
                    <!-- End Sub Multilevel -->

                </li>
                <!-- End Item With Sub -->

                <!-- Item With Sub -->
                <li>
                    <a href="#" class="mn-has-sub">Pages <i class="fa fa-angle-down"></i></a>

                </li>
                <!-- End Item With Sub -->

                <!-- Item With Sub -->
                <li>
                    <a href="#" class="mn-has-sub">Elements <i class="fa fa-angle-down"></i></a>


                </li>
                <!-- End Item With Sub -->

                <!-- Item With Sub -->
                <li>
                    <a href="#" class="mn-has-sub active">Portfolio <i class="fa fa-angle-down"></i></a>


                </li>
                <!-- End Item With Sub -->

                <!-- Item With Sub -->
                <li>
                    <a href="#" class="mn-has-sub">Blog <i class="fa fa-angle-down"></i></a>


                </li>
                <!-- End Item With Sub -->

                <!-- Item With Sub -->
                <li>
                    <a href="#" class="mn-has-sub">Shop <i class="fa fa-angle-down"></i></a>


                </li>
                <!-- End Item With Sub -->
                <!-- Languages -->
                <li>
                    <a href="#" class="mn-has-sub">Eng <i class="fa fa-angle-down"></i></a>

                    <ul class="mn-sub">

                        <li><a href="">English</a></li>
                        <li><a href="">France</a></li>
                        <li><a href="">Germany</a></li>

                    </ul>

                </li>
                <!-- End Languages -->

            </ul>
        </div>
        <!-- End Main Menu -->


    </div>
</nav>
<!-- End Navigation panel -->
<!-- Home Section -->
<section class="home-section bg-dark-alfa-70 parallax-2 fixed-height-small"
         data-background="image/technology.jpg" id="home">
    <div class="js-height-parent container">

        <!-- Hero Content -->
        <div class="home-content">
            <div class="home-text">

                <h1 class="hs-line-8 no-transp font-alt mb-50 mb-xs-30">
                    Alexa / Whois / Google / Information website
                </h1>

                <h2 class="hs-line-14 font-alt mb-50 mb-xs-30">
                    Information website
                </h2>

                <div class="local-scroll">
                    {{-- <a href="#about" class="btn btn-mod btn-border-w btn-medium btn-round hidden-xs">See More</a>
                     <span class="hidden-xs">&nbsp;</span>
                     <a href="http://vimeo.com/50201327" class="btn btn-mod btn-border-w btn-medium btn-round lightbox mfp-iframe">Play Reel</a>--}}
                    <form action="{{route('getInformationDomain')}}" method="get">
                        {{csrf_field()}}
                        <div class="input-group" style="max-width: 700px;margin: auto;">
                            <input type="text" class="form-control" style="height: 50px;background: #ffffff12;color: white;" name="txt-domain" placeholder="Enter domain ...">
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-search" type="submit">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!-- End Hero Content -->

    </div>
</section>
<!-- End Home Section -->
