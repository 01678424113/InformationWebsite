@extends('frontend.layout')
@section('content')
    <div class="col-lg-6">
        <form action="{{route('getInformationDomain')}}" method="get">
            <div class="input-group">
                <input type="text" name="txt-domain" class="form-control" placeholder="Search for..."
                       aria-label="Search for...">
                <span class="input-group-btn">
        <button class="btn btn-secondary" type="submit">Go!</button>
      </span>
            </div>
        </form>
    </div>
@endsection
