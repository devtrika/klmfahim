<?php
$lang = LaravelLocalization::getCurrentLocale() ;
$text = "text-left";
$pull = "pull-left";
    $dir ='ltr';

if ($lang == "ar") {
    $text = "text-right";
    $pull = "pull-right";
    $dir ='rtl';
}
?>
<header class="main-header" dir="{{$dir}}">
    <!-- Logo -->
    <a href="{{URL::to('admin')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="{{ asset('brand/mark.png') }}" alt="" style="width:34px;height:34px"></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="{{ asset('brand/mark.png') }}" alt="" style="width:34px;height:34px"> <b>Call Fahim</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{URL::to('admin_panel')}}/images/user2-160x160.jpg" class="user-image rounded" alt="User Image">
                    </a>
                    <ul class="dropdown-menu scale-up">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{URL::to('admin_panel')}}/images/user2-160x160.jpg" class="rounded float-right" alt="User Image">

                            <p>
                                {{Auth::User()->username}}
                                <small>{{Auth::User()->Group[$lang.'_name']}}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="{{URL::to('/')}}" class="btn btn-block btn-primary">{{trans('layout.website')}}</a>
                            </div>
                            <div class="pull-left">
                                <a href="{{URL::to('admin/logout')}}" class="btn btn-block btn-danger">{{trans('layout.logout')}}</a>
                            </div>
                        </li>
                    </ul>
                </li>


                @if(\App\Models\Permission::where('group_id', Auth::User()->group_id)->where('permission', 'users')->count() > 0)
                <?php $users = \App\Models\User::where('seen', 'no')->orderBy('id', 'desc')->get(); ?>

                @if(Auth::User()->Group['country'] == "all")
                <li class="dropdown messages-menu">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i>
                        <span class="label label-danger">{{COUNT($users)}}</span>
                    </a>
                    <ul class="dropdown-menu scale-up">
                        <li class="header {{$text}}">{{trans('layout.users_count')}} : {{COUNT($users)}}</li>
                        <li>
                            <ul class="menu inner-content-div">
                                @foreach($users as $user)
                                <li><!-- start message -->
                                    <a href="{{URL::to('admin/users/'.$user->uuid.'/edit')}}">
                                        <div class="{{$pull}}">
                                            <img src="{{URL::to('admin_panel')}}/images/user2-160x160.jpg" class="rounded-circle" alt="{{$user['name']}}">
                                        </div>
                                        <div class="mail-contnet {{$text}}">
                                            <h4 class="{{$text}}">
                                                {{$user['name']}}
                                                <small><i class="fa fa-clock-o"></i> &nbsp;{{date('Y-m-d',strtotime($user['created_at']))}}</small>
                                            </h4>
                                            <span>{{$user['email']}}</span>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="footer"><a href="{{URL::to('admin/users')}}">{{trans('layout.show_all')}}</a></li>
                    </ul>
                </li>
                @else

                <li class="dropdown messages-menu">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i>
                        <span class="label label-danger">{{COUNT($users)}}</span>
                    </a>
                    <ul class="dropdown-menu scale-up">
                        <li class="header {{$text}}">{{trans('layout.users_count')}} : {{COUNT($users)}}</li>
                        <li>
                            <ul class="menu inner-content-div">
                                @foreach($users as $user)
                                <li><!-- start message -->
                                    <a href="{{URL::to('admin/users/'.$user->uuid.'/edit')}}">
                                        <div class="{{$pull}}">
                                            <img src="{{URL::to('admin_panel')}}/images/user2-160x160.jpg" class="rounded-circle" alt="{{$user['name']}}">
                                        </div>
                                        <div class="mail-contnet {{$text}}">
                                            <h4 class="{{$text}}">
                                                {{$user['name']}}
                                                <small><i class="fa fa-clock-o"></i> &nbsp;{{date('Y-m-d',strtotime($user['created_at']))}}</small>
                                            </h4>
                                            <span>{{$user['email']}}</span>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="footer"><a href="{{URL::to('admin/users')}}">{{trans('layout.show_all')}}</a></li>
                    </ul>
                </li>

                @endif

                @endif

                @if(\App\Models\Permission::where('group_id', Auth::User()->group_id)->where('permission', 'contact')->count() > 0)
                <?php $contacts = \App\Models\Contact::where('seen', 'no')->orderBy('id', 'desc')->get(); ?>
                <li class="dropdown messages-menu">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope"></i>
                        <span class="label label-success">{{COUNT($contacts)}}</span>
                    </a>
                    <ul class="dropdown-menu scale-up">
                        <li class="header {{$text}}">{{trans('layout.contact_count')}} : {{COUNT($contacts)}}</li>
                        <li>
                            <ul class="menu inner-content-div">
                                @foreach($contacts as $contact)
                                <li><!-- start message -->
                                    <a href="{{URL::to('admin/contact/'.$contact->uuid.'/edit')}}">
                                        <div class="{{$pull}}">
                                            <img src="{{URL::to('admin_panel')}}/images/user2-160x160.jpg" class="rounded-circle" alt="{{$contact['name']}}">
                                        </div>
                                        <div class="mail-contnet {{$text}}">
                                            <h4 class="{{$text}}">
                                                {{$contact['name']}}
                                                <small><i class="fa fa-clock-o"></i> &nbsp;{{date('Y-m-d',strtotime($contact['created_at']))}}</small>
                                            </h4>
                                            <span>{{$contact['title']}}</span>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="footer"><a href="{{URL::to('admin/contact')}}">{{trans('layout.show_all')}}</a></li>
                    </ul>
                </li>
                @endif

                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-cog fa-spin"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>