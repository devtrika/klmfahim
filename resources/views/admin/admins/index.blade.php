@extends('admin.layouts.table')

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
        {{trans('layout.admins')}}
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('admin')}}"> {{trans('layout.home')}}</a></li>
        <li class="breadcrumb-item active {{$pull}}">{{trans('layout.admins')}}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12">
            @if (Session::has('message'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-success alert-dismissible">
                        {{ Session::get('message')}}
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </div>
                </div>
            </div>
            @endif

            <div class="box">
                <div class="box-header">
                    <a href="{{URL::to('admin/admins/create')}}" class="btn btn-lg bg-fuchsia">{{trans('layout.admin_add')}}</a>
                </div>
                <div class="box-body">
                    <table id="example" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                        <thead>
                            <tr>
                                <th class="{{$text}}">{{trans('layout.name')}}</th>
                                <th class="{{$text}}">{{trans('layout.username')}}</th>
                                <th class="{{$text}}">{{trans('layout.phone')}}</th>
                                <!--<th class="{{$text}}">{{trans('layout.groups')}}</th>-->
                                <th class="{{$text}}">{{trans('layout.user_active')}}</th>
                                <th class="{{$text}}">{{trans('layout.edit')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $user)
                            <tr>
                                <td>{{$user['name']}}</td>
                                <td>{{$user['username']}}</td>
                                <td>{{$user['phone']}}</td>
                                <!--<td>{{$user['Group'][$lang.'_name']}}</td>-->
                                <td>
                                    @if($user['active'] == "yes")
                                    {{trans('layout.yes_active')}}
                                    @else
                                    {{trans('layout.no_active')}}
                                    @endif
                                </td>
                              
                                <td>
                                    {{ Form::open(array('url' =>'admin/admins/'.$user->uuid.'/edit', 'method' => 'GET')) }}
                                    <button  type="submit" class="btn default btn-sm btn-success"><i class="fa fa-edit"></i> {{trans('layout.edit')}} </button>
                                    {{ Form::close() }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->          
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

@endsection