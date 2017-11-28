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
            <div class="row">
                <form role="form" action="{{route('postAddSettingIndex')}}" method="post" id="setting_form">
                    {{csrf_field()}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Setting page</label>
                            <select name="setting_page" class="form-control">
                                <option value="index">Page index</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <label>Key setting</label>
                            <input class="form-control" placeholder="Enter text" name="key_setting">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Value setting</label>
                            <textarea class="form-control" rows="3" name="value_setting"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Add setting</button>
                        <a href="{{URL::previous()}}" class="btn btn-default">Return</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#setting_form').validate({
                errorElement: 'span',
                errorClass: 'help-block',
                focusInvalid: false,
                rules: {
                    'key_setting': {
                        required: true
                    },
                    'value_setting': {
                        required: true
                    }
                },
                messages: {
                    'key_setting': {
                        required: "Must not to blank title !"
                    },
                    'value_setting': {
                        required: "Must not to blank static path !"
                    }
                }
            })
        });
    </script>
@endsection