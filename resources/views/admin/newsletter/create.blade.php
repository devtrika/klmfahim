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
        {{trans('layout.newsletter')}}
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('trika')}}"> {{trans('layout.home')}}</a></li>
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('trika/newsletter')}}"> {{trans('layout.newsletter')}}</a></li>
        <li class="breadcrumb-item active {{$pull}}">{{trans('layout.newsletter_add')}}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">{{trans('layout.newsletter_add')}}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>

        <form action="{{URL::to('trika/newsletter')}}" method="post" enctype="multipart/form-data">
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
                            <label for="input_1" class="col-sm-3 col-form-label">{{trans('layout.newsletter_title')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('title', null, ['class'=>'form-control','id'=>'input_1']) }}
                                @if($errors->has('title'))
                                <div class="alert alert-danger">{{$errors->first('title')}}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input_1" class="col-sm-3 col-form-label">{{trans('layout.newsletter_message')}}</label>
                            <div class="col-sm-9">
                                {{ Form::textarea('message', null, ['class'=>'form-control','id'=>'input_1','rows'=>10]) }}
                                @if($errors->has('message'))
                                <div class="alert alert-danger">{{$errors->first('message')}}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div class="box-body">
                                    <table class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                                        <thead>
                                            <tr>
                                                <th class="{{$text}}" style="padding: 15px 25px;">{{trans('layout.email')}}</th>
                                                <th class="{{$text}}" style="padding: 10px 25px;">
                                                    {{ Form::checkbox('select_all','1',false,['id'=>'select_all','rel'=>'true']) }}
                                                    <label for="select_all">{{trans('layout.select_all')}}</label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($newsletter as $mail)
                                            <tr>
                                                <td colspan="2" style="padding: 10px 25px;">
                                                    {{ Form::checkbox('emails[]',$mail->email,false,['id'=>$mail->id]) }}<label for="{{$mail->id}}">{{$mail->email}}</label>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                        @if($errors->has('emails'))
                        <div class="alert alert-danger">{{$errors->first('emails')}}</div>
                        @endif
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-lg" style="font-size: 16px;">{{trans('layout.send')}}</button>
            </div>

        </form>

    </div>

</section>

@endsection


@section('scripts')

<script>
    $("#select_all").click(function () {
        var status = $(this).attr('rel');
        if (status == "true") {
            $(':checkbox').each(function () {
                if ($(this).prop('checked') == false) {
                    $(this).trigger("click");
                }
            });
            $(this).attr('rel', 'false');
        } else {
            $(':checkbox').each(function () {
                if ($(this).prop('checked') == true) {
                    $(this).trigger("click");
                }
            });
            $(this).attr('rel', 'true');
        }
    });
</script>

@endsection