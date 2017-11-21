
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-light " data-keep-expanded="false"
            data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!-- END SIDEBAR TOGGLER BUTTON -->
            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
            <li class="sidebar-search-wrapper">
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
                    <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                    </a>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                                            <a href="javascript:;" class="btn submit">
                                                <i class="icon-magnifier"></i>
                                            </a>
                                        </span>
                    </div>
                </form>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            <li class="nav-item start active open">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="selected"></span>
                    <span class="arrow open"></span>
                </a>
            </li>
            <li class="heading">
                <h3 class="uppercase">Features</h3>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-briefcase"></i>
                    <span class="title">Tables</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="table_static_basic.html" class="nav-link ">
                            <span class="title">Basic Tables</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="table_static_responsive.html" class="nav-link ">
                            <span class="title">Responsive Tables</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="table_bootstrap.html" class="nav-link ">
                            <span class="title">Bootstrap Tables</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <span class="title">Datatables</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item ">
                                <a href="table_datatables_managed.html" class="nav-link "> Managed
                                    Datatables </a>
                            </li>
                            <li class="nav-item ">
                                <a href="table_datatables_buttons.html" class="nav-link "> Buttons
                                    Extension </a>
                            </li>
                            <li class="nav-item ">
                                <a href="table_datatables_colreorder.html" class="nav-link "> Colreorder
                                    Extension </a>
                            </li>
                            <li class="nav-item ">
                                <a href="table_datatables_rowreorder.html" class="nav-link "> Rowreorder
                                    Extension </a>
                            </li>
                            <li class="nav-item ">
                                <a href="table_datatables_scroller.html" class="nav-link "> Scroller
                                    Extension </a>
                            </li>
                            <li class="nav-item ">
                                <a href="table_datatables_fixedheader.html" class="nav-link "> FixedHeader
                                    Extension </a>
                            </li>
                            <li class="nav-item ">
                                <a href="table_datatables_responsive.html" class="nav-link "> Responsive
                                    Extension </a>
                            </li>
                            <li class="nav-item ">
                                <a href="table_datatables_editable.html" class="nav-link "> Editable
                                    Datatables </a>
                            </li>
                            <li class="nav-item ">
                                <a href="table_datatables_ajax.html" class="nav-link "> Ajax Datatables </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="?p=" class="nav-link nav-toggle">
                    <i class="icon-wallet"></i>
                    <span class="title">Portlets</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="portlet_boxed.html" class="nav-link ">
                            <span class="title">Boxed Portlets</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="portlet_light.html" class="nav-link ">
                            <span class="title">Light Portlets</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="portlet_solid.html" class="nav-link ">
                            <span class="title">Solid Portlets</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="portlet_ajax.html" class="nav-link ">
                            <span class="title">Ajax Portlets</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="portlet_draggable.html" class="nav-link ">
                            <span class="title">Draggable Portlets</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Charts</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="charts_amcharts.html" class="nav-link ">
                            <span class="title">amChart</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="charts_flotcharts.html" class="nav-link ">
                            <span class="title">Flot Charts</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="charts_flowchart.html" class="nav-link ">
                            <span class="title">Flow Charts</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="charts_google.html" class="nav-link ">
                            <span class="title">Google Charts</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="charts_echarts.html" class="nav-link ">
                            <span class="title">eCharts</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="charts_morris.html" class="nav-link ">
                            <span class="title">Morris Charts</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <span class="title">HighCharts</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item ">
                                <a href="charts_highcharts.html" class="nav-link "> HighCharts </a>
                            </li>
                            <li class="nav-item ">
                                <a href="charts_highstock.html" class="nav-link "> HighStock </a>
                            </li>
                            <li class="nav-item ">
                                <a href="charts_highmaps.html" class="nav-link "> HighMaps </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-pointer"></i>
                    <span class="title">Maps</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="maps_google.html" class="nav-link ">
                            <span class="title">Google Maps</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="maps_vector.html" class="nav-link ">
                            <span class="title">Vector Maps</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
