<section class="page-section">
    <div class="block-info-provide relative" style="max-width: 1500px;margin: auto;">
        <div class="col-md-8">
            <h2 class="section-title font-alt mb-70 mb-sm-40" style="padding-bottom: 20px">
                Stats Provided by Infomerweb.com
            </h2>
            <!-- Features Grid -->
            <div class="row multi-columns-row alt-features-grid" style="background: aliceblue;padding: 10px;border-radius: 5px;">
                <!-- Features Item -->
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="alt-features-item align-center">
                        <div class="alt-features-icon">
                            <span class="icon-flag"></span>
                        </div>
                        <h3 class="alt-features-title font-alt">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                            Basic Stats
                        </h3>
                        <div class="alt-features-descr align-left">
                            Alexa rank, Country rank, Screenshot, Website ranking checker , Check website speed, Rate my website ..
                        </div>
                    </div>
                </div>
                <!-- End Features Item -->

                <!-- Features Item -->
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="alt-features-item align-center">
                        <div class="alt-features-icon">
                            <span class="icon-clock"></span>
                        </div>
                        <h3 class="alt-features-title font-alt">
                            <i class="fa fa-user-o" aria-hidden="true"></i>
                            Visitor stats</h3>
                        <div class="alt-features-descr align-left">
                            Website visitor tracking, Bounce rate, Time on site, Male rate, Female rate, Website visitor statistics ...
                        </div>
                    </div>
                </div>
                <!-- End Features Item -->

                <!-- Features Item -->
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="alt-features-item align-center">
                        <div class="alt-features-icon">
                            <span class="icon-hotairballoon"></span>
                        </div>
                        <h3 class="alt-features-title font-alt">
                            <i class="fa fa-key" aria-hidden="true"></i>
                            Top keyword search</h3>
                        <div class="alt-features-descr align-left">
                            Top keyword search google form alexa and similar web, google website analysis, website statistics, google keyword search,..
                        </div>
                    </div>
                </div>
                <!-- End Features Item -->

                <!-- Features Item -->
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="alt-features-item align-center">
                        <div class="alt-features-icon">
                            <span class="icon-heart"></span>
                        </div>
                        <h3 class="alt-features-title font-alt">
                            <i class="fa fa-info" aria-hidden="true"></i>
                            Website Information</h3>
                        <div class="alt-features-descr align-left">
                            Web analytics, Title, Language, Description, Author, Position, Place name, Distribution,... free website analysis.
                        </div>
                    </div>
                </div>
                <!-- End Features Item -->

                <!-- Features Item -->
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="alt-features-item align-center">
                        <div class="alt-features-icon">
                            <span class="icon-linegraph"></span>
                        </div>
                        <h3 class="alt-features-title font-alt">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                            Upstream sites</h3>
                        <div class="alt-features-descr align-left">
                            Which sites did people visit immediately before this site? Website traffic tracker, website visitor tracking in here
                        </div>
                    </div>
                </div>
                <!-- End Features Item -->

                <!-- Features Item -->
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="alt-features-item align-center">
                        <div class="alt-features-icon">
                            <span class="icon-chat"></span>
                        </div>
                        <h3 class="alt-features-title font-alt">
                            <i class="fa fa-question-circle" aria-hidden="true"></i>
                            Whois information</h3>
                        <div class="alt-features-descr align-left">
                            Check domain availability, Domain information, Admin contact, Registration contact, Technology contact, Website domain check  ..
                        </div>
                    </div>
                </div>
                <!-- End Features Item -->

            </div>
            <!-- End Features Grid -->
        </div>
        <div class="col-md-4">
            <h2 class="section-title font-alt align-left mb-20 mb-sm-40">
                New search
            </h2>
            <div class="table-top-500">
                <table class="table">
                    <thead>
                    <tr>
                        {{--    <th>#</th>--}}
                        <th style="min-width: 150px;">Domain</th>
                        <th>Rank alexa</th>
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
                                {{--  <td>{{$i}}</td>--}}
                                <td style="min-width: 150px;">
                                    <img src="https://www.google.com/s2/favicons?domain=http://{{$domain_relative->domain}}"
                                         alt="">
                                    <a href="{{route('informationDomain',['domain_name'=>$domain_relative->domain])}}">{{$domain_relative->domain}}</a>
                                </td>
                                <td>{{$domain_relative->alexa->global_rank}}</td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row" style="margin-top: 20px;text-align: center;">
                <h4>{{$content_index->value_setting}}</h4>
            </div>
        </div>
    </div>
</section>