<!-- About Section -->
<section class="page-section" id="about">
    <div class="container relative">
        <div class="section-text mb-50 mb-sm-20">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="section-title font-alt align-left mb-20 mb-sm-40">
                        Top 10 domain
                    </h2>
                    <div class="table-top-500">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Root domain</th>
                                <th>Linking Root Domains</th>
                                <th>External Links</th>
                                <th>Domain mozRank</th>
                                <th>Domain mozTrust</th>
                                <th>Change</th>
                            </tr>
                            </thead>
                            @if(count($top_10s) > 0)
                                <tbody>
                                @foreach($top_10s as $top_10)
                                    <tr class="
                            @if((int)$top_10->rank % 2 == 0)
                                    {{"active"}}
                                    @endif"
                                    >
                                        <td>{{$top_10->rank}}</td>
                                        <td>
                                            <a href="{{route('informationDomain',['domain_name'=>$top_10->root_domain])}}">
                                                {{$top_10->root_domain}}
                                            </a>
                                        </td>
                                        <td>{{$top_10->linking_root_domain}}</td>
                                        <td>{{$top_10->external_link}}</td>
                                        <td>{{$top_10->domain_mozrank}}</td>
                                        <td>{{$top_10->domain_moztrust}}</td>
                                        <td>{{$top_10->change_rank}}</td>
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
                <div class="col-md-4">
                    <h2 class="section-title font-alt align-left mb-20 mb-sm-40">
                        New checklist
                    </h2>
                    <div class="table-top-500">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Domain</th>
                                <th>Rank</th>
                            </tr>
                            </thead>
                            @if(count($domain_relatives) > 0)
                                <tbody>
                                <?php $i = 1; ?>
                                @foreach($domain_relatives as $domain_relative)
                                    <tr class="
                            @if($i % 2 == 0)
                                    {{"active"}}
                                    @endif"
                                    >
                                        <td>{{$i}}</td>
                                        <td>{{$domain_relative->domain}}</td>
                                        <td>{{$domain_relative->alexa->global_rank}}</td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                                </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Team item -->
            <div class="col-sm-4 mb-xs-30 wow fadeInUp">
                <div class="team-item">

                    <div class="team-item-image">

                        <img src="frontend/images/team/team-1.jpg" alt=""/>

                        <div class="team-item-detail">

                            <h4 class="font-alt normal">Hello & Welcome!</h4>

                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a&nbsp;iaculis diam.
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
                            Thomas Rhythm
                        </div>

                        <div class="team-item-role">
                            Art Director
                        </div>

                    </div>

                </div>
            </div>
            <!-- End Team item -->

            <!-- Team item -->
            <div class="col-sm-4 mb-xs-30 wow fadeInUp" data-wow-delay="0.1s">
                <div class="team-item">

                    <div class="team-item-image">

                        <img src="frontend/images/team/team-2.jpg" alt=""/>

                        <div class="team-item-detail">

                            <h4 class="font-alt normal">Nice to meet!</h4>

                            <p>
                                Curabitur augue, nec finibus mauris pretium eu. Duis placerat ex gravida nibh tristique
                                porta.
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
                            Marta Laning
                        </div>

                        <div class="team-item-role">
                            Web engineer
                        </div>

                    </div>

                </div>
            </div>
            <!-- End Team item -->

            <!-- Team item -->
            <div class="col-sm-4 mb-xs-30 wow fadeInUp" data-wow-delay="0.2s">
                <div class="team-item">

                    <div class="team-item-image">

                        <img src="frontend/images/team/team-3.jpg" alt=""/>

                        <div class="team-item-detail">

                            <h4 class="font-alt normal">Whats Up!</h4>

                            <p>
                                Adipiscing elit curabitur eu&nbsp;adipiscing lacus eu&nbsp;adipiscing lacus, a&nbsp;iaculis
                                diam.
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
                            Steve ANDERS
                        </div>

                        <div class="team-item-role">
                            Developer
                        </div>

                    </div>

                </div>
            </div>
            <!-- End Team item -->

        </div>


    </div>
</section>
<!-- End About Section -->