@extends('frontend.layout')
@section('content')
    <!-- Home Section -->
    <section class="home-section bg-dark-alfa-70 parallax-2 fixed-height-small"
             data-background="image/technology.jpg" id="home">
        <div class="container"
             style="display: flex;justify-content: center;align-items: center;height: 600px;text-align: center;">
            <!-- Hero Content -->
            <div class="form-search">
                <h2 class="hs-line-8 no-transp font-alt mb-50 mb-xs-30">
                    Alexa / Whois / Google / Information website
                </h2>

                <h1 class="hs-line-14 font-alt mb-50 mb-xs-30">
                    Checking Website
                </h1>

                <div class="local-scroll">
                    {{-- <a href="#about" class="btn btn-mod btn-border-w btn-medium btn-round hidden-xs">See More</a>
                     <span class="hidden-xs">&nbsp;</span>
                     <a href="http://vimeo.com/50201327" class="btn btn-mod btn-border-w btn-medium btn-round lightbox mfp-iframe">Play Reel</a>--}}

                    <div class="input-group" style="max-width: 700px;margin: auto;">
                        <input type="text" class="form-control input-search"
                               style="height: 50px;background: #ffffff12;color: white;" name="txt-domain"
                               placeholder="Enter domain ...">
                        <div class="input-group-btn">
                            <a class="btn btn-default btn-search" href="">
                                Search
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Hero Content -->
        </div>
    </section>
    <!-- End Home Section -->

    <div class="content">
        <!-- Divider -->
        <hr class="mt-0 mb-0 "/>
        <!-- End Divider -->
        @include('frontend.widget.block-info-provide')

        @include('frontend.widget.block-one')

     {{--   @include('frontend.widget.block-seven')--}}

        {{--   @include('frontend.widget.block-last-new')--}}

        {{--   @include('frontend.widget.block-subcribe')
   --}}

    </div>
@endsection

