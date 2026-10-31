@extends('admin.layouts.login')

@section('content')

<!-- /.login-logo -->
<div class="login-box-body">
    <p class="login-box-msg">{{trans('layout.sign_in')}}</p>

    <form action="{{URL::to('trika/login')}}" method="post" >
        {{ csrf_field() }}


        @if (Session::has('error'))
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-danger alert-dismissible">
                    {{ Session::get('error')}}
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>
            </div>
        </div>
        @endif

        <div class="form-group has-feedback">
            <label>{{trans('layout.username')}}</label>
            {{ Form::text('username',null,['class'=>'form-control','required']) }}
        </div>
        <div class="form-group has-feedback">
            {{trans('layout.password')}}
            {{ Form::input('password','password',null,['class'=>'form-control','required']) }}
        </div>
        <div class="row">
            <div class="col-6">
                <div class="checkbox">
                    <input type="checkbox" name="remember" id="basic_checkbox_1" >
                    <label for="basic_checkbox_1">{{trans('layout.remember')}}</label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-6">
                <div class="fog-pwd">
                    <a href="{{URL::to('password/reset?from=web')}}"><i class="ion ion-locked"></i> {{trans('layout.forget_password')}}</a><br>
                </div>
            </div>
            <!--        /.col -->
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-info btn-block btn-flat margin-top-10">{{trans('layout.login')}}</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
</div>

<!-- /.login-box-body -->

@endsection