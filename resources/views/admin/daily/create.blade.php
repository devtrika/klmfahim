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
        {{trans('layout.daily')}}
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('trika')}}"> {{trans('layout.home')}}</a></li>
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('trika/daily')}}"> {{trans('layout.daily')}}</a></li>
        <li class="breadcrumb-item active {{$pull}}">{{trans('layout.daily_add')}}</li>
    </ol>
</section>

<section class="content">

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">{{trans('layout.daily_add')}}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>

        <form action="{{URL::to('trika/daily')}}" method="post" enctype="multipart/form-data">
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
                            <label for="input_0" class="col-sm-3 col-form-label">{{trans('layout.status')}}</label>
                            <div class="col-sm-9">
                                {{ Form::select('status', ['waiting'=>trans('layout.waiting') , 'done'=>trans('layout.done'), 'nows'=>trans('layout.nows')],null, ['class'=>'form-control','id'=>'input_0']) }}
                                @if($errors->has('status'))
                                <div class="alert alert-danger">{{$errors->first('status')}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input_0" class="col-sm-3 col-form-label">{{trans('layout.room')}}</label>
                            <div class="col-sm-9">
                                {{ Form::select('room', [''=>'0' ,'1'=>'1' , '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5'],null,['class'=>'form-control','id'=>'input_0']) }}
                                @if($errors->has('room'))
                                <div class="alert alert-danger">{{$errors->first('room')}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input_1" class="col-sm-3 col-form-label">{{trans('layout.daily_ar_name')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('ar_name', null, ['class'=>'form-control','onblur'=>'changefun()','id'=>'ar_name']) }}
                                @if($errors->has('ar_name'))
                                <div class="alert alert-danger">{{$errors->first('ar_name')}}</div>
                                @endif
                            </div>
                        </div>
                        <script>
                            function changefun() {
                                if (!document.getElementById('en_name').value)
                                    document.getElementById('en_name').value = document.getElementById('ar_name').value;
                            }
                        </script>
                        <div class="form-group row">
                            <label for="input_1" class="col-sm-3 col-form-label">{{trans('layout.daily_en_name')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('en_name', null, ['class'=>'form-control','id'=>'en_name']) }}
                                @if($errors->has('en_name'))
                                <div class="alert alert-danger">{{$errors->first('en_name')}}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-lg" style="font-size: 16px;">{{trans('layout.add')}}</button>
                <a href="{{URL::to('trika/daily')}}" class="btn btn-default btn-lg" style="font-size: 16px;">{{trans('layout.back')}}</a>
            </div>

        </form>

    </div>

</section>

@endsection