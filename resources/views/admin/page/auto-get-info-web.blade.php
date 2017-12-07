@extends('admin.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{$title}}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{session('error')}}
                </div>
            @elseif(session('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
            @endif
            @if(count($errors) > 0)
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{$error}}
                    </div>
                @endforeach
            @endif
            <div class="col-md-12">
                @if(!isset($spider_get_domain))
                    <form class="form-horizontal" action="{{route('spiderGetDomain')}}" method="get">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="control-label" for="domain_use_auto" style="margin-bottom: 10px;">Domain use
                                auto
                                :</label>
                            <input type="text" class="form-control" name="domain_use_auto" placeholder="Domain use"
                                   style="max-width: 250px">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default">Auto get</button>
                        </div>
                    </form>
                @else
                    <?php
                    $spider_get_domain = implode(';',$spider_get_domain);
                    ?>
                    <form action="" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label" for="domain_use_auto" style="margin-bottom: 10px;">List domain
                                get auto
                                :</label>
                            <textarea class="form-control" id="list-domain-get-auto" name="list-domain-get-auto"
                                      rows="5"
                                      placeholder="">{{$spider_get_domain}}</textarea>
                        </div>
                    </form>
                @endif
            </div>
            <div class="col-md-12">
                <form class="form-horizontal" action="{{route('doAutoGetInfoWeb')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="control-label" for="list_domain" style="margin-bottom: 10px;">List domain
                            :</label>
                        <textarea class="form-control" id="list-domain" name="list_domain" rows="5"
                                  placeholder="Enter list domain"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
