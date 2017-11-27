<!DOCTYPE html>
<html>
<head>
    <title>Rhythm &mdash; One & Multi Page Creative Theme</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta charset="utf-8">
    <meta name="author" content="Roman Kirichik">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- Favicons -->
    <link rel="shortcut icon" href="images/favicon.png">
    <base href="{{asset('')}}">
    <!-- CSS -->
    <link rel="stylesheet" href="frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="frontend/css/style.css">
    <link rel="stylesheet" href="frontend/css/style-responsive.css">
    <link rel="stylesheet" href="frontend/css/animate.min.css">
    <link rel="stylesheet" href="frontend/css/vertical-rhythm.min.css">
    <link rel="stylesheet" href="frontend/css/owl.carousel.css">
    <link rel="stylesheet" href="frontend/css/magnific-popup.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="appear-animate">

<!-- Page Loader -->
<div class="page-loader">
    <div class="loader">Loading...</div>
</div>
<!-- End Page Loader -->

<!-- Page Wrap -->
<div class="page" id="top">

  @include('frontend.layouts.nav-top')


   @yield('content')


    <!-- Contact Section -->
    <section class="page-section" id="contact">
        <div class="container relative">

            <h2 class="section-title font-alt mb-70 mb-sm-40">
                Contact
            </h2>

            <div class="row mb-60 mb-xs-40">

                <div class="col-md-8 col-md-offset-2">
                    <div class="row">

                        <!-- Phone -->
                        <div class="col-sm-6 col-lg-4 pt-20 pb-20 pb-xs-0">
                            <div class="contact-item">
                                <div class="ci-icon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="ci-title font-alt">
                                    Call Us
                                </div>
                                <div class="ci-text">
                                    +61 3 8376 6284
                                </div>
                            </div>
                        </div>
                        <!-- End Phone -->

                        <!-- Address -->
                        <div class="col-sm-6 col-lg-4 pt-20 pb-20 pb-xs-0">
                            <div class="contact-item">
                                <div class="ci-icon">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="ci-title font-alt">
                                    Address
                                </div>
                                <div class="ci-text">
                                    245 Quigley Blvd, Ste K
                                </div>
                            </div>
                        </div>
                        <!-- End Address -->

                        <!-- Email -->
                        <div class="col-sm-6 col-lg-4 pt-20 pb-20 pb-xs-0">
                            <div class="contact-item">
                                <div class="ci-icon">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="ci-title font-alt">
                                    Email
                                </div>
                                <div class="ci-text">
                                    <a href="mailto:support@bestlooker.pro">support@bestlooker.pro</a>
                                </div>
                            </div>
                        </div>
                        <!-- End Email -->

                    </div>
                </div>

            </div>

            <!-- Contact Form -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    <form class="form contact-form" id="contact_form">
                        <div class="clearfix">

                            <div class="cf-left-col">

                                <!-- Name -->
                                <div class="form-group">
                                    <input type="text" name="name" id="name" class="input-md round form-control" placeholder="Name" pattern=".{3,100}" required>
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="input-md round form-control" placeholder="Email" pattern=".{5,100}" required>
                                </div>

                            </div>

                            <div class="cf-right-col">

                                <!-- Message -->
                                <div class="form-group">
                                    <textarea name="message" id="message" class="input-md round form-control" style="height: 84px;" placeholder="Message"></textarea>
                                </div>

                            </div>

                        </div>

                        <div class="clearfix">

                            <div class="cf-left-col">

                                <!-- Inform Tip -->
                                <div class="form-tip pt-20">
                                    <i class="fa fa-info-circle"></i> All the fields are required
                                </div>

                            </div>

                            <div class="cf-right-col">

                                <!-- Send Button -->
                                <div class="align-right pt-10">
                                    <button class="submit_btn btn btn-mod btn-medium btn-round" id="submit_btn">Submit Message</button>
                                </div>

                            </div>

                        </div>



                        <div id="result"></div>
                    </form>

                </div>
            </div>
            <!-- End Contact Form -->

        </div>
    </section>
    <!-- End Contact Section -->


    <!-- Google Map -->
    <div class="google-map">

        <div data-address="Belt Parkway, Queens, NY, United States" id="map-canvas"></div>

        <div class="map-section">

            <div class="map-toggle">
                <div class="mt-icon">
                    <i class="fa fa-map-marker"></i>
                </div>
                <div class="mt-text font-alt">
                    <div class="mt-open">Open the map <i class="fa fa-angle-down"></i></div>
                    <div class="mt-close">Close the map <i class="fa fa-angle-up"></i></div>
                </div>
            </div>

        </div>

    </div>
    <!-- End Google Map -->

   @include('frontend.layouts.footer')

</div>
<!-- End Page Wrap -->


<!-- JS -->
<script type="text/javascript" src="frontend/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="frontend/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="frontend/js/bootstrap.min.js"></script>
<script type="text/javascript" src="frontend/js/SmoothScroll.js"></script>
<script type="text/javascript" src="frontend/js/jquery.scrollTo.min.js"></script>
<script type="text/javascript" src="frontend/js/jquery.localScroll.min.js"></script>
<script type="text/javascript" src="frontend/js/jquery.viewport.mini.js"></script>
<script type="text/javascript" src="frontend/js/jquery.countTo.js"></script>
<script type="text/javascript" src="frontend/js/jquery.appear.js"></script>
<script type="text/javascript" src="frontend/js/jquery.sticky.js"></script>
<script type="text/javascript" src="frontend/js/jquery.parallax-1.1.3.js"></script>
<script type="text/javascript" src="frontend/js/jquery.fitvids.js"></script>
<script type="text/javascript" src="frontend/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="frontend/js/isotope.pkgd.min.js"></script>
<script type="text/javascript" src="frontend/js/imagesloaded.pkgd.min.js"></script>
<script type="text/javascript" src="frontend/js/jquery.magnific-popup.min.js"></script>
<!-- Replace test API Key "AIzaSyAZsDkJFLS0b59q7cmW0EprwfcfUA8d9dg" with your own one below 
**** You can get API Key here - https://developers.google.com/maps/documentation/javascript/get-api-key -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAZsDkJFLS0b59q7cmW0EprwfcfUA8d9dg"></script>
<script type="text/javascript" src="frontend/js/gmap3.min.js"></script>
<script type="text/javascript" src="frontend/js/wow.min.js"></script>
<script type="text/javascript" src="frontend/js/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="frontend/js/jquery.simple-text-rotator.min.js"></script>
<script type="text/javascript" src="frontend/js/all.js"></script>
<script type="text/javascript" src="frontend/js/contact-form.js"></script>
<script type="text/javascript" src="frontend/js/jquery.ajaxchimp.min.js"></script>
<!--[if lt IE 10]><script type="text/javascript" src="frontend/js/placeholder.js"></script><![endif]-->

</body>
</html>
