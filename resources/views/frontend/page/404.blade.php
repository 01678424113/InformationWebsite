@extends('frontend.layout')
@section('content')
    <div class="content">

        <!-- Divider -->
        <hr class="mt-0 mb-0 "/>
        <!-- End Divider -->
        <div class="container" style="text-align: center">
            <div class="404">
                <img src="image/404.gif" style="max-height: 340px;" alt="Checking website - Website traffic">
            </div>
            <h3>Sorry! Not Found Page</h3>
            <hr class="hr-title">
        </div>
        @include('frontend.widget.block-info-provide')


        @include('frontend.widget.block-one')

    </div>
@endsection

