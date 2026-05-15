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
        {{trans('layout.booking')}}
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('admin')}}"> {{trans('layout.home')}}</a></li>
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('admin/booking')}}"> {{trans('layout.booking')}}</a></li>
    </ol>
</section>

<section class="content">

    <div class="box box-default">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>

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
                            <label for="input_1" class="col-sm-3 col-form-label">{{trans('layout.name')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('name', $contact['name'], ['class'=>'form-control','id'=>'input_1','readonly']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input_2" class="col-sm-3 col-form-label">{{trans('layout.email')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('email', $contact['email'], ['class'=>'form-control','id'=>'input_2','readonly']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input_3" class="col-sm-3 col-form-label">{{trans('layout.phone')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('phone', $contact['phone'], ['class'=>'form-control','id'=>'input_3','readonly']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <a href="{{URL::to('admin/booking')}}" class="btn btn-default btn-lg" style="font-size: 16px;">{{trans('layout.back')}}</a>
            </div>


    </div>

</section>

@endsection