<!-- Navigation panel -->
<nav class="main-nav js-stick" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.1);">
    <div class="full-wrapper relative clearfix">
        <!-- Logo ( * your text or image into link tag *) -->
        <style>
            .search-nav-top {
                width: 200px;
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
                <a href="{{$url_home}}" class="logo">
                <img src="image/logo-website.png" alt=""/>
                </a>
            </span>
        </div>


        <div class="mobile-nav">
            <i class="fa fa-bars"></i>
        </div>

        <!-- Main Menu -->
        <div class="inner-nav desktop-nav">
            <ul class="clearlist">
<li style="height: 70px;display: flex;">
    <div class="input-group" style="max-width: 300px;margin: auto;">
        <input type="url" class="form-control input-search"
               style="height: 40px;background: #ffffff12" name="txt-domain"
               placeholder="Enter domain ...">
        <div class="input-group-btn">
            <a class="btn btn-default btn-search" href="" style="height: 40px!important;border-color:#ccc;display: flex">
                Search
            </a>
        </div>
    </div>
</li>
                <!-- Item With Sub -->
                <li>
                    <a href="{{$url_home}}" class="mn-has-sub">Home</a>
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
                    <a href="{{$url_top_500}}" class="mn-has-sub">Top 500 domain MOZ</a>

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

