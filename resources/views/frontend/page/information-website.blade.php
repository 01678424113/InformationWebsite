@extends('frontend.layout')
@section('content')
    <div class="content">
        <!-- Portfolio Section -->
        <section class="page-section" style="background: #FAFAFA">
            <div class="container relative">
                <h1>{!! $website_inf[0]->h1_website_auto !!}</h1>
                <div class="information-website">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            {{--Domain website--}}
                            <div class="row" style="margin: 0">
                                <div class="sidebar-inf">
                                    <div class="col-md-4 col-sm-5 col-xs-5" style="padding: 0">
                                        <div class="domain-website">
                                            <img src="{{$website_inf[0]['icon']}}" alt=""
                                                 style="margin-top: 6px;">
                                            <h1>{{$who_is_inf[0]['domain']}}</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="right">
                                {{--Rank website--}}
                                <div class="row">
                                    <div class="col-xs-12 hidden-lg hidden-md" style="text-align: center">
                                        <img src="{{$website_inf[0]['image_screen_shot']}}"
                                             style="width: 95%;margin-top: 10px;" class="" alt="">
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table class="table" style="border-bottom: #c7c7c7 1px solid;">
                                            <tr>
                                                <td class="title search col-md-7 col-xs-12">
                                                    <div class="inner-addon right-addon">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="rank"
                                                                     style="margin-top: 10px;margin-bottom: 10px;text-align: center">
                                                                    <p style="text-align: left">{!! $website_inf[0]->content_top_website_auto !!}</p>
                                                                    <p style="text-align: left">{!! $website_inf[0]->content_bot_website_auto !!}</p>
                                                                    <p>Update
                                                                        : {{date('d-m-Y',$alexa_inf[0]['created_at'])}}</p>
                                                                    <a href="{{route('updateInformationDomain',['domain_name'=>$who_is_inf[0]['domain']])}}"
                                                                       class="btn btn-info" style="color:white">Click
                                                                        update new</a>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="rank">
                                                                    <img src="https://www.alexa.com/images/icons/globe-sm.jpg"
                                                                         alt="" style="margin-bottom: 4px;">
                                                                    <span>
                                                                        Global rank
                                                                    </span><br>
                                                                    <a href="">Wordwire</a>
                                                                    <div class='numscroller numscroller-big-bottom'
                                                                         data-slno='1'
                                                                         data-min='0'
                                                                         data-max='{{$alexa_inf[0]['global_rank']}}'
                                                                         data-delay='1' data-increment="1">0
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="rank">
                                                                    <img src="{{$alexa_inf[0]['flag_country']}}" alt=""
                                                                         style="margin-bottom: 4px;">
                                                                    <span>{{$alexa_inf[0]['country']}} Rank</span><br>
                                                                    <a href="">Wordwire</a>
                                                                    <div class='numscroller numscroller-big-bottom'
                                                                         data-slno='1'
                                                                         data-min='0'
                                                                         data-max='{{$alexa_inf[0]['country_rank']}}'
                                                                         data-delay='1' data-increment="1">0
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td valign="middle" colspan="2" style="margin-top: 10px;"
                                                    class="title text-center col-md-5 hidden-sm hidden-xs">
                                                    <img src="{{$website_inf[0]['image_screen_shot']}}"
                                                         class="image_scree_shot" alt="">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                {{--Traffic Over--}}
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h3 class="title-inf">Traffic over</h3>
                                        <hr class="hr-inf">
                                        <div class="traffic-over">
                                            <div class="row">
                                                <?php
                                                $inf_traffic_over = json_decode($alexa_inf[0]['traffic_over']);
                                                ?>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <table class="table table-hover">
                                                        <thead>
                                                        <tr>
                                                            <td>Country</td>
                                                            <td>Percent of Visitors</td>
                                                            <td>Rank in Country</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($inf_traffic_over as $item)
                                                            <tr>
                                                                <td class="td-parameter">
                                                                    <img src="{{$item[0]->img_country}}"
                                                                         alt="">
                                                                    {{$item[0]->name_country}}
                                                                </td>
                                                                <td class="td-parameter">{{$item[0]->percent_visitor}}</td>
                                                                <td class="td-parameter">{{$item[0]->rank_country}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-12">
                                                    <div id="chartdiv"></div>
                                                    <p style="text-align: center;font-size: 18px;font-weight: 600;">You
                                                        can see chart map <span><a
                                                                    href=""
                                                                    style="color: #85C5E3;text-decoration: underline">Send feedback</a></span>
                                                    </p>
                                                </div>
                                                <h3 class="title-inf">Visitor</h3>
                                                <hr class="hr-inf">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <table class="table table-hover">
                                                        <tr>
                                                            <td class="td-attribute">Bounce rate</td>
                                                            <td style="text-align: center"
                                                                class="td-parameter">{{$alexa_inf[0]['bounce_percent']}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="td-attribute">Page views per visitor</td>
                                                            <td style="text-align: center"
                                                                class="td-parameter">{{$alexa_inf[0]['pageviews_per_visitor']}}
                                                                %
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="td-attribute">Time on site</td>
                                                            <td style="text-align: center"
                                                                class="td-parameter">{{$alexa_inf[0]['time_on_site']}}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <table class="table table-hover">
                                                        <tr>
                                                            <td class="td-attribute">Male rate</td>
                                                            <td style="text-align: center"
                                                                class="td-parameter">{{$alexa_inf[0]['rate_male']}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="td-attribute">Female rate</td>
                                                            <td style="text-align: center"
                                                                class="td-parameter">{{$alexa_inf[0]['rate_female']}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="td-attribute">Home</td>
                                                            <td style="text-align: center"
                                                                class="td-parameter">{{$alexa_inf[0]['rate_home']}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="td-attribute">School</td>
                                                            <td style="text-align: center"
                                                                class="td-parameter">{{$alexa_inf[0]['rate_school']}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="td-attribute">Work</td>
                                                            <td style="text-align: center"
                                                                class="td-parameter">{{$alexa_inf[0]['rate_work']}}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--Keyword search traffic--}}
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h3 class="title-inf">Top keyword search engine</h3>
                                        <hr class="hr-inf">
                                        <br>
                                        <div class="keyword-top-search">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
                                                        <td>Top keyword</td>
                                                        <td>Percent of search traffic</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $keywords = explode(',', $alexa_inf[0]['top_5_keyword']);
                                                    $rate_keywords = explode(',', $alexa_inf[0]['rate_keyword']);
                                                    $count = count($keywords);
                                                    ?>
                                                    @for($i = 0 ; $i < $count - 1; $i++)
                                                        <tr>
                                                            <td>{{str_replace('+',' ',rawurldecode(trim($keywords[$i],'"')))}}</td>
                                                            <td>{{trim($rate_keywords[$i],'"')}}</td>
                                                        </tr>
                                                    @endfor
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12"
                                                 style="text-align: center;margin-top: 40px;">
                                                <img src="{{$alexa_inf[0]['image_search_traffic']}}"
                                                     alt="">
                                                <h4 style="text-align: center">Search traffic</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                {{--Information website--}}
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h3 class="title-inf">Information website</h3>
                                        <hr class="hr-inf">
                                        <div class="information-html">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
                                                        <td style="width: 30%">Attribute</td>
                                                        <td style="font-weight: 500;">Parameter</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="td-attribute">Domain</td>
                                                        <td class="td-parameter">{{$who_is_inf[0]['domain']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="td-attribute">Title</td>
                                                        <td class="td-parameter">{{str_replace('+',' ',rawurldecode($website_inf[0]['title']))}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="td-attribute">Language</td>
                                                        <td class="td-parameter">{{str_replace('+',' ',rawurldecode($website_inf[0]['language']))}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="td-attribute">Description</td>
                                                        <td class="td-parameter">{{str_replace('+',' ',rawurldecode($website_inf[0]['description']))}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="td-attribute">Keyword</td>
                                                        <td class="td-parameter">{{str_replace('+',' ',rawurldecode($website_inf[0]['keyword']))}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="td-attribute">Backlink</td>
                                                        <td class="td-parameter">{{$alexa_inf[0]['quantity_backlink']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="td-attribute">Author</td>
                                                        <td class="td-parameter">{{str_replace('+',' ',rawurldecode($website_inf[0]['author']))}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="td-attribute">Position</td>
                                                        <td class="td-parameter">{{$website_inf[0]['position']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="td-attribute">Place name</td>
                                                        <td class="td-parameter">{{str_replace('+',' ',rawurldecode($website_inf[0]['place_name']))}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="td-attribute">Distributions</td>
                                                        <td class="td-parameter">{{str_replace('+',' ',rawurldecode($website_inf[0]['distributions']))}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="td-attribute">Revisit affter</td>
                                                        <td class="td-parameter">{{str_replace('+',' ',rawurldecode($website_inf[0]['revisit_affter']))}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="td-attribute">Update at</td>
                                                        <td class="td-parameter">{{date('d-m-Y',$website_inf[0]['created_at'])}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--Upstream sites--}}
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h3 class="title-inf">Which sites did people visit immediately before this
                                            site?</h3>
                                        <hr class="hr-inf">
                                        <div class="chart">
                                            <?php
                                            $upstream_sites = json_decode($alexa_inf[0]['upstream_site']);
                                            ?>
                                            @if(count($upstream_sites) > 3)
                                                <script type="text/javascript">
                                                    window.onload = function () {
                                                        var chart = new CanvasJS.Chart("chartUpstream",
                                                            {
                                                                animationEnabled: true,
                                                                animationDuration: 2000,
                                                                axisY: {
                                                                    //     minimum: 50,
                                                                    maximum: 50,
                                                                    suffix: "%"
                                                                },
                                                                title: {
                                                                    text: "Upstream Sites"
                                                                },
                                                                data: [

                                                                    {
                                                                        dataPoints: [
                                                                            {
                                                                                x: 1,
                                                                                y: {{trim($upstream_sites[0][0]->rate,'%')}},
                                                                                label: "{{$upstream_sites[0][0]->site}}"
                                                                            },
                                                                            {
                                                                                x: 2,
                                                                                y: {{trim($upstream_sites[1][0]->rate,'%')}},
                                                                                label: "{{$upstream_sites[1][0]->site}}"
                                                                            },
                                                                            {
                                                                                x: 3,
                                                                                y: {{trim($upstream_sites[2][0]->rate,'%')}},
                                                                                label: "{{$upstream_sites[2][0]->site}}"
                                                                            },
                                                                            {
                                                                                x: 4,
                                                                                y: {{trim($upstream_sites[3][0]->rate,'%')}},
                                                                                label: "{{$upstream_sites[3][0]->site}}"
                                                                            },
                                                                            {
                                                                                x: 5,
                                                                                y: {{trim($upstream_sites[4][0]->rate,'%')}},
                                                                                label: "{{$upstream_sites[4][0]->site}}"
                                                                            }
                                                                        ]
                                                                    }
                                                                ]
                                                            });

                                                        chart.render();
                                                    }
                                                </script>
                                            @else
                                                <script type="text/javascript">
                                                    window.onload = function () {
                                                        var chart = new CanvasJS.Chart("chartUpstream",
                                                            {
                                                                animationEnabled: true,
                                                                animationDuration: 2000,
                                                                axisY: {
                                                                    //     minimum: 50,
                                                                    maximum: 50,
                                                                    suffix: "%"
                                                                },
                                                                title: {
                                                                    text: "Upstream Sites"
                                                                },
                                                                data: [

                                                                    {
                                                                        dataPoints: [
                                                                            {
                                                                                x: 1,
                                                                                y: 0,
                                                                                label: "N/A"
                                                                            },
                                                                            {
                                                                                x: 2,
                                                                                y: 0,
                                                                                label: "N/A"
                                                                            },
                                                                            {
                                                                                x: 3,
                                                                                y: 0,
                                                                                label: "N/A"
                                                                            },
                                                                            {
                                                                                x: 4,
                                                                                y: 0,
                                                                                label: "N/A"
                                                                            },
                                                                            {
                                                                                x: 5,
                                                                                y: 0,
                                                                                label: "N/A"
                                                                            }
                                                                        ]
                                                                    }
                                                                ]
                                                            });

                                                        chart.render();
                                                    }
                                                </script>
                                            @endif
                                            <div id="chartUpstream" style=""></div>
                                        </div>
                                    </div>
                                </div>
                                {{--Whois information--}}
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h3 class="title-inf">Whois information</h3>
                                        <hr class="hr-inf">
                                        <br>
                                        <div class="information-who-is" style="padding-left: 15px;padding-right: 15px;">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <h4 class="danger">Domain information</h4>
                                                    <div class="tech-who-is-inf">
                                                        <table class="table table-hover">
                                                            <tr class="danger">
                                                                <th class="th">Attribute</th>
                                                                <th class="th">Parameter</th>
                                                            </tr>
                                                            <tr class="danger">
                                                                <td>Domain</td>
                                                                <td>{{$who_is_inf[0]['domain']}}</td>
                                                            </tr>
                                                            <tr class="danger">
                                                                <td>Registrar</td>
                                                                <td>{{$who_is_inf[0]['domain_registrar']}}</td>
                                                            </tr>
                                                            <tr class="danger">
                                                                <td>Registration date</td>
                                                                <td>{{$who_is_inf[0]['domain_registration_date']}}</td>
                                                            </tr>
                                                            <tr class="danger">
                                                                <td>Expiration date</td>
                                                                <td>{{$who_is_inf[0]['domain_expiration_date']}}</td>
                                                            </tr>
                                                            <tr class="danger">
                                                                <td>Updated date</td>
                                                                <td>{{$who_is_inf[0]['domain_updated_date']}}</td>
                                                            </tr>
                                                            <tr class="danger">
                                                                <td>Status</td>
                                                                <td>{!! $who_is_inf[0]['domain_status'] !!}</td>
                                                            </tr>
                                                            <tr class="danger">
                                                                <td>Name servers</td>
                                                                <td>{!! $who_is_inf[0]['domain_name_servers'] !!}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <h4 class="info">Admin contact</h4>
                                                    <div class="domain-who-is-inf">
                                                        <table class="table table-hover">
                                                            <tr class="info">
                                                                <th>Attribute</th>
                                                                <th>Parameter</th>
                                                            </tr>
                                                            <tr class="info">
                                                                <td>Admin</td>
                                                                <td>{{$who_is_inf[0]['adm_name']}}</td>
                                                            </tr>
                                                            <tr class="info">
                                                                <td>Organization</td>
                                                                <td>{{$who_is_inf[0]['adm_organization']}}</td>
                                                            </tr>
                                                            <tr class="info">
                                                                <td>Street</td>
                                                                <td>{{$who_is_inf[0]['adm_street']}}</td>
                                                            </tr>
                                                            <tr class="info">
                                                                <td>City</td>
                                                                <td>{{$who_is_inf[0]['adm_city']}}</td>
                                                            </tr>
                                                            <tr class="info">
                                                                <td>State</td>
                                                                <td>{{$who_is_inf[0]['adm_state']}}</td>
                                                            </tr>
                                                            <tr class="info">
                                                                <td>Poscal code</td>
                                                                <td>{{$who_is_inf[0]['adm_postal_code']}}</td>
                                                            </tr>
                                                            <tr class="info">
                                                                <td>Country</td>
                                                                <td>{{$who_is_inf[0]['adm_country']}}</td>
                                                            </tr>
                                                            <tr class="info">
                                                                <td>Phone</td>
                                                                <td>{{$who_is_inf[0]['adm_phone']}}</td>
                                                            </tr>
                                                            <tr class="info">
                                                                <td>Fax</td>
                                                                <td>{{$who_is_inf[0]['adm_fax']}}</td>
                                                            </tr>
                                                            <tr class="info">
                                                                <td>Email</td>
                                                                <td>{!! $who_is_inf[0]['adm_email'] !!}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <h4 class="success">Registant contact</h4>
                                                    <div class="adm-who-is-inf">
                                                        <table class="table table-hover">
                                                            <tr class="success">
                                                                <th class="th">Attribute</th>
                                                                <th class="th">Parameter</th>
                                                            </tr>
                                                            <tr class="success">
                                                                <td>Admin</td>
                                                                <td>{{$who_is_inf[0]['regis_name']}}</td>
                                                            </tr>
                                                            <tr class="success">
                                                                <td>Organization</td>
                                                                <td>{{$who_is_inf[0]['regis_organization']}}</td>
                                                            </tr>
                                                            <tr class="success">
                                                                <td>Street</td>
                                                                <td>{{$who_is_inf[0]['regis_street']}}</td>
                                                            </tr>
                                                            <tr class="success">
                                                                <td>City</td>
                                                                <td>{{$who_is_inf[0]['regis_city']}}</td>
                                                            </tr>
                                                            <tr class="success">
                                                                <td>State</td>
                                                                <td>{{$who_is_inf[0]['regis_state']}}</td>
                                                            </tr>
                                                            <tr class="success">
                                                                <td>Poscal code</td>
                                                                <td>{{$who_is_inf[0]['regis_postal_code']}}</td>
                                                            </tr>
                                                            <tr class="success">
                                                                <td>Country</td>
                                                                <td>{{$who_is_inf[0]['regis_country']}}</td>
                                                            </tr>
                                                            <tr class="success">
                                                                <td>Phone</td>
                                                                <td>{{$who_is_inf[0]['regis_phone']}}</td>
                                                            </tr>
                                                            <tr class="success">
                                                                <td>Fax</td>
                                                                <td>{{$who_is_inf[0]['regis_fax']}}</td>
                                                            </tr>
                                                            <tr class="success">
                                                                <td>Email</td>
                                                                <td>{!! $who_is_inf[0]['regis_email'] !!}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <h4 class="warning">Technology contact</h4>
                                                    <div class="regis-who-is-inf">
                                                        <table class="table table-hover">
                                                            <tr class="warning">
                                                                <th class="th">Attribute</th>
                                                                <th class="th">Parameter</th>
                                                            </tr>
                                                            <tr class="warning">
                                                                <td>Admin</td>
                                                                <td>{{$who_is_inf[0]['tech_name']}}</td>
                                                            </tr>
                                                            <tr class="warning">
                                                                <td>Organization</td>
                                                                <td>{{$who_is_inf[0]['tech_organization']}}</td>
                                                            </tr>
                                                            <tr class="warning">
                                                                <td>Street</td>
                                                                <td>{{$who_is_inf[0]['tech_street']}}</td>
                                                            </tr>
                                                            <tr class="warning">
                                                                <td>City</td>
                                                                <td>{{$who_is_inf[0]['tech_city']}}</td>
                                                            </tr>
                                                            <tr class="warning">
                                                                <td>State</td>
                                                                <td>{{$who_is_inf[0]['tech_state']}}</td>
                                                            </tr>
                                                            <tr class="warning">
                                                                <td>Poscal code</td>
                                                                <td>{{$who_is_inf[0]['tech_postal_code']}}</td>
                                                            </tr>
                                                            <tr class="warning">
                                                                <td>Country</td>
                                                                <td>{{$who_is_inf[0]['tech_country']}}</td>
                                                            </tr>
                                                            <tr class="warning">
                                                                <td>Phone</td>
                                                                <td>{{$who_is_inf[0]['tech_phone']}}</td>
                                                            </tr>
                                                            <tr class="warning">
                                                                <td>Fax</td>
                                                                <td>{{$who_is_inf[0]['tech_fax']}}</td>
                                                            </tr>
                                                            <tr class="warning">
                                                                <td>Email</td>
                                                                <td>{!! $who_is_inf[0]['tech_email'] !!}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--Website relative--}}
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6 col-md-offset-3">
                                        <div class="website_related">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <h3>Website related</h3>
                                                <table class="table table-hover">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Domain</th>
                                                    </tr>
                                                    <?php
                                                    $website_related = json_decode($alexa_inf[0]['website_related']);
                                                    $i = 0;
                                                    ?>
                                                    @foreach($website_related as $item)
                                                        <tr>
                                                            <td>{{$i}}</td>
                                                            <td>
                                                                <a href="{{route('informationDomain',['domain_name'=>$item])}}">
                                                                    <img src="https://www.google.com/s2/favicons?domain=http://{{$item}}"
                                                                         alt="">
                                                                    {{$item}}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php $i++; ?>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Portfolio Section -->
    </div>
    <?php
    $inf_traffic_over = json_decode($alexa_inf[0]['traffic_over']);
    $code_country = [];
    foreach ($inf_traffic_over as $item) {
        $name_country = substr($item[0]->name_country,7);
        if (isset($array_code_country[$name_country])) {
            $code_country[] = $array_code_country[$name_country];
        } else {
            $code_country[] = $name_country;
        }
    }
    ?>

@endsection
@section('script')
    <script>
        var map = AmCharts.makeChart("chartdiv", {

            "type": "map",
            "theme": "light",
            "projection": "miller",

            "dataProvider": {
                "map": "worldLow",
                "getAreasFromMap": true,
                "areas": [
                    {"id": "{{$code_country[0]}}", "color": "#CC0000"},
                    {"id": "{{$code_country[1]}}", "color": "#0000CC"},
                    {"id": "{{$code_country[2]}}", "color": "#00CC00"},
                    {"id": "{{$code_country[3]}}", "color": "#cca020"},
                    {"id": "{{$code_country[4]}}", "color": "#ccc604"}
                ]
            },
            "areasSettings": {
                "autoZoom": true,
                "selectedColor": "#CC0000"
            },
            "smallMap": {},
            "export": {
                "enabled": true,
                "position": "bottom-right"
            }
        });
        $('#loader').hide('slow');
        $('#myDiv').show('slow');
        $('body').attr('style', '');
    </script>
@endsection
