@extends('admin.layouts.index')

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
        {{trans('layout.admin')}}
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL::to('trika')}}"><i class="fa fa-home"></i> {{trans('layout.home')}}</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="box box-info">
                <div class="box-body">
                    <br>
                    <div class="alert alert-danger">
                        {{trans('layout.not_allow')}}
                    </div>
                </div>
            </div>
        </div>

    </div>


</section>
<!-- /.content -->

@endsection

