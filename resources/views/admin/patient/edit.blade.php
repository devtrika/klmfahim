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
        {{trans('layout.patient')}}
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('trika')}}"> {{trans('layout.home')}}</a></li>
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('trika/patient')}}"> {{trans('layout.patient')}}</a></li>
        <li class="breadcrumb-item active {{$pull}}">{{trans('layout.edit')}}</li>
    </ol>
</section>

<section class="content">

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">{{trans('layout.edit')}} : {{$page[$lang.'_name']}}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>

        <form action="{{URL::to('trika/patient/'.$page->uuid)}}" method="post" enctype="multipart/form-data">
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
                            <label for="input_1" class="col-sm-3 col-form-label">{{trans('layout.code')}}</label>
                            <div class="col-sm-9">
                             
                                {{ Form::text('code', $page['id'], ['class'=>'form-control','onblur'=>'changefun()','disabled'=>'disabled']) }}

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input_1" class="col-sm-3 col-form-label">{{trans('layout.daily_ar_name')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('ar_name', $page['ar_name'], ['class'=>'form-control','id'=>'ar_name','onblur'=>'changefun()']) }}
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
                                {{ Form::text('en_name', $page['en_name'], ['class'=>'form-control','id'=>'en_name']) }}
                                @if($errors->has('en_name'))
                                <div class="alert alert-danger">{{$errors->first('en_name')}}</div>
                                @endif
                            </div>
                        </div>
 <div class="form-group row">
                            <label for="input_1" class="col-sm-3 col-form-label">{{trans('layout.phone')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('phone', $page['phone'], ['class'=>'form-control']) }}
                                @if($errors->has('phone'))
                                <div class="alert alert-danger">{{$errors->first('phone')}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input_1" class="col-sm-3 col-form-label">{{trans('layout.address')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('address', $page['address'], ['class'=>'form-control']) }}
                                @if($errors->has('address'))
                                <div class="alert alert-danger">{{$errors->first('address')}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input_1" class="col-sm-3 col-form-label">{{trans('layout.age')}}</label>
                            <div class="col-sm-9">
                                {{ Form::text('age', $page['age'], ['class'=>'form-control']) }}
                                @if($errors->has('age'))
                                <div class="alert alert-danger">{{$errors->first('age')}}</div>
                                @endif
                            </div>
                        </div>
                        
                           <div class="row border">
                            <div class="col-sm-3">
                                {{ Form::select('status', ['detection'=>trans('layout.detection') , 'revealed'=>trans('layout.revealed')],null, ['class'=>'form-control','id'=>'input_0']) }}
                            </div>
                            <div class="col-sm-3">
                                {{ Form::text('money', null, ['class'=>'form-control' ,'placeholder'=>trans('layout.money')]) }}
                            </div> 
                            <div class="col-sm-3">
                                {{ Form::date('dates',  date("Y-m-d"), ['class'=>'form-control' ]) }}
                            </div>
                        </div> <br><br>
                        <div class="row border">
                           
                            <div class="col-sm-12 text-center text-bold">{{trans('layout.records')}}</div>
                            <br><br>
                   <?php  $patients = \App\Models\Patient_status::where('user',$page['id'])->orderby('id','desc')->get(); ?>
                            @foreach($patients as $patient)
                            <div class="col-sm-3">
                                {{ Form::select('statusdd', ['detection'=>trans('layout.detection') , 'revealed'=>trans('layout.revealed')],$patient['status'], ['class'=>'form-control','disabled'=>'disabled']) }}
                            </div>
                            <div class="col-sm-3">
                                {{ Form::text('moneydd', $patient['money'], ['class'=>'form-control' ,'placeholder'=>trans('layout.money'),'disabled'=>'disabled']) }}
                            </div> 
                            <div class="col-sm-3">
                                {{ Form::date('datedds',  $patient['dates'], ['class'=>'form-control' ,'disabled'=>'disabled']) }}
                            </div>
                            <div class="col-sm-3">
                                <a href="/removethis/{{$patient['id']}}" class="fa fa-remove"></a>
                                 </div>
                            
                            @endforeach
                            
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-lg" style="font-size: 16px;">{{trans('layout.save')}}</button>
                <a href="{{URL::to('trika/patient')}}" class="btn btn-default btn-lg" style="font-size: 16px;">{{trans('layout.back')}}</a>
            </div>

        </form>

    </div>

</section>

@endsection