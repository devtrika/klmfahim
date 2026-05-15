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
         {{trans('layout.videos')}}
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('admin')}}"> {{trans('layout.home')}}</a></li>
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('admin/videos')}}"> {{trans('layout.videos')}}</a></li>
        <li class="breadcrumb-item active {{$pull}}">{{trans('layout.video_add')}}</li>
    </ol>
</section>

<section class="content">

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">{{trans('layout.edit')}}: {{$slider[$lang.'_title']}}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>

        <form action="{{URL::to('admin/videos/'.$slider['id'])}}" method="post">
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
                            <label class="col-sm-3 col-form-label">{{trans('layout.status')}}</label>
                            <label class="col-sm-9 ">
                                {{ Form::select('inslide', ['yes'=>trans('layout.yes_active') , 'no'=>trans('layout.no_active')],$slider['inslide'], ['class'=>'form-control','id'=>'input_0']) }}

                            </label>
                        </div>

                        <div class="form-group row">
                            <label for="input_1" class="col-sm-3 col-form-label">{{trans('layout.videourl')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('link', 'https://www.youtube.com/watch?v='.$slider['link'], ['class'=>'form-control','id'=>'input_1']) }}
                                @if($errors->has('link'))
                                <div class="alert alert-danger">{{$errors->first('link')}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <iframe src="https://www.youtube.com/embed/{{$slider['link']}}"></iframe>
                        </div>

                        <div class="form-group row">
                            <label for="input_1" class="col-sm-3 col-form-label">{{trans('layout.ar_title')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('ar_title', $slider['ar_title'], ['class'=>'form-control','id'=>'input_1']) }}
                                @if($errors->has('ar_title'))
                                <div class="alert alert-danger">{{$errors->first('ar_title')}}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input_2" class="col-sm-3 col-form-label">{{trans('layout.en_title')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('en_title', $slider['en_title'], ['class'=>'form-control','id'=>'input_2']) }}
                                @if($errors->has('en_title'))
                                <div class="alert alert-danger">{{$errors->first('en_title')}}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="editor1" class="col-sm-3 col-form-label">{{trans('layout.ar_desc')}}</label>
                            <div class="col-sm-9">
                                {{ Form::textarea('ar_desc', $slider['ar_desc'], ['class'=>'form-control','id'=>'editor1','rows'=>10]) }}
                                @if($errors->has('ar_desc'))
                                <div class="alert alert-danger">{{$errors->first('ar_desc')}}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="editor2" class="col-sm-3 col-form-label">{{trans('layout.en_desc')}}</label>
                            <div class="col-sm-9">
                                {{ Form::textarea('en_desc', $slider['en_desc'], ['class'=>'form-control','id'=>'editor2','rows'=>10]) }}
                                @if($errors->has('en_desc'))
                                <div class="alert alert-danger">{{$errors->first('en_desc')}}</div>
                                @endif
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-lg" style="font-size: 16px;">{{trans('layout.save')}}</button>
                <a href="{{URL::to('admin/videos')}}" class="btnbtn-defaultbtn-lg" style="font-size: 16px;">{{trans('layout.back')}}</a>
            </div>

        </form>

    </div>

</section>

@endsection