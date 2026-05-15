@extends('admin.layouts.login')

@section('content')

<!-- /.login-logo -->
<div class="login-box-body">
    <p class="login-box-msg">{{trans('layout.reset_password')}}</p>

    <form action="{{ route('password.request') }}" method="post" >
        {{ csrf_field() }}


        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

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

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group has-feedback">
            <label>{{trans('layout.email')}}</label>
            {{ Form::text('email',null,['class'=>'form-control','required']) }}
            @if($errors->has('email'))
            <div class="alert alert-danger">{{$errors->first('email')}}</div>
            @endif
        </div>

        <div class="form-group has-feedback">
            {{trans('layout.password')}}
            {{ Form::input('password','password',null,['class'=>'form-control','required']) }}
            @if($errors->has('password'))
            <div class="alert alert-danger">{{$errors->first('password')}}</div>
            @endif
        </div>


        <div class="form-group has-feedback">
            {{trans('layout.password_confirmation')}}
            {{ Form::input('password','password_confirmation',null,['class'=>'form-control','required']) }}
            @if($errors->has('password_confirmation'))
            <div class="alert alert-danger">{{$errors->first('password_confirmation')}}</div>
            @endif
        </div>

        <div class="row">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-info btn-block btn-flat margin-top-10">{{trans('layout.reset_password')}}</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
</div>

<!-- /.login-box-body -->

@endsection

