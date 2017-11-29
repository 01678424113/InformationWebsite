@extends('admin.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{$title}}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{session('error')}}
                        </div>
                    @elseif(session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif
                    <table width="100%" class="table table-striped table-bordered table-hover"
                           id="dataTables-example">
                        @if(count($settings)>0)
                            <thead>
                            <tr>
                                <th>Key</th>
                                <th>Value</th>
                                <th style="width: 80px">Edit</th>
                                <th style="width: 80px">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($settings as $setting)
                                <tr class="odd gradeX">
                                    <td>{{$setting->key_setting}}</td>
                                    <td>{{str_limit($setting->value_setting,500,'...')}}</td>
                                    <td class="center">
                                        <a href="{{route('getEditSetting',['setting_id'=>$setting->id])}}"
                                           class="btn btn-info">Edit</a>
                                    </td>
                                    <td class="center">
                                        <button type="button" data-toggle="modal"
                                                data-target="#myModal-{{$setting->id}}"
                                                class="btn btn-danger" disabled>Delete
                                        </button>
                                        <!-- Modal delete -->
                                        <div id="myModal-{{$setting->id}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;
                                                        </button>
                                                        <h4 class="modal-title">Delete</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure want to delete ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="{{route('deleteSetting',['setting_id'=>$setting->id])}}"
                                                           class="btn btn-danger" disabled="">Delete</a>
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        @else
                            <p>Data empty</p>
                        @endif
                    </table>
                {{$settings->links()}}
                <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
@endsection