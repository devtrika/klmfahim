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
        <li class="breadcrumb-item active {{$pull}}">{{trans('layout.user_add')}}</li>
    </ol>
</section>

<section class="content">

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">{{trans('layout.user_add')}}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>

        <form method="post" enctype="multipart/form-data" action="{{URL::to('admin/users')}}{{ isset($user) ? '/'.$user->uuid : '' }}" novalidate="novalidate">
            {!! isset($user) ? '<input type="hidden" name="_method" value="PUT">' : '' !!}
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
                            <label for="input_1" class="col-sm-3 col-form-label">{{trans('layout.user_type')}}</label>
                            <div class="col-sm-9">
                                <select name="group" class="form-control" required="required" aria-required="true" >
                                    <option value=""> نوع العضوية </option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}" {{isset($user) ? $user->Group->ar_name==$group->ar_name ? 'selected':'' : old('group') }}>{{ $group->ar_name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('group'))
                                <div class="alert alert-danger">{{$errors->first('group')}}</div>
                                @endif
                            </div>
                        </div>
                            <div class="form-group row">
                                <label for="input_1" class="col-sm-3 col-form-label">{{trans('layout.user_status')}}</label>
                                <div class="col-sm-9">
                                    <select name="active" class="form-control"  >
                                            <option value="1" {{isset($user) ? $user->active=='1' ? 'selected':'' : 'selected' }}>مفعل</option>
                                        <option value="0" {{isset($user) ?  $user->active=='0' ? 'selected':'' : '' }}>غير مفعل</option>

                                    </select>
                                </div>
                            </div>
                        <div class="form-group row">
                            <label for="input_2" class="col-sm-3 col-form-label">{{trans('layout.user_name')}}</label>
                            <div class="col-sm-9">
                         <input type="text" class="form-control" value="{{isset($user)?$user->name:old('name')}}" name="name">
                                @if($errors->has('name'))
                                <div class="alert alert-danger">{{$errors->first('name')}}</div>
                                @endif
                            </div>
                        </div>
                            <div class="form-group row">
                                <label for="input_2" class="col-sm-3 col-form-label">{{trans('layout.user_username')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{isset($user)?$user->username:old('username')}}" name="username">
                                    @if($errors->has('username'))
                                        <div class="alert alert-danger">{{$errors->first('username')}}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input_2" class="col-sm-3 col-form-label">{{trans('layout.user_email')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{isset($user)?$user->email:old('email')}}" name="email">
                                    @if($errors->has('email'))
                                        <div class="alert alert-danger">{{$errors->first('email')}}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input_2" class="col-sm-3 col-form-label">{{trans('layout.user_password')}}</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" value="" name="password">
                                    @if($errors->has('password'))
                                        <div class="alert alert-danger">{{$errors->first('password')}}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input_2" class="col-sm-3 col-form-label">{{trans('layout.password_confirmation')}}</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" value="" name="password_confirmation">
                                    @if($errors->has('password_confirmation'))
                                        <div class="alert alert-danger">{{$errors->first('password_confirmation')}}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input_2" class="col-sm-3 col-form-label">{{trans('layout.user_phone')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{isset($user)?$user->phone:old('phone')}}" name="phone">
                                    @if($errors->has('phone'))
                                        <div class="alert alert-danger">{{$errors->first('phone')}}</div>
                                    @endif
                                </div>
                            </div>
                        
                          
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-lg" style="font-size: 16px;">{{trans('layout.add')}}</button>
                <a href="{{URL::to('admin/pages')}}" class="btn btn-default btn-lg" style="font-size: 16px;">{{trans('layout.back')}}</a>
            </div>

        </form>

    </div>

</section>

@endsection