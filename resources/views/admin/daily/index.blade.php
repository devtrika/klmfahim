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
        {{trans('layout.daily')}}
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('admin')}}"> {{trans('layout.home')}}</a></li>
        <li class="breadcrumb-item active {{$pull}}">{{trans('layout.daily')}}</li>
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
                    <a href="{{URL::to('admin/daily/create')}}" class="btn btn-lg bg-fuchsia">{{trans('layout.daily_add')}}</a>
                </div>
                <div class="box-body">
                    <table id="example" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                        <thead>
                            <tr>
                                <th class="{{$text}}">#</th>
                                <th class="{{$text}}">{{trans('layout.daily_ar_name')}}</th> 
                                <th class="{{$text}}">{{trans('layout.daily_en_name')}}</th>
                                 <th class="{{$text}}">{{trans('layout.room')}}</th>
                                <th class="{{$text}}">{{trans('layout.status')}}</th>
                                <th class="{{$text}}">{{trans('layout.edit')}}</th>
                                <th class="{{$text}}">{{trans('layout.delete')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($contacts as $page)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$page['ar_name']}}</td> 
                                <td>{{$page['en_name']}}</td>
                                <td>{{$page['room']}}</td>
                                <td>{{trans('layout.'.$page['status'])}}</td>
                                
                                <td>
                                    {{ Form::open(array('url' =>'admin/daily/'.$page->id.'/edit', 'method' => 'GET')) }}
                                    <button  type="submit" class="btn default btn-sm btn-info"><i class="fa fa-edit"></i> {{trans('layout.edit')}} </button>
                                    {{ Form::close() }}
                                </td>
                                <td>

                                    {{ Form::open(array('url' =>'admin/daily/'.$page->id, 'method' => 'DELETE')) }}
                                    <button  type="submit" class="btn default btn-sm btn-danger"><i class="fa fa-trash-o"></i> {{trans('layout.delete')}} </button>
                                    {{ Form::close() }}

                                </td>
                            </tr>
                            <?php $i++; ?>
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