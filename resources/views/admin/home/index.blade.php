@extends('admin.layouts.index')

@section('content')
<?php
$lang = LaravelLocalization::getCurrentLocale() ;
$text = "text-left";
$pull = "pull-left";
if ($lang == "ar") {
    $text = "text-right";
    $pull = "pull-right";
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('layout.admin')}}
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL::to('trika')}}"><i class="fa fa-home"></i> {{trans('layout.home')}}</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="cf-tiles">
        <a class="cf-tile" href="{{ URL::to('trika/requests') }}">
            <i class="fa fa-calculator"></i>
            <span><b>{{ \App\Models\CostRequest::where('seen', false)->count() }}</b><small>{{ trans('layout.requests_new') }}</small></span>
        </a>
        <a class="cf-tile" href="{{ URL::to('trika/contact') }}">
            <i class="fa fa-envelope"></i>
            <span><b>{{ \App\Models\Contact::where('seen', 'no')->count() }}</b><small>{{ trans('layout.contact') }}</small></span>
        </a>
        <a class="cf-tile" href="{{ URL::to('trika/services') }}">
            <i class="fa fa-briefcase"></i>
            <span><b>{{ \App\Models\Service::count() }}</b><small>{{ trans('layout.services') }}</small></span>
        </a>
        <a class="cf-tile" href="{{ URL::to('trika/clients') }}">
            <i class="fa fa-handshake-o"></i>
            <span><b>{{ \App\Models\Client::count() }}</b><small>{{ trans('layout.clients') }}</small></span>
        </a>
    </div>

    <div class="row">

       
        <div class="col-xl-12">
            <?php $per = \App\Models\Permission::where('group_id', Auth::user()->id)->where('permission', 'contact')->first() ?>
            @if($per)
            <div class="box">
                <div class="text-center">{{trans('layout.contact')}}</div>
                <div class="box-body">
                    <table id="example" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                        <thead>
                            <tr> 
                                <th class="{{$text}}">#</th>
                                <th class="{{$text}}">{{trans('layout.name')}}</th>
                                <th class="{{$text}}">{{trans('layout.phone')}}</th>
                                <th class="{{$text}}">{{trans('layout.message_title')}}</th>
                                <th class="{{$text}}">{{trans('layout.contact_active')}}</th>
                                <th class="{{$text}}">{{trans('layout.reply')}}</th>
                                <th class="{{$text}}">{{trans('layout.delete')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $contacts = App\Models\Contact::where('seen', 'no')->get();
                            ?>
                            @foreach($contacts as $contact)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$contact['name']}}</td>
                                <td>{{$contact['phone']}}</td>
                                <td>{{$contact['title']}}</td>
                                <td>
                                    @if($contact['seen'] == "yes" && $contact['reply'] != "")
                                    {{trans('layout.seen_reply')}}
                                    @elseif($contact['seen'] == "yes" && $contact['reply'] == "")
                                    {{trans('layout.seen_reply_not')}}
                                    @elseif($contact['seen'] == "no" )
                                    {{trans('layout.seen_not')}}
                                    @endif
                                </td>
                                <td>
                                    {{ Form::open(array('url' =>'trika/contact/'.$contact->uuid.'/edit', 'method' => 'GET')) }}
                                    <button  type="submit" class="btn default btn-sm btn-info"><i class="fa fa-edit"></i> {{trans('layout.reply')}} </button>
                                    {{ Form::close() }}
                                </td>
                                <td>
                                    {{ Form::open(array('url' =>'trika/contact/'.$contact->uuid, 'method' => 'DELETE')) }}
                                    <button  type="submit" class="btn default btn-sm btn-danger"><i class="fa fa-trash-o"></i> {{trans('layout.delete')}} </button>
                                    {{ Form::close() }}
                                </td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>


                </div>
                <!-- /.box-body -->
            </div>
            @endif
         

            <div class="row">

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-box">
                        <a href="{{URL::to('trika/site/')}}">
                            <span class="info-box-icon bg-yellow"><i class="fa fa-th"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-number"><br></span>
                                <span class="info-box-text">{{trans('layout.site')}}</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!--                <?php $groups = \App\Models\Group::count(); ?>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <div class="info-box">
                                        <a href="{{URL::to('trika/groups/')}}">
                                            <span class="info-box-icon bg-black"><i class="fa fa-android"></i></span>
                
                                            <div class="info-box-content">
                                                <span class="info-box-number">{{$groups}}</span>
                                                <span class="info-box-text">{{trans('layout.groups')}}</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>-->

                <?php $admins = \App\Models\User::where('type', 'admin')->count(); ?>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-box">
                        <a href="{{URL::to('trika/admins/')}}">
                            <span class="info-box-icon bg-fuchsia"><i class="fa fa-user-secret"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-number">{{$admins}}</span>
                                <span class="info-box-text">{{trans('layout.admins')}}</span>
                            </div>
                        </a>
                    </div>
                </div>



                <?php $clients = \App\Models\Client::count(); ?>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-box">
                        <a href="{{URL::to('trika/clients')}}">
                            <span class="info-box-icon bg-light-blue"><i class="fa fa-user-circle-o"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-number">{{$clients}}</span>
                                <span class="info-box-text">{{trans('layout.clients')}}</span>
                            </div>
                        </a>
                    </div>
                </div>

                <?php $projects = \App\Models\Project::count(); ?>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-box">
                        <a href="{{URL::to('trika/projects')}}">
                            <span class="info-box-icon bg-yellow-active"><i class="fa fa-product-hunt"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-number">{{$projects}}</span>
                                <span class="info-box-text">{{trans('layout.projects')}}</span>
                            </div>
                        </a>
                    </div>
                </div>

                <?php $services = \App\Models\Service::count(); ?>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-box">
                        <a href="{{URL::to('trika/services')}}">
                            <span class="info-box-icon bg-blue-gradient"><i class="fa fa-share"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-number">{{$services}}</span>
                                <span class="info-box-text">{{trans('layout.services')}}</span>
                            </div>
                        </a>
                    </div>
                </div>

                <?php $services = \App\Models\Blog::count(); ?>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-box">
                        <a href="{{URL::to('trika/news')}}">
                            <span class="info-box-icon bg-fuchsia-active"><i class="fa fa-pencil-square"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-number">{{$services}}</span>
                                <span class="info-box-text">{{trans('layout.blog')}}</span>
                            </div>
                        </a>
                    </div>
                </div>
                <?php $services = \App\Models\Opinon::count(); ?>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-box">
                        <a href="{{URL::to('trika/opinions')}}">
                            <span class="info-box-icon bg-lime-active"><i class="fa fa-user-o"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-number">{{$services}}</span>
                                <span class="info-box-text">{{trans('layout.opinions')}}</span>
                            </div>
                        </a>
                    </div>
                </div>

                <?php $services = \App\Models\Page::count(); ?>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-box">
                        <a href="{{URL::to('trika/pages')}}">
                            <span class="info-box-icon bg-light-blue"><i class="fa fa-book"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-number">{{$services}}</span>
                                <span class="info-box-text">{{trans('layout.pages')}}</span>
                            </div>
                        </a>
                    </div>
                </div>

                <?php $slider = \App\Models\Slider::count(); ?>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-box">
                        <a href="{{URL::to('trika/slider/')}}">
                            <span class="info-box-icon bg-lime"><i class="fa fa-photo"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-number">{{$slider}}</span>
                                <span class="info-box-text">{{trans('layout.slider')}}</span>
                            </div>
                        </a>
                    </div>
                </div>

             



                <?php $contact = \App\Models\Contact::count(); ?>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-box">
                        <a href="{{URL::to('trika/contact/')}}">
                            <span class="info-box-icon bg-purple"><i class="fa fa-phone-square"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-number">{{$contact}}</span>
                                <span class="info-box-text">{{trans('layout.contact')}}</span>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="info-box">
                        <a href="{{URL::to('trika/logout/')}}">
                            <span class="info-box-icon bg-red"><i class="fa fa-sign-out"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-number"><br></span>
                                <span class="info-box-text">{{trans('layout.logout')}}</span>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>

</section>
<!-- /.content -->

@endsection


@section('scripts')
@endsection