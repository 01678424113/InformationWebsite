<div class="page-bar" style="margin-bottom: 10px;">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{route('home_admin')}}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{$title}}</span>
        </li>
    </ul>
    <div class="page-toolbar">
        <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body"
             data-placement="bottom" data-original-title="Change dashboard date range">
            <i class="icon-calendar"></i>&nbsp;
            <span class="thin uppercase hidden-xs"></span>&nbsp;
            <i class="fa fa-angle-down"></i>
        </div>
    </div>
</div>