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
        {{trans('layout.groups')}}
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('admin')}}"> {{trans('layout.home')}}</a></li>
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('admin/groups')}}"> {{trans('layout.groups')}}</a></li>
        <li class="breadcrumb-item active {{$pull}}">{{trans('layout.group_add')}}</li>
    </ol>
</section>

<section class="content">

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">{{trans('layout.group_add')}}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>

        <form action="{{URL::to('admin/groups')}}" method="post" >
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
                            <label for="input_1" class="col-sm-3 col-form-label">{{trans('layout.group_name_ar')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('ar_name', null, ['class'=>'form-control','id'=>'input_1']) }}
                                @if($errors->has('ar_name'))
                                <div class="alert alert-danger">{{$errors->first('ar_name')}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input_1" class="col-sm-3 col-form-label">{{trans('layout.group_name_en')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('en_name', null, ['class'=>'form-control','id'=>'input_1']) }}
                                @if($errors->has('en_name'))
                                <div class="alert alert-danger">{{$errors->first('en_name')}}</div>
                                @endif
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="input_5" class="col-sm-3 col-form-label">{{trans('layout.permissions')}}</label>
                            <div class="col-sm-9">
                                <div class="col-sm-4 {{$pull}}">
                                    {{ Form::checkbox('permissions[]','groups',false,['id'=>'Checkbox_1']) }}
                                    <label for="Checkbox_1">{{trans('layout.groups')}}</label>
                                </div>
                                <div class="col-sm-4 {{$pull}}">
                                    {{ Form::checkbox('permissions[]','site',false,['id'=>'Checkbox_2']) }}
                                    <label for="Checkbox_2">{{trans('layout.site')}}</label>
                                </div>
                                <div class="col-sm-4 {{$pull}}">
                                    {{ Form::checkbox('permissions[]','news',false,['id'=>'Checkbox_3']) }}
                                    <label for="Checkbox_3">{{trans('layout.blog')}}</label>
                                </div>
                                <div class="col-sm-4 {{$pull}}">
                                    {{ Form::checkbox('permissions[]','newsletter',false,['id'=>'Checkbox_6']) }}
                                    <label for="Checkbox_6">{{trans('layout.newsletter')}}</label>
                                </div>

                                <div class="col-sm-4 {{$pull}}">
                                    {{ Form::checkbox('permissions[]','pages',false,['id'=>'Checkbox_11']) }}
                                    <label for="Checkbox_11">{{trans('layout.pages')}}</label>
                                </div>


<!--                                <div class="col-sm-4 {{$pull}}">
                                    {{ Form::checkbox('permissions[]','depts',false,['id'=>'Checkbox_9']) }}
                                    <label for="Checkbox_9">{{trans('layout.depts')}}</label>
                                </div>-->

                                <div class="col-sm-4 {{$pull}}">
                                    {{ Form::checkbox('permissions[]','admins',false,['id'=>'Checkbox_12']) }}
                                    <label for="Checkbox_12">{{trans('layout.admins')}}</label>
                                </div>
                                <div class="col-sm-4 {{$pull}}">
                                    {{ Form::checkbox('permissions[]','projects',false,['id'=>'Checkbox_13']) }}
                                    <label for="Checkbox_13">{{trans('layout.projects')}}</label>
                                </div>
                                <div class="col-sm-4 {{$pull}}">
                                    {{ Form::checkbox('permissions[]','services',false,['id'=>'Checkbox_14']) }}
                                    <label for="Checkbox_14">{{trans('layout.services')}}</label>
                                </div>
                                <div class="col-sm-4 {{$pull}}">
                                    {{ Form::checkbox('permissions[]','clients',false,['id'=>'Checkbox_16']) }}
                                    <label for="Checkbox_16">{{trans('layout.clients')}}</label>
                                </div>
                                <div class="col-sm-4 {{$pull}}">
                                    {{ Form::checkbox('permissions[]','slider',false,['id'=>'Checkbox_18']) }}
                                    <label for="Checkbox_18">{{trans('layout.slider')}}</label>
                                </div>
                                <div class="col-sm-4 {{$pull}}">
                                    {{ Form::checkbox('permissions[]','contact',false,['id'=>'Checkbox_19']) }}
                                    <label for="Checkbox_19">{{trans('layout.contact')}}</label>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-lg" style="font-size: 16px;">{{trans('layout.add')}}</button>
                <a href="{{URL::to('admin/groups')}}" class="btn btn-default btn-lg" style="font-size: 16px;">{{trans('layout.back')}}</a>
            </div>

        </form>

    </div>

</section>

@endsection