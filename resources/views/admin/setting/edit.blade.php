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
            <form role="form" action="{{route('postEditSetting',['setting_id'=>$setting->id])}}" method="post"
                  id="setting_form" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label>Key setting</label>
                    <input class="form-control" placeholder="Enter text" name="key_setting"
                           value="{{$setting->key_setting}}">
                </div>
                @if($setting->key_setting != "logo")
                <div class="form-group">
                    <label>Value setting</label>
                    <textarea class="form-control" rows="15" name="value_setting">{{$setting->value_setting}}</textarea>
                </div>
                @else
                <div class="form-group">
                    <label class="control-label">Ảnh tiêu biểu</label>
                    <div>
                        <a role="button" data-toggle="modal" data-target="#featured-modal">
                            @if(!empty($setting->value_setting))
                                <img src="{{$setting->value_setting}}"
                                     data-old="{{$setting->value_setting}}"
                                     style="max-width: 20%" id="featured-img"
                                     class="img-thumbnail"
                                />
                            @else
                                <img src="images/default-image.png"
                                     data-old="images/default-image.png"
                                     style="max-width: 20%" id="featured-img"
                                     class="img-thumbnail"
                                />
                            @endif
                        </a>
                    </div>
                    <div id="featured-modal" class="modal fade" tabindex="-1" data-keyboard="false" style="margin-top: 5%">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"></button>
                                    <h4 class="modal-title text-uppercase">Chọn ảnh tiêu biểu</h4>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="txt-featured-type" value="none">
                                    <div class="form-group">
                                        <label class="control-label">Chọn từ files</label>
                                        <input type="file" class="form-control" name="file-featured"
                                               accept="image/*">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">URL ảnh</label>
                                        <input type="text" class="form-control" name="txt-featured">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="btn-featured" class="btn blue text-uppercase">
                                        Xác nhận
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <button type="submit" class="btn btn-default">Edit setting</button>
                {{--<a href="http://localhost/FacebookDownload/public/manage-admin/{{$route_return}}" class="btn btn-default">Return</a>--}}
                <a href="{{URL::previous()}}" class="btn btn-default">Return</a>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
           /* $('#setting_form').validate({
                errorElement: 'span',
                errorClass: 'help-block',
                focusInvalid: false,
                rules: {
                    'key_setting': {
                        required: true
                    },
                    'file-featured': {
                        accept: "image/!*"
                    }
                },
                messages: {
                    'key_setting': {
                        required: "Must not to blank title !"
                    },
                    'file-featured': {
                        accept: "Logo không hợp lệ"
                    }
                }
            });*/
            $('#setting_form').find('input[name="file-featured"]').change(function () {
                var files = $('#featured-modal').find('input[name="file-featured"]').prop('files');
                if (files.length) {
                    var regex_type = /^(image\/jpeg|image\/png|image\/gif|image\/ico)$/;
                    $.each(files, function (key, file) {
                        if (regex_type.test(file.type)) {
                            var fr = new FileReader();
                            fr.readAsDataURL(file);
                            fr.onload = function (event) {
                                $('#featured-img').attr('src', event.target.result);
                                $('#setting_form').find('input[name="txt-featured-type"]').val('file');
                                $('#featured-modal').find('input[name="txt-featured"]').val("");
                                $('#featured-modal').modal('hide');
                            };
                        } else {
                            $('#featured-img').attr('src', $('#featured-img').data('old'));
                            $('#setting_form').find('input[name="txt-featured-type"]').val('none');
                        }
                    });
                } else {
                    $('#featured-img').attr('src', $('#featured-img').data('old'));
                    $('#setting_form').find('input[name="txt-featured-type"]').val('none');
                }
            });
            $('#btn-featured').click(function () {
                var url = $('#featured-modal').find('input[name="txt-featured"]').val();
                var regex_url = /(https?:\/\/(.*)\.(png|jpg|jpeg|gif|ico))/i;
                if (url !== "" && regex_url.test(url)) {
                    $('#featured-img').attr('src', url);
                    $('#setting_form').find('input[name="txt-featured-type"]').val('url');
                    $('#setting_form').find('input[name="file-featured"]').val(null);
                }
                $('#featured-modal').modal('hide');
            });
        });
    </script>
@endsection