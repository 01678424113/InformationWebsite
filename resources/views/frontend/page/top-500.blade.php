@extends('frontend.layout')
@section('content')
    <div class="content">

        <!-- Divider -->
        <hr class="mt-0 mb-0 "/>
        <!-- End Divider -->

        <!-- About Section -->
        <section class="page-section" id="about">
            <div class="container relative">
                <div class="section-text mb-50 mb-sm-20">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="section-title font-alt align-left mb-20 mb-sm-40">
                                Top 10 domain
                            </h2>
                            <div class="table-top-500">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th style="max-width: 150px">Root domain</th>
                                        <th class="hidden-xs">Linking Root Domains</th>
                                        <th class="hidden-xs">External Links</th>
                                        <th>Domain mozRank</th>
                                        <th>Domain mozTrust</th>
                                        <th class="hidden-xs">Change</th>
                                    </tr>
                                    </thead>
                                    @if(count($top_500s) > 0)
                                        <tbody>
                                        @foreach($top_500s as $top_500)
                                            <tr class="
                                            @if((int)$top_500->rank % 2 == 0)
                                            {{"active"}}
                                            @endif"
                                            >
                                                <td>{{$top_500->rank}}</td>
                                                <td  style="max-width: 150px">
                                                    <img src="https://www.google.com/s2/favicons?domain=http://{{$top_500->root_domain}}" alt="Checking website - Website traffic">
                                                    <a href="{{'http://'.$top_500->root_domain.'.'.env('URL_DOMAIN')}}" class="domain">
                                                        {{$top_500->root_domain}}
                                                    </a>
                                                </td>
                                                <td class="hidden-xs">{{$top_500->linking_root_domain}}</td>
                                                <td class="hidden-xs">{{$top_500->external_link}}</td>
                                                <td style="color: #24ABE2">{{$top_500->domain_mozrank}}</td>
                                                <td style="color: red">{{$top_500->domain_moztrust}}</td>
                                                <td class="hidden-xs">{{$top_500->change_rank}}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="7" style="text-align: center">
                                                <a href="">View more ...</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{$top_500s->links()}}
                <hr>
                <div class="container relative">
                    <div class="row">
                        <!-- Team item -->
                        <div class="col-sm-4 mb-xs-30 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="team-item">

                                <div class="team-item-image">

                                    <img src="image/Google.jpg" alt="Checking website - Website traffic"/>

                                    <div class="team-item-detail">

                                        <h4 class="font-alt normal">Google</h4>

                                        <p>
                                            Search the world's information, including webpages, images, videos and more.
                                        </p>

                                        <div class="team-social-links">
                                            <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                                            <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                                            <a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
                                        </div>

                                    </div>
                                </div>

                                <div class="team-item-descr font-alt">

                                    <div class="team-item-name">
                                        Google
                                    </div>

                                    {{-- <div class="team-item-role">
                                         Developer
                                     </div>--}}

                                </div>

                            </div>
                        </div>
                        <!-- End Team item -->

                        <!-- Team item -->
                        <div class="col-sm-4 mb-xs-30 wow fadeInUp">
                            <div class="team-item">

                                <div class="team-item-image">

                                    <img src="image/alexa.jpg" alt="Checking website - Website traffic" style=""/>

                                    <div class="team-item-detail">

                                        <h4 class="font-alt normal">Alexa</h4>

                                        <p>
                                            Boost traffic and revenue with a full suite of SEO and competitor analysis tools. Discover new opportunities to find, reach, and convert your audience.
                                        </p>

                                        <div class="team-social-links">
                                            <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                                            <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                                            <a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
                                        </div>

                                    </div>
                                </div>

                                <div class="team-item-descr font-alt">

                                    <div class="team-item-name">
                                        Alexa
                                    </div>

                                    {{-- <div class="team-item-role">
                                         Art Director
                                     </div>--}}

                                </div>

                            </div>
                        </div>
                        <!-- End Team item -->

                        <!-- Team item -->
                        <div class="col-sm-4 mb-xs-30 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="team-item">

                                <div class="team-item-image">

                                    <img src="image/similarweb.png" alt="Checking website - Website traffic"/>

                                    <div class="team-item-detail">

                                        <h4 class="font-alt normal">Similarweb</h4>

                                        <p>
                                            Grow your market share with SimilarWeb's digital market intelligence platform. Compare website traffic statistics & analytics.
                                        </p>

                                        <div class="team-social-links">
                                            <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                                            <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                                            <a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
                                        </div>

                                    </div>
                                </div>

                                <div class="team-item-descr font-alt">

                                    <div class="team-item-name">
                                        Similarweb
                                    </div>

                                    {{--  <div class="team-item-role">
                                          Web engineer
                                      </div>--}}

                                </div>

                            </div>
                        </div>
                        <!-- End Team item -->

                    </div>


                </div>

            </div>
        </section>
        <!-- End About Section -->

    </div>
@endsection

