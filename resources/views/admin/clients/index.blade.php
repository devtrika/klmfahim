@extends('admin.layouts.table')

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
        {{trans('layout.clients')}}
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('trika')}}"> {{trans('layout.home')}}</a></li>
        <li class="breadcrumb-item active {{$pull}}">{{trans('layout.clients')}}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
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

            <div class="box">
                <div class="box-header">
                    <a href="{{URL::to('trika/clients/create')}}" class="btn btn-lg bg-fuchsia">{{trans('layout.client_add')}}</a>
                </div>
                <div class="box-body">
                    <table id="example" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                        <thead>
                            <tr>
                                <th class="{{$text}}">{{trans('layout.client_name_ar')}}</th>
                                 <th class="{{$text}}">{{trans('layout.client_name_en')}}</th>
                                <th class="{{$text}}">{{trans('layout.edit')}}</th>
                                <th class="{{$text}}">{{trans('layout.delete')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                            <tr>
                                <td>{{$client['ar_title']}}</td>
                                <td>{{$client['en_title']}}</td>
                                <td>
                                    {{ Form::open(array('url' =>'trika/clients/'.$client->uuid.'/edit', 'method' => 'GET')) }}
                                    <button  type="submit" class="btn default btn-sm btn-info"><i class="fa fa-edit"></i> {{trans('layout.edit')}} </button>
                                    {{ Form::close() }}
                                </td>
                                <td>
                                    {{ Form::open(array('url' =>'trika/clients/'.$client->uuid, 'method' => 'DELETE')) }}
                                    <button  type="submit" class="btn default btn-sm btn-danger"><i class="fa fa-trash-o"></i> {{trans('layout.delete')}} </button>
                                    {{ Form::close() }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->          
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

@endsection