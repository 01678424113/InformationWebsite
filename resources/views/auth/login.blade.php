<!DOCTYPE html>
<html>
<head>
    <title>Rhythm &mdash; One & Multi Page Creative Theme</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta charset="utf-8">
    <meta name="author" content="Roman Kirichik">
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

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
    <link rel="stylesheet" href="css/style-information-website.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=vietnamese"
          rel="stylesheet">

</head>
<body class="appear-animate">

<!-- Page Loader -->
<div class="page-loader">
    <div class="loader">Loading...</div>
</div>
<!-- End Page Loader -->

<!-- Page Wrap -->
<div class="page" id="top">
    <!-- Navigation panel -->
    <nav class="main-nav js-stick" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.1);">
        <div class="full-wrapper relative clearfix">
            <!-- Logo ( * your text or image into link tag *) -->
            <style>
                .search-nav-top {
                    width: 130px;
                    box-sizing: border-box;
                    border: 2px solid #ccc;
                    border-radius: 4px;
                    font-size: 16px;
                    background-color: white;
                    background-image: url('https://www.w3schools.com/howto/searchicon.png');
                    background-position: 10px 10px;
                    background-repeat: no-repeat;
                    padding: 6px 20px 6px 40px;
                    -webkit-transition: width 0.4s ease-in-out;
                    transition: width 0.4s ease-in-out;
                    margin-left: 20px;
                    position: absolute;
                    top: 8px;
                }

                .search-nav-top:focus {
                    width: 300px;
                }
            </style>
            <div class="nav-logo-wrap local-scroll">
            <span>
                <a href="{{route('home')}}" class="logo">
                <img src="frontend/images/logo-dark.png" alt=""/>
            </a>

                <input type="text" class="search-nav-top" name="txt-domain" placeholder="Enter domain ...">

            </span>

            </div>


            <div class="mobile-nav">
                <i class="fa fa-bars"></i>
            </div>

            <!-- Main Menu -->
            <div class="inner-nav desktop-nav">
                <ul class="clearlist">

                    <!-- Item With Sub -->
                    <li>
                        <a href="{{route('home')}}" class="mn-has-sub">Home</a>
                        {{--
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
                                            <!-- End Sub Multilevel -->--}}

                    </li>
                    <!-- End Item With Sub -->

                    <!-- Item With Sub -->
                    <li>
                        <a href="{{route('top500')}}" class="mn-has-sub">Top 500 domain MOZ</a>

                    </li>
                {{--  <li>
                      <a href="{{route('top500')}}" class="mn-has-sub">Top alexa</a>

                  </li>--}}
                <!-- End Item With Sub -->
                    <!-- Languages -->
                    <li>
                        <a class="mn-has-sub">Eng <i class="fa fa-angle-down"></i></a>

                        <ul class="mn-sub">

                            <li><a href="">English</a></li>
                            {{--   <li><a href="">France</a></li>
                               <li><a href="">Germany</a></li>--}}

                        </ul>

                    </li>
                    <!-- End Languages -->

                </ul>
            </div>
            <!-- End Main Menu -->


        </div>
    </nav>
    <!-- End Navigation panel -->




    <div class="container" style="min-height: 500px;padding: 50px;">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAZsDkJFLS0b59q7cmW0EprwfcfUA8d9dg"></script>
<script type="text/javascript" src="frontend/js/gmap3.min.js"></script>
<script type="text/javascript" src="frontend/js/wow.min.js"></script>
<script type="text/javascript" src="frontend/js/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="frontend/js/jquery.simple-text-rotator.min.js"></script>
<script type="text/javascript" src="frontend/js/all.js"></script>
<script type="text/javascript" src="frontend/js/contact-form.js"></script>
<script type="text/javascript" src="frontend/js/jquery.ajaxchimp.min.js"></script>
<!--[if lt IE 10]>
<script type="text/javascript" src="frontend/js/placeholder.js"></script><![endif]-->
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</body>
</html>
