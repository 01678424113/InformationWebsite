@extends('frontend.layout')
@section('content')
    <div class="content">

        <!-- Divider -->
        <hr class="mt-0 mb-0 "/>
        <!-- End Divider -->

        @include('frontend.widget.top-500',['top_500s'=>$top_500s])

        @include('frontend.widget.block-seven')

        @include('frontend.widget.block-eight')

        @include('frontend.widget.block-nine')


    </div>
@endsection

