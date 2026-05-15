@extends('admin.layouts.form')

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
        {{trans('layout.users')}}
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('admin')}}"> {{trans('layout.home')}}</a></li>
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('admin/users')}}"> {{trans('layout.users')}}</a></li>
        <li class="breadcrumb-item active {{$pull}}">{{trans('layout.user_edit')}}</li>
    </ol>
</section>

<section class="content">

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">{{trans('layout.user_edit')}} : {{$user['name']}}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>

        <form action="{{URL::to('admin/users/'.$user['id'])}}" method="post" enctype="multipart/form-data">
            {{ Form::hidden('_method','PATCH') }}
            {{ csrf_field() }}

            <div class="box-body">
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

                        <div class="form-group row">
                            <label for="input_0" class="col-sm-3 col-form-label">{{trans('layout.user_active')}}</label>
                            <div class="col-sm-9">
                                {{ Form::select('active', ['yes'=>trans('layout.yes_active') , 'no'=>trans('layout.no_active')],$user['active'], ['class'=>'form-control','id'=>'input_0']) }}
                                @if($errors->has('active'))
                                <div class="alert alert-danger">{{$errors->first('active')}}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input_1" class="col-sm-3 col-form-label">{{trans('layout.name')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('name', $user['name'], ['class'=>'form-control','id'=>'input_1']) }}
                                @if($errors->has('name'))
                                <div class="alert alert-danger">{{$errors->first('name')}}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input_2" class="col-sm-3 col-form-label">{{trans('layout.username')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('username', $user['username'], ['class'=>'form-control','id'=>'input_2']) }}
                                @if($errors->has('username'))
                                <div class="alert alert-danger">{{$errors->first('username')}}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input_3" class="col-sm-3 col-form-label">{{trans('layout.password')}}</label>
                            <div class="col-sm-9">
                                {{ Form::input('password','password', null, ['class'=>'form-control','id'=>'input_3']) }}
                                @if($errors->has('password'))
                                <div class="alert alert-danger">{{$errors->first('password')}}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input_4" class="col-sm-3 col-form-label">{{trans('layout.email')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('email', $user['email'], ['class'=>'form-control','id'=>'input_4']) }}
                                @if($errors->has('email'))
                                <div class="alert alert-danger">{{$errors->first('email')}}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input_5" class="col-sm-3 col-form-label">{{trans('layout.phone')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('phone', $user['phone'], ['class'=>'form-control','id'=>'input_5']) }}
                                @if($errors->has('phone'))
                                <div class="alert alert-danger">{{$errors->first('phone')}}</div>
                                @endif
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-lg" style="font-size: 16px;">{{trans('layout.save')}}</button>
                <a href="{{URL::to('admin/users')}}" class="btn btn-default btn-lg" style="font-size: 16px;">{{trans('layout.back')}}</a>
            </div>

        </form>

    </div>

</section>

@endsection