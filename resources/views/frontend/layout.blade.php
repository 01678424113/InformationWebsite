<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{$meta_title}}</title>
    <meta name="description" content="{{$meta_description}}">
    <meta name="keywords" content="{{$meta_keyword}}">
    <meta charset="utf-8">
    <meta name="author" content="Roman Kirichik">
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{$logo}}">
    <base href="{{asset('')}}">
    {{--Seo--}}
    <meta itemprop="url" content="{{route('home')}}"/>
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="1 days">
    <link rel="canonical" href="{{route('home')}}" />
    <meta property="og:locale" content="id_ID" />
    <meta property="og:image" content="" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    <meta property="og:url" content="{{route('home')}}" />
    <meta property="og:site_name" content="Check website traffic free 2018" />
    <meta name="DC.title" content="" />
    <meta name="author" content="" />
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="frontend/css/style.css">
    <link rel="stylesheet" href="frontend/css/style-responsive.css">
    <link rel="stylesheet" href="frontend/css/animate.min.css">
    <link rel="stylesheet" href="frontend/css/vertical-rhythm.min.css">
    <link rel="stylesheet" href="frontend/css/owl.carousel.css">
    <link rel="stylesheet" href="frontend/css/magnific-popup.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style-information-website.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/loadding.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=vietnamese"
          rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
    {{--Chart map JS--}}
    <script src="https://www.amcharts.com/lib/3/ammap.js"></script>
    <script src="https://www.amcharts.com/lib/3/maps/js/worldLow.js"></script>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
</head>
<body class="appear-animate" {{--onload="myFunction()" style="background-color: #5BC0DE;"--}}>

<!-- Page Loader -->
{{--<div id="loader">
    <div class='body'>
  <span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
  </span>
        <div class='base'>
            <span></span>
            <div class='face'></div>
        </div>
    </div>
    <div class='longfazers'>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    <h4>Wait a few second. Thank you :) </h4>
</div>--}}
<!-- End Page Loader -->

<!-- Page Wrap -->
<div class="page" id="top">
    <div id="myDiv" {{--style="display: none"--}}>
        @include('frontend.layouts.nav-top')


        @yield('content')

        @include('frontend.layouts.footer')
    </div>
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
<script type="text/javascript" src="js/loadding.js"></script>

<script>
    $('.input-search').change(function () {
        var domain = $('.input-search').val();
        $('.btn-search').attr('href', '/inf/' + domain);
    });
   /* $('a').click(function () {
        $('#loader').show('slow');
        $('#myDiv').hide('slow');
        $('body').attr('style','background-color: #5BC0DE;');
    })*/
</script>
@yield('script')
</body>
</html>
