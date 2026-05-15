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
        {{trans('layout.contact')}}
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('admin')}}"> {{trans('layout.home')}}</a></li>
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('admin/contact')}}"> {{trans('layout.contact')}}</a></li>
        <li class="breadcrumb-item active {{$pull}}">{{trans('layout.contact_edit')}}</li>
    </ol>
</section>

<section class="content">

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">{{trans('layout.contact_edit')}} : {{$contact[$lang.'_name']}}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>

        <form action="{{URL::to('admin/contact/'.$contact['id'])}}" method="post" enctype="multipart/form-data">
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

                        <div class="form-group row">
                            <label for="input_4" class="col-sm-3 col-form-label">{{trans('interface.message_title')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('title', $contact['title'], ['class'=>'form-control','id'=>'input_4','readonly']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input_5" class="col-sm-3 col-form-label">{{trans('interface.message_text')}}</label>
                            <div class="col-sm-9">
                                {{ Form::textarea('message', $contact['message'], ['class'=>'form-control','id'=>'input_5','rows'=>10,'readonly']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input_6" class="col-sm-3 col-form-label">{{trans('layout.reply')}}</label>
                            <div class="col-sm-9">
                                {{ Form::textarea('reply', $contact['reply'], ['class'=>'form-control','id'=>'input_6','rows'=>10]) }}
                                @if($errors->has('reply'))
                                <div class="alert alert-danger">{{$errors->first('reply')}}</div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-lg" style="font-size: 16px;">{{trans('layout.save')}}</button>
                <a href="{{URL::to('admin/contact')}}" class="btn btn-default btn-lg" style="font-size: 16px;">{{trans('layout.back')}}</a>
            </div>

        </form>

    </div>

</section>

@endsection