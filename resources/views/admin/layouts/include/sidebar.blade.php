<?php
$lang = LaravelLocalization::getCurrentLocale() ;
$float = "right";
$trans = 'en';
if ($lang == "en") {
    $float = "left";
    $trans = 'ar';
}
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" dir="{{$dir}}">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="image float-{{$float}}">
                <img src="{{URL::to('admin_panel')}}/images/user2-160x160.jpg" class="rounded" alt="User Image">
            </div>
            <div class="info float-right">
                <p>{{Auth::user()->username}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> {{trans('layout.online')}}</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree" style="padding-bottom: 50px;">
            <?php
            $url = URL::current();
            $patient = $daily = $booking = $opinion = $video = $clients = $advantages = $services = $ques = $contact = $slider = $admins = $projects = $site = $groups = $blogs = $pages = $newsletter = $admin = "";
            if (strpos($url, 'site') !== false) {
                $site = "active";
            } elseif (strpos($url, 'groups') !== false) {
                $groups = "active";
            } elseif (strpos($url, 'news') !== false) {
                $blogs = "active";
            } elseif (strpos($url, 'pages') !== false) {
                $pages = "active";
            } elseif (strpos($url, 'newsletter') !== false) {
                $newsletter = "active";
            } elseif (strpos($url, 'projects') !== false) {
                $projects = "active";
            } elseif (strpos($url, 'admins') !== false) {
                $admins = "active";
            } elseif (strpos($url, 'slider') !== false) {
                $slider = "active";
            } elseif (strpos($url, 'contact') !== false) {
                $contact = "active";
            } elseif (strpos($url, 'ques') !== false) {
                $ques = "active";
            } elseif (strpos($url, 'news') !== false) {
                $blogs = "active";
            } elseif (strpos($url, 'services') !== false) {
                $services = "active";
            } elseif (strpos($url, 'advantages') !== false) {
                $advantages = "active";
            } elseif (strpos($url, 'clients') !== false) {
                $clients = "active";
            } elseif (strpos($url, 'video') !== false) {
                $video = "active";
            } elseif (strpos($url, 'opinion') !== false) {
                $opinion = "active";
            } elseif (strpos($url, 'booking') !== false) {
                $booking = "active";
            } elseif (strpos($url, 'daily') !== false) {
                $daily = "active";
            } elseif (strpos($url, 'patient') !== false) {
                $patient = "active";
            } else {
                $admin = "active";
            }
            $news_role = $patient_role = $daily_role = $booking_role = $opinion_role = $video_role = $clients_role = $advantages_role = $services_role = $ques_role = $contact_role = $slider_role = $admins_role = $projects_role = $site_role = $groups_role = $blog_role = $pages_role = $newsletter_role = $admin_role = FALSE;
            $permissions = \App\Models\Permission::where('group_id', \Auth::user()->group_id)->get();
            foreach ($permissions as $permission) {
                if ($permission['permission'] == 'site') {
                    $site_role = TRUE;
                } elseif ($permission['permission'] == 'groups') {
                    $groups_role = TRUE;
                } elseif ($permission['permission'] == 'news') {
                    $blog_role = TRUE;
                } elseif ($permission['permission'] == 'pages') {
                    $pages_role = TRUE;
                } elseif ($permission['permission'] == 'newsletter') {
                    $newsletter_role = TRUE;
                } elseif ($permission['permission'] == 'projects') {
                    $projects_role = TRUE;
                } elseif ($permission['permission'] == 'admins') {
                    $admins_role = TRUE;
                } elseif ($permission['permission'] == 'slider') {
                    $slider_role = TRUE;
                } elseif ($permission['permission'] == 'contact') {
                    $contact_role = TRUE;
                } elseif ($permission['permission'] == 'ques') {
                    $ques_role = TRUE;
                } elseif ($permission['permission'] == 'services') {
                    $services_role = TRUE;
                } elseif ($permission['permission'] == 'advantages') {
                    $advantages_role = TRUE;
                } elseif ($permission['permission'] == 'clients') {
                    $clients_role = TRUE;
                } elseif ($permission['permission'] == 'video') {
                    $video_role = TRUE;
                } elseif ($permission['permission'] == 'opinion') {
                    $opinion_role = TRUE;
                } elseif ($permission['permission'] == 'booking') {
                    $booking_role = TRUE;
                } elseif ($permission['permission'] == 'daily') {
                    $daily_role = TRUE;
                } elseif ($permission['permission'] == 'patient') {
                    $patient_role = TRUE;
                } elseif ($permission['permission'] == 'news') {
                    $news_role = TRUE;
                }
                //  dd($news_role);
            }
            ?>
            <li class="">
                @if(LaravelLocalization::getCurrentLocale() == 'en')
                <a href="{{ LaravelLocalization::getLocalizedURL('ar') }}" class="lang">العربية</a>
                @else
                <a href="{{ LaravelLocalization::getLocalizedURL('en') }}" class="lang">English</a>
                @endif      
            </li>
            <!--            <li>
                            <a href="{{URL::to('citycenter')}}">
                                <i class="fa fa-eye"></i>
                                <span>{{trans('layout.showcourses')}}</span>
                            </a>
                        </li>-->
            <li class="">
                <a href="{{URL::to('/')}}">
                    <i class="fa fa-home"></i>
                    <span>{{trans('layout.website')}}</span>
                </a>
            </li>

            <li class="{{$admin}}">
                <a href="{{URL::to('admin')}}">
                    <i class="fa fa-dashboard"></i>
                    <span>{{trans('layout.admin')}}</span>
                </a>
            </li>

            @if ($site_role)
            <li class="{{$site}}">
                <a href="{{URL::to('admin/site')}}">
                    <i class="fa fa-th"></i>
                    <span>{{trans('layout.site')}}</span>
                </a>
            </li>
            @endif



            @if ($admins_role)
            <li class="treeview {{$admins}}">
                <a href="#">
                    <i class="fa fa-user-secret"></i>
                    <span>{{trans('layout.admins')}}</span>
                    <span class="pull-{{$arrow}}-container">
                        <i class="fa fa-angle-{{$arrow}} pull-{{$arrow}}"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::to('admin/admins')}}"><i class="fa fa-circle-o"></i> {{trans('layout.show_all')}}</a></li>
                    <li><a href="{{URL::to('admin/admins/create')}}"><i class="fa fa-circle-o"></i> {{trans('layout.admin_add')}}</a></li>
                </ul>
            </li>
            @endif


            <!--            @if ($daily_role)
                        <li class="treeview {{$daily}}">
                            <a href="#">
                                <i class="fa fa-hospital-o"></i>
                                <span>{{trans('layout.daily')}}</span>
                                <span class="pull-{{$arrow}}-container">
                                    <i class="fa fa-angle-{{$arrow}} pull-{{$arrow}}"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{URL::to('admin/daily')}}"><i class="fa fa-circle-o"></i> {{trans('layout.show_all')}}</a></li>
                                <li><a href="{{URL::to('admin/daily/create')}}"><i class="fa fa-circle-o"></i> {{trans('layout.daily_add')}}</a></li>
                            </ul>
                        </li>
                        @endif-->

            <!--            @if ($patient_role)
                        <li class="treeview {{$patient}}">
                            <a href="#">
                                <i class="fa fa-hotel"></i>
                                <span>{{trans('layout.patient')}}</span>
                                <span class="pull-{{$arrow}}-container">
                                    <i class="fa fa-angle-{{$arrow}} pull-{{$arrow}}"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{URL::to('admin/patient')}}"><i class="fa fa-circle-o"></i> {{trans('layout.show_all')}}</a></li>
                                <li><a href="{{URL::to('admin/patient/create')}}"><i class="fa fa-circle-o"></i> {{trans('layout.patient_add')}}</a></li>
                            </ul>
                        </li>
                        @endif-->

            @if ($clients_role)
            <li class="treeview {{$clients}}">
                <a href="#">
                    <i class="fa fa-user-circle"></i>
                    <span>{{trans('layout.clients')}}</span>
                    <span class="pull-{{$arrow}}-container">
                        <i class="fa fa-angle-{{$arrow}} pull-{{$arrow}}"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::to('admin/clients')}}"><i class="fa fa-circle-o"></i> {{trans('layout.show_all')}}</a></li>
                    <li><a href="{{URL::to('admin/clients/create')}}"><i class="fa fa-circle-o"></i> {{trans('layout.client_add')}}</a></li>
                </ul>
            </li>
            @endif
            @if ($opinion_role)
            <li class="treeview {{$opinion}}">
                <a href="#">
                    <i class="fa fa-user-o"></i>
                    <span>{{trans('layout.opinions')}}</span>
                    <span class="pull-{{$arrow}}-container">
                        <i class="fa fa-angle-{{$arrow}} pull-{{$arrow}}"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::to('admin/opinions')}}"><i class="fa fa-circle-o"></i> {{trans('layout.show_all')}}</a></li>
                    <li><a href="{{URL::to('admin/opinions/create')}}"><i class="fa fa-circle-o"></i> {{trans('layout.opinion_add')}}</a></li>
                </ul>
            </li>
            @endif
            @if ($blog_role)
            <li class="treeview {{$blogs}}">
                <a href="#">
                    <i class="fa fa-product-hunt"></i>
                    <span>{{trans('layout.blog')}}</span>
                    <span class="pull-{{$arrow}}-container">
                        <i class="fa fa-angle-{{$arrow}} pull-{{$arrow}}"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::to('admin/news')}}"><i class="fa fa-circle-o"></i> {{trans('layout.show_all')}}</a></li>
                    <li><a href="{{URL::to('admin/news/create')}}"><i class="fa fa-circle-o"></i> {{trans('layout.blog_add')}}</a></li>
                </ul>
            </li>
            @endif
            <!--                @if ($projects_role)
                                <li class="treeview {{$projects}}">
                                    <a href="#">
                                        <i class="fa fa-product-hunt"></i>
                                        <span>{{trans('layout.projects')}}</span>
                                        <span class="pull-{{$arrow}}-container">
                                    <i class="fa fa-angle-{{$arrow}} pull-{{$arrow}}"></i>
                                </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="{{URL::to('admin/projects')}}"><i class="fa fa-circle-o"></i> {{trans('layout.show_all')}}</a></li>
                                        <li><a href="{{URL::to('admin/projects/create')}}"><i class="fa fa-circle-o"></i> {{trans('layout.project_add')}}</a></li>
                                    </ul>
                                </li>
                            @endif-->

            @if ($services_role)
            <li class="treeview {{$services}}">
                <a href="#">
                    <i class="fa fa-share"></i>
                    <span>{{trans('layout.services')}}</span>
                    <span class="pull-{{$arrow}}-container">
                        <i class="fa fa-angle-{{$arrow}} pull-{{$arrow}}"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::to('admin/services')}}"><i class="fa fa-circle-o"></i> {{trans('layout.show_all')}}</a></li>
                    <li><a href="{{URL::to('admin/services/create')}}"><i class="fa fa-circle-o"></i> {{trans('layout.service_add')}}</a></li>
                </ul>
            </li>
            @endif


            @if ($video_role)
            <li class="treeview {{$video}}">
                <a href="#">
                    <i class="fa fa-video-camera"></i>
                    <span>{{trans('layout.videos')}}</span>
                    <span class="pull-{{$arrow}}-container">
                        <i class="fa fa-angle-{{$arrow}} pull-{{$arrow}}"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::to('admin/videos')}}"><i class="fa fa-circle-o"></i> {{trans('layout.show_all')}}</a></li>
                    <li><a href="{{URL::to('admin/videos/create')}}"><i class="fa fa-circle-o"></i> {{trans('layout.video_add')}}</a></li>
                </ul>
            </li>
            @endif


            @if ($pages_role)
            <li class="treeview {{$pages}}">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>{{trans('layout.pages')}}</span>
                    <span class="pull-{{$arrow}}-container">
                        <i class="fa fa-angle-{{$arrow}} pull-{{$arrow}}"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::to('admin/pages')}}"><i class="fa fa-circle-o"></i> {{trans('layout.show_all')}}</a></li>
                    <li><a href="{{URL::to('admin/pages/create')}}"><i class="fa fa-circle-o"></i> {{trans('layout.page_add')}}</a></li>
                </ul>
            </li>  
            @endif

            @if ($slider_role)
            <li class="treeview {{$slider}}">
                <a href="#">
                    <i class="fa fa-photo"></i>
                    <span>{{trans('layout.slider')}}</span>
                    <span class="pull-{{$arrow}}-container">
                        <i class="fa fa-angle-{{$arrow}} pull-{{$arrow}}"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::to('admin/slider')}}"><i class="fa fa-circle-o"></i> {{trans('layout.show_all')}}</a></li>
                    <li><a href="{{URL::to('admin/slider/create')}}"><i class="fa fa-circle-o"></i> {{trans('layout.slider_add')}}</a></li>
                </ul>
            </li>  
            @endif

            @if ($newsletter_role)
            <li class="treeview {{$newsletter}}">
                <a href="#">
                    <i class="fa fa-envelope"></i>
                    <span>{{trans('layout.newsletter')}}</span>
                    <span class="pull-{{$arrow}}-container">
                        <i class="fa fa-angle-{{$arrow}} pull-{{$arrow}}"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::to('admin/newsletter')}}"><i class="fa fa-circle-o"></i> {{trans('layout.show_all')}}</a></li>
                    <li><a href="{{URL::to('admin/newsletter/create')}}"><i class="fa fa-circle-o"></i> {{trans('layout.newsletter_add')}}</a></li>
                </ul>
            </li>
            @endif


            @if ($booking_role)
            <li class="{{$booking}}">
                <a href="{{URL::to('admin/booking')}}">
                    <i class="fa fa-phone-square"></i>
                    <span>{{trans('layout.booking')}}</span>
                </a>
            </li>
            @endif
            @if ($contact_role)
            <li class="{{$contact}}">
                <a href="{{URL::to('admin/contact')}}">
                    <i class="fa fa-phone-square"></i>
                    <span>{{trans('layout.contact')}}</span>
                </a>
            </li>
            @endif

            <li class="">
                <a href="{{URL::to('admin/logout')}}">
                    <i class="fa fa-sign-out"></i>
                    <span>{{trans('layout.logout')}}</span>
                </a>
            </li>  

        </ul>
    </section>
    <!-- /.sidebar -->
    <div class="sidebar-footer">
        <!-- item-->
        <a href="{{URL::to('admin/site')}}" class="link" data-toggle="tooltip" title="" data-original-title="{{trans('layout.site')}}"><i class="fa fa-cog fa-spin"></i></a>
        <!-- item-->
        <a href="{{URL::to('admin/contact')}}" class="link" data-toggle="tooltip" title="" data-original-title="{{trans('layout.contact')}}"><i class="fa fa-envelope"></i></a>
        <!-- item-->
        <a href="{{URL::to('admin/logout')}}" class="link" data-toggle="tooltip" title="" data-original-title="{{trans('layout.logout')}}"><i class="fa fa-power-off"></i></a>
    </div>
</aside>