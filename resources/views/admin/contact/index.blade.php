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
        {{trans('layout.contact')}}
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('trika')}}"> {{trans('layout.home')}}</a></li>
        <li class="breadcrumb-item active {{$pull}}">{{trans('layout.contact')}}</li>
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
                <div class="box-body">
                    <table id="example" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
                        <thead>
                            <tr> 
                                <th class="{{$text}}">#</th>
                                <th class="{{$text}}">{{trans('layout.name')}}</th>
                                <th class="{{$text}}">{{trans('layout.phone')}}</th>
                                <th class="{{$text}}">{{trans('layout.message_title')}}</th>
                                <th class="{{$text}}">{{trans('layout.contact_active')}}</th>
                                <th class="{{$text}}">{{trans('layout.reply')}}</th>
                                <th class="{{$text}}">{{trans('layout.delete')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($contacts as $contact)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$contact['name']}}</td>
                                <td dir="ltr" class="cf-ltr">{{$contact['phone']}}</td>
                                <td>{{$contact['title']}}</td>
                                <td>
                                    @if($contact['seen'] == "yes" && $contact['reply'] != "")
                                    {{trans('layout.seen_reply')}}
                                    @elseif($contact['seen'] == "yes" && $contact['reply'] == "")
                                    {{trans('layout.seen_reply_not')}}
                                    @elseif($contact['seen'] == "no" )
                                    {{trans('layout.seen_not')}}
                                    @endif
                                </td>
                                <td>
                                    {{ Form::open(array('url' =>'trika/contact/'.$contact->uuid.'/edit', 'method' => 'GET')) }}
                                    <button  type="submit" class="btn default btn-sm btn-info"><i class="fa fa-edit"></i> {{trans('layout.reply')}} </button>
                                    {{ Form::close() }}
                                </td>
                                <td>
                                    {{ Form::open(array('url' =>'trika/contact/'.$contact->uuid, 'method' => 'DELETE')) }}
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