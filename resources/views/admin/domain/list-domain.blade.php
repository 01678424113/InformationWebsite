@extends('admin.layout')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
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
                                    <th>Domain</th>
                                    <th>Information</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($domains as $domain)
                                    <tr>
                                        <td>{{$domain->domain}}</td>
                                        <td>
                                            <form action="{{route('informationDomainAdmin')}}" method="get">
                                                {{csrf_field()}}
                                                <input type="text" name="domain_name" value="{{$domain->domain}}" style="display:none;">
                                                <button type="submit" class="btn btn-info">Watch now</button>
                                            </form>
                                        </td>
                                        <td>{{$domain->created_at}}</td>
                                        <td>{{$domain->created_at}}</td>
                                        <td>
                                            <button type="button" class="btn btn-info">Update</button>
                                        </td>
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