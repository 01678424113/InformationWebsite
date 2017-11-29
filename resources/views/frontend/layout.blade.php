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
    @yield('style')
    <link rel="stylesheet" href="css/style-information-website.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=vietnamese" rel="stylesheet">
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

   @include('frontend.layouts.footer')

</div>
<!-- End Page Wrap -->


<!-- JS -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="js/numscroller-1.0.js"></script>
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
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
    $('.input-search').change(function () {
        var domain = $('.input-search').val();
        $('.btn-search').attr('href', '/InformationWebsite/public/inf/' + domain);
    })
</script>
@yield('script')
</body>
</html>
