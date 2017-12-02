@extends('admin.layout')
@section('content')
    <div class="content">
        <div class="row">
            <h2 style="margin-left: 15px">Domain :
                <a href="" style="font-size: 25px">
                    <img src="{{$website_inf[0]->icon}}" alt="">
                    {{$alexa_inf[0]->domain}}
                </a>
            </h2>
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-social-dribbble font-green"></i>
                                    <span class="caption-subject font-green bold uppercase">Alexa</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-cloud-upload"></i>
                                    </a>
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-wrench"></i>
                                    </a>
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-trash"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Attribute</th>
                                            <th>Value</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Global rank</td>
                                            <td>{{$alexa_inf[0]->global_rank}}</td>
                                        </tr>
                                        <tr>
                                            <td>Country</td>
                                            <td>{{$alexa_inf[0]->country}}</td>
                                        </tr>
                                        <tr>
                                            <td>Country rank</td>
                                            <td>
                                                <img src="{{$alexa_inf[0]->flag_country}}" alt="">
                                                {{$alexa_inf[0]->country_rank}}</td>
                                        </tr>
                                        <tr>
                                            <td>Bounce percent</td>
                                            <td>{{$alexa_inf[0]->bounce_percent}}</td>
                                        </tr>
                                        <tr>
                                            <td>Time on site</td>
                                            <td>{{$alexa_inf[0]->time_on_site}} min</td>
                                        </tr>
                                        <tr>
                                            <td>Image search traffic</td>
                                            <td>
                                                <button type="button" class="btn btn-info" data-toggle="modal"
                                                        data-target="#image_search_traffic">Vỉew
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Keyword</td>
                                            <td>{{trim(str_replace('+','',$alexa_inf[0]->top_5_keyword),'"')}}</td>
                                        </tr>
                                        <tr>
                                            <td>Backlink</td>
                                            <td>{{$alexa_inf[0]->quantity_backlink}}</td>
                                        </tr>
                                        <tr>
                                            <td>Rate male</td>
                                            <td>{{$alexa_inf[0]->rate_male}}</td>
                                        </tr>
                                        <tr>
                                            <td>Rate female</td>
                                            <td>{{$alexa_inf[0]->rate_female}}</td>
                                        </tr>
                                        <tr>
                                            <td>Rate home</td>
                                            <td>{{$alexa_inf[0]->rate_home}}</td>
                                        </tr>
                                        <tr>
                                            <td>Rate school</td>
                                            <td>{{$alexa_inf[0]->rate_school}}</td>
                                        </tr>
                                        <tr>
                                            <td>Update at</td>
                                            <td>{{date('d-m-Y',$alexa_inf[0]['created_at'])}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END SAMPLE TABLE PORTLET-->
                        <div id="image_search_traffic" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Image search traffic</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            <img src="{{$alexa_inf[0]->image_search_traffic}}"
                                                 style="display: flex;margin: auto" alt="">
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-social-dribbble font-green"></i>
                                    <span class="caption-subject font-green bold uppercase">Website information</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-cloud-upload"></i>
                                    </a>
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-wrench"></i>
                                    </a>
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-trash"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Attribute</th>
                                            <th>Value</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Title</td>
                                            <td>
                                                <img src="{{$website_inf[0]->icon}}" alt="">
                                                {{str_replace('+',' ',rawurldecode($website_inf[0]->title))}}</td>
                                        </tr>
                                        <tr>
                                            <td>Screen shot</td>
                                            <td>
                                                <button type="button" class="btn btn-info" data-toggle="modal"
                                                        data-target="#image_screen_shot">View
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Language</td>
                                            <td>{{str_replace('+',' ',$website_inf[0]->language)}}</td>
                                        </tr>
                                        <tr>
                                            <td>Distributions</td>
                                            <td>{{str_replace('+',' ',$website_inf[0]->distributions)}}</td>
                                        </tr>
                                        <tr>
                                            <td>Revisit affter</td>
                                            <td>{{$website_inf[0]->revisit_affter}}</td>
                                        </tr>
                                        <tr>
                                            <td>Author</td>
                                            <td>{{$website_inf[0]->author}}</td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td>{{str_replace('+',' ',rawurldecode($website_inf[0]->description))}}</td>
                                        </tr>
                                        <tr>
                                            <td>Keyword</td>
                                            <td>
                                                {{str_replace('+',' ',rawurldecode($website_inf[0]->keyword))}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Place name</td>
                                            <td>{{str_replace('+',' ',rawurldecode($website_inf[0]->place_name))}}</td>
                                        </tr>
                                        <tr>
                                            <td>Position</td>
                                            <td>{{$website_inf[0]->position}}</td>
                                        </tr>
                                        <tr>
                                            <td>Title auto</td>
                                            <td>{!! $website_inf[0]->title_website_auto !!}</td>
                                        </tr>
                                        <tr>
                                            <td>H1 auto</td>
                                            <td>{!! $website_inf[0]->h1_website_auto !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Content top auto</td>
                                            <td>{!! $website_inf[0]->content_top_website_auto !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Content bot auto</td>
                                            <td>{!! $website_inf[0]->content_bot_website_auto !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Alt auto</td>
                                            <td>{!! $website_inf[0]->alt_website_auto !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Update at</td>
                                            <td>{{date('d-m-Y',$website_inf[0]['created_at'])}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END SAMPLE TABLE PORTLET-->
                        <div id="image_screen_shot" class="modal fade" role="dialog">
                            <div class="modal-dialog" style="width: max-content">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Screen shot</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            <img src="{{$website_inf[0]->image_screen_shot}}"
                                                  alt="">
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-social-dribbble font-green"></i>
                                    <span class="caption-subject font-green bold uppercase">Domain information</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-cloud-upload"></i>
                                    </a>
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-wrench"></i>
                                    </a>
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-trash"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Attribute</th>
                                            <th>Value</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Domain</td>
                                            <td>{{$who_is_inf[0]->domain}}</td>
                                        </tr>
                                        <tr>
                                            <td>Registrar</td>
                                            <td>{{$who_is_inf[0]->domain_registrar}}</td>
                                        </tr>
                                        <tr>
                                            <td>Registration date</td>
                                            <td>{{$who_is_inf[0]->domain_registration_date}}</td>
                                        </tr>
                                        <tr>
                                            <td>Expiration date</td>
                                            <td>{{$who_is_inf[0]->domain_expiration_date}}</td>
                                        </tr>
                                        <tr>
                                            <td>Updated date</td>
                                            <td>{{$who_is_inf[0]->domain_updated_date}}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>{!! $who_is_inf[0]->domain_status !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Name servers</td>
                                            <td>{!! $who_is_inf[0]->domain_name_servers !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Created at</td>
                                            <td>{{date('d-m-Y',$who_is_inf[0]['created_at'])}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-social-dribbble font-green"></i>
                                    <span class="caption-subject font-green bold uppercase">Administrative contact</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-cloud-upload"></i>
                                    </a>
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-wrench"></i>
                                    </a>
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-trash"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Attribute</th>
                                            <th>Value</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td>{{$who_is_inf[0]->adm_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Organization</td>
                                            <td>{{$who_is_inf[0]->adm_organization}}</td>
                                        </tr>
                                        <tr>
                                            <td>Street</td>
                                            <td>{{$who_is_inf[0]->adm_organization}}</td>
                                        </tr>
                                        <tr>
                                            <td>City</td>
                                            <td>{{$who_is_inf[0]->adm_city}}</td>
                                        </tr>
                                        <tr>
                                            <td>State</td>
                                            <td>{{$who_is_inf[0]->adm_state}}</td>
                                        </tr>
                                        <tr>
                                            <td>Postal code</td>
                                            <td>{{ $who_is_inf[0]->adm_postal_code }}</td>
                                        </tr>
                                        <tr>
                                            <td>Country</td>
                                            <td>{{ $who_is_inf[0]->adm_country }}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td>{{ $who_is_inf[0]->adm_phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Fax</td>
                                            <td>{{ $who_is_inf[0]->adm_fax }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ $who_is_inf[0]->adm_email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Created at</td>
                                            <td>{{date('d-m-Y',$who_is_inf[0]['created_at'])}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-social-dribbble font-green"></i>
                                    <span class="caption-subject font-green bold uppercase">Registrant contact</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-cloud-upload"></i>
                                    </a>
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-wrench"></i>
                                    </a>
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-trash"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Attribute</th>
                                            <th>Value</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td>{{$who_is_inf[0]->regis_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Organization</td>
                                            <td>{{$who_is_inf[0]->regis_organization}}</td>
                                        </tr>
                                        <tr>
                                            <td>Street</td>
                                            <td>{{$who_is_inf[0]->regis_street}}</td>
                                        </tr>
                                        <tr>
                                            <td>City</td>
                                            <td>{{$who_is_inf[0]->regis_city}}</td>
                                        </tr>
                                        <tr>
                                            <td>State</td>
                                            <td>{{$who_is_inf[0]->regis_state}}</td>
                                        </tr>
                                        <tr>
                                            <td>Postal code</td>
                                            <td>{{ $who_is_inf[0]->regis_postal_code }}</td>
                                        </tr>
                                        <tr>
                                            <td>Country</td>
                                            <td>{{ $who_is_inf[0]->regis_country }}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td>{{ $who_is_inf[0]->regis_phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Fax</td>
                                            <td>{{ $who_is_inf[0]->regis_fax }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ $who_is_inf[0]->regis_email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Created at</td>
                                            <td>{{date('d-m-Y',$who_is_inf[0]['created_at'])}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-social-dribbble font-green"></i>
                                    <span class="caption-subject font-green bold uppercase">Technical contact</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-cloud-upload"></i>
                                    </a>
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-wrench"></i>
                                    </a>
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-trash"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Attribute</th>
                                            <th>Value</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td>{{$who_is_inf[0]->tech_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Organization</td>
                                            <td>{{$who_is_inf[0]->tech_organization}}</td>
                                        </tr>
                                        <tr>
                                            <td>Street</td>
                                            <td>{{$who_is_inf[0]->tech_organization}}</td>
                                        </tr>
                                        <tr>
                                            <td>City</td>
                                            <td>{{$who_is_inf[0]->tech_city}}</td>
                                        </tr>
                                        <tr>
                                            <td>State</td>
                                            <td>{{$who_is_inf[0]->tech_state}}</td>
                                        </tr>
                                        <tr>
                                            <td>Postal code</td>
                                            <td>{{ $who_is_inf[0]->tech_postal_code }}</td>
                                        </tr>
                                        <tr>
                                            <td>Country</td>
                                            <td>{{ $who_is_inf[0]->tech_country }}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td>{{ $who_is_inf[0]->tech_phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Fax</td>
                                            <td>{{ $who_is_inf[0]->tech_fax }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ $who_is_inf[0]->tech_email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Created at</td>
                                            <td>{{date('d-m-Y',$who_is_inf[0]['created_at'])}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection