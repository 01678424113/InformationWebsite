@extends('admin.layout')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-social-dribbble font-green"></i>
                            <span class="caption-subject font-green bold uppercase">{{$title}}</span>
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
                                    <th> Rank</th>
                                    <th>Root domain</th>
                                    <th>Linking root domain</th>
                                    <th> External link</th>
                                    <th> Domain mozrank</th>
                                    <th>Domain moztrust</th>
                                    <th>Change rank</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($top_500s as $top_500)
                                    <tr>
                                        <td> {{$top_500->rank}}</td>
                                        <td> {{$top_500->root_domain}}</td>
                                        <td> {{$top_500->linking_root_domain}}</td>
                                        <td> {{$top_500->external_link}}</td>
                                        <td> {{$top_500->domain_mozrank}}</td>
                                        <td> {{$top_500->domain_moztrust}}</td>
                                        <td> {{$top_500->change_rank}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
@endsection