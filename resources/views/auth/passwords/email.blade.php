
@extends('admin.layouts.login')

@section('content')

<!-- /.login-logo -->
<div class="login-box-body">
    <p class="login-box-msg">{{trans('layout.reset_password')}}</p>

    <form action="{{ route('password.email') }}" method="post" >
        {{ csrf_field() }}


        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <div class="form-group has-feedback">
            <label>{{trans('layout.email')}}</label>
            {{ Form::text('email',null,['class'=>'form-control','required']) }}
        </div>
        <div class="row">
            @if(Request::get('from') == "web")
            <div class="col-6">
                <div class="fog-pwd">
                    <a href="{{URL::to('trika/login')}}"><i class="fa fa-user"></i> {{trans('layout.login')}}</a><br>
                </div>
            </div>
            @endif
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-info btn-block btn-flat margin-top-10">{{trans('layout.reset_password')}}</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
</div>

<!-- /.login-box-body -->

@endsection



