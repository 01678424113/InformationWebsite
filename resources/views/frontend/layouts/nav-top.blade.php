<!-- Home Section -->
<section class="home-section bg-dark-alfa-70 parallax-2 fixed-height-small"
         data-background="images/full-width-images/section-bg-15.jpg" id="home">
    <div class="js-height-parent container">

        <!-- Hero Content -->
        <div class="home-content">
            <div class="home-text">

                <h1 class="hs-line-8 no-transp font-alt mb-50 mb-xs-30">
                    Branding / Design / Development / Photo
                </h1>

                <h2 class="hs-line-14 font-alt mb-50 mb-xs-30">
                    Creative Studio
                </h2>

                <div class="local-scroll">
                    {{-- <a href="#about" class="btn btn-mod btn-border-w btn-medium btn-round hidden-xs">See More</a>
                     <span class="hidden-xs">&nbsp;</span>
                     <a href="http://vimeo.com/50201327" class="btn btn-mod btn-border-w btn-medium btn-round lightbox mfp-iframe">Play Reel</a>--}}
                    <form action="{{route('getInformationDomain')}}" method="get">
                        {{csrf_field()}}
                        <div class="input-group">
                            <input type="text" class="form-control" name="txt-domain" placeholder="Enter domain ...">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
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

<!-- Navigation panel -->
<nav class="main-nav dark transparent stick-fixed">
    <div class="full-wrapper relative clearfix">
        <!-- Logo ( * your text or image into link tag *) -->
        <div class="nav-logo-wrap local-scroll">
            <a href="#top" class="logo">
                <img src="frontend/images/logo-white.png" alt=""/>
            </a>
        </div>
        <div class="mobile-nav">
            <i class="fa fa-bars"></i>
        </div>
        <!-- Main Menu -->
        <div class="inner-nav desktop-nav">
            <ul class="clearlist scroll-nav local-scroll">
                <li class="active"><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#portfolio">Portfolio</a></li>
                <li><a href="#news">News</a></li>
                <li><a href="#contact">Contacts</a></li>

            </ul>
        </div>
    </div>
</nav>
<!-- End Navigation panel -->