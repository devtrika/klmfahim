@extends('admin.layouts.form')

@section('content')
<?php
$lang = LaravelLocalization::getCurrentLocale();
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
        {{trans('layout.site')}}
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item {{$pull}}"><a href="{{URL::to('admin')}}"> {{trans('layout.home')}}</a></li>
        <li class="breadcrumb-item active {{$pull}}">{{trans('layout.site_edit')}}</li>
    </ol>
</section>

<section class="content">

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">{{trans('layout.site_edit')}}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>

        <form action="{{URL::to('admin/site/1')}}" method="post" enctype="multipart/form-data">
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
                            <label for="input_1" class="col-sm-2 col-form-label">{{trans('layout.site_title_ar')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('ar_title',  $site['ar_title'], ['class'=>'form-control','id'=>'input_1']) }}
                                @if($errors->has('ar_title'))
                                <div class="alert alert-danger">{{$errors->first('ar_title')}}</div>
                                @endif
                            </div>
                            <label for="input_1" class="col-sm-2 col-form-label">{{trans('layout.site_title_en')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('en_title',  $site['en_title'], ['class'=>'form-control','id'=>'input_1']) }}
                                @if($errors->has('en_title'))
                                <div class="alert alert-danger">{{$errors->first('en_title')}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input_1" class="col-sm-2 col-form-label">{{trans('layout.site_desc_ar')}}</label>
                            <div class="col-sm-10">
                                {{ Form::textarea('desc',  $site['desc'], ['class'=>'form-control','rows'=>'4']) }}
                                @if($errors->has('desc'))
                                <div class="alert alert-danger">{{$errors->first('desc')}}</div>
                                @endif
                            </div>
                        </div>

                        <!--                        <div class="form-group row">
                                                    <label for="input_1" class="col-sm-2 col-form-label">{{trans('layout.officetime_ar')}}</label>
                                                    <div class="col-sm-10">
                                                        {{ Form::text('ar_office',  $site['ar_office'], ['class'=>'form-control','id'=>'input_1']) }}
                                                        @if($errors->has('ar_office'))
                                                        <div class="alert alert-danger">{{$errors->first('ar_office')}}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="input_1" class="col-sm-2 col-form-label">{{trans('layout.officetime_en')}}</label>
                                                    <div class="col-sm-10">
                                                        {{ Form::text('en_office',  $site['en_office'], ['class'=>'form-control','id'=>'input_1']) }}
                                                        @if($errors->has('en_office'))
                                                        <div class="alert alert-danger">{{$errors->first('en_office')}}</div>
                                                        @endif
                                                    </div>
                                                </div>-->
                        <div class="form-group row">
                            <label for="input_1" class="col-sm-2 col-form-label">{{trans('layout.site_add_ar')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('ar_address',  $site['ar_address'], ['class'=>'form-control','id'=>'input_1']) }}
                                @if($errors->has('ar_address'))
                                <div class="alert alert-danger">{{$errors->first('ar_address')}}</div>
                                @endif
                            </div>
                            <label for="input_1" class="col-sm-2 col-form-label">{{trans('layout.site_add_en')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('en_address',  $site['en_address'], ['class'=>'form-control','id'=>'input_1']) }}
                                @if($errors->has('en_address'))
                                <div class="alert alert-danger">{{$errors->first('en_address')}}</div>
                                @endif
                            </div>
                        </div>
                        <!--                        <div class="form-group row">
                                                    <label for="input_1" class="col-sm-2 col-form-label">{{trans('layout.site_add__ar')}}</label>
                                                    <div class="col-sm-10">
                                                        {{ Form::text('ar__address',  $site['ar__address'], ['class'=>'form-control','id'=>'input_1']) }}
                                                        @if($errors->has('ar__address'))
                                                        <div class="alert alert-danger">{{$errors->first('ar__address')}}</div>
                                                        @endif
                                                    </div>
                                                </div>
                        
                                                <div class="form-group row">
                                                    <label for="input_1" class="col-sm-2 col-form-label">{{trans('layout.site_add__en')}}</label>
                                                    <div class="col-sm-10">
                                                        {{ Form::text('en__address',  $site['en__address'], ['class'=>'form-control','id'=>'input_1']) }}
                                                        @if($errors->has('en__address'))
                                                        <div class="alert alert-danger">{{$errors->first('en__address')}}</div>
                                                        @endif
                                                    </div>
                                                </div>-->

                        <div class="form-group row">
                            <label for="input_5" class="col-sm-2 col-form-label">{{trans('layout.site_tags')}}</label>
                            <div class="col-sm-10">
                                {{ Form::text('tags',  $site['tags'], ['class'=>'form-control','id'=>'input_5']) }}
                                @if($errors->has('tags'))
                                <div class="alert alert-danger">{{$errors->first('tags')}}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input_6" class="col-sm-2 col-form-label">{{trans('layout.phone')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('phone',  $site['phone'], ['class'=>'form-control','id'=>'input_6']) }}
                                @if($errors->has('phone'))
                                <div class="alert alert-danger">{{$errors->first('phone')}}</div>
                                @endif
                            </div>
                            <label for="input_7" class="col-sm-2 col-form-label">{{trans('layout.mobile')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('mobile',  $site['mobile'], ['class'=>'form-control','id'=>'input_7']) }}
                                @if($errors->has('mobile'))
                                <div class="alert alert-danger">{{$errors->first('mobile')}}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input_14" class="col-sm-2 col-form-label">{{trans('layout.whatsapp')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('whatsapp',  $site['whatsapp'], ['class'=>'form-control','id'=>'input_14']) }}
                                @if($errors->has('whatsapp'))
                                <div class="alert alert-danger">{{$errors->first('whatsapp')}}</div>
                                @endif
                            </div>
                            <label for="input_9" class="col-sm-2 col-form-label">{{trans('layout.email')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('email',  $site['email'], ['class'=>'form-control','id'=>'input_9']) }}
                                @if($errors->has('email'))
                                <div class="alert alert-danger">{{$errors->first('email')}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input_10" class="col-sm-2 col-form-label">{{trans('layout.base')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('base',  $site['base'], ['class'=>'form-control','id'=>'input_10']) }}
                            </div>
                            <label for="input_11" class="col-sm-2 col-form-label">{{trans('layout.branches')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('branches',  $site['branches'], ['class'=>'form-control','id'=>'input_11']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input_10" class="col-sm-2 col-form-label">{{trans('layout.structure')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('structure',  $site['structure'], ['class'=>'form-control','id'=>'input_10']) }}
                            </div>
                            <label for="input_11" class="col-sm-2 col-form-label">{{trans('layout.mantis')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('mantis',  $site['mantis'], ['class'=>'form-control','id'=>'input_11']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="slogan_ar" class="col-sm-2 col-form-label">{{trans('layout.slogan_ar')}}</label>
                            <div class="col-sm-4">{{ Form::text('ar_slogan', $site['ar_slogan'], ['class'=>'form-control','id'=>'slogan_ar']) }}</div>
                            <label for="slogan_en" class="col-sm-2 col-form-label">{{trans('layout.slogan_en')}}</label>
                            <div class="col-sm-4">{{ Form::text('en_slogan', $site['en_slogan'], ['class'=>'form-control','id'=>'slogan_en']) }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="trn" class="col-sm-2 col-form-label">{{trans('layout.trn')}}</label>
                            <div class="col-sm-4">{{ Form::text('trn', $site['trn'], ['class'=>'form-control','id'=>'trn','dir'=>'ltr']) }}</div>
                            <label for="vat_rate" class="col-sm-2 col-form-label">{{trans('layout.vat_rate')}}</label>
                            <div class="col-sm-4">{{ Form::number('vat_rate', $site['vat_rate'] + 0, ['class'=>'form-control','id'=>'vat_rate','step'=>'0.01','min'=>0,'max'=>100]) }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="input_10" class="col-sm-2 col-form-label">{{trans('layout.facebook')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('facebook',  $site['facebook'], ['class'=>'form-control','id'=>'input_10']) }}
                                @if($errors->has('facebook'))
                                <div class="alert alert-danger">{{$errors->first('facebook')}}</div>
                                @endif
                            </div>
                            <label for="input_11" class="col-sm-2 col-form-label">{{trans('layout.twitter')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('twitter',  $site['twitter'], ['class'=>'form-control','id'=>'input_11']) }}
                                @if($errors->has('tags'))
                                <div class="alert alert-danger">{{$errors->first('twitter')}}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input_12" class="col-sm-2 col-form-label">{{trans('layout.instagram')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('instagram',  $site['instagram'], ['class'=>'form-control','id'=>'input_12']) }}
                                @if($errors->has('instagram'))
                                <div class="alert alert-danger">{{$errors->first('instagram')}}</div>
                                @endif
                            </div>
                            <label for="input_13" class="col-sm-2 col-form-label">{{trans('layout.youtube')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('youtube',  $site['youtube'], ['class'=>'form-control','id'=>'input_13']) }}
                                @if($errors->has('youtube'))
                                <div class="alert alert-danger">{{$errors->first('youtube')}}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="input_15" class="col-sm-2 col-form-label">{{trans('layout.snapchat')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('google',  $site['google'], ['class'=>'form-control','id'=>'input_15']) }}
                                @if($errors->has('google'))
                                <div class="alert alert-danger">{{$errors->first('google')}}</div>
                                @endif
                            </div>
                            <label for="input_15" class="col-sm-2 col-form-label">{{trans('layout.linkedin')}}</label>
                            <div class="col-sm-4">
                                {{ Form::text('linkedin',  $site['linkedin'], ['class'=>'form-control','id'=>'input_15']) }}
                                @if($errors->has('linkedin'))
                                <div class="alert alert-danger">{{$errors->first('linkedin')}}</div>
                                @endif
                            </div>
                        </div>


                        <!--
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">{{trans('layout.first')}}</label>
                                                    <div class="col-sm-10">
                                                        {{ Form::text('first',  $site['first'], ['class'=>'form-control','id'=>'input_15']) }}
                                                        @if($errors->has('first'))
                                                        <div class="alert alert-danger">{{$errors->first('first')}}</div>
                                                        @endif
                                                    </div>
                                                </div>-->
                        <!--                        <div class="form-group row">
                                                    <label  class="col-sm-2 col-form-label">{{trans('layout.second')}}</label>
                                                    <div class="col-sm-10">
                                                        {{ Form::text('second',  $site['second'], ['class'=>'form-control','id'=>'input_15']) }}
                                                        @if($errors->has('second'))
                                                        <div class="alert alert-danger">{{$errors->first('second')}}</div>
                                                        @endif
                        
                                                    </div>
                                                </div>-->

                        <div class="form-group row">
                            <label for="input_3" class="col-sm-2 col-form-label">{{trans('layout.logo')}}</label>
                            <div class="col-sm-4">
                                {{ Form::file('logo',['class'=>'form-control','id'=>'input_3']) }}
                                @if($errors->has('logo'))
                                <div class="alert alert-danger">{{$errors->first('logo')}}</div>
                                @endif
                                <img style="height: 120px" src="{{URL::to('/'.$site['logo'])}}" class="img-thumbnail">

                            </div>
                            <label for="input_3" class="col-sm-2 col-form-label">{{trans('layout.logofooter')}}</label>
                            <div class="col-sm-4">
                                {{ Form::file('footer',['class'=>'form-control','id'=>'input_3']) }}
                                @if($errors->has('footer'))
                                <div class="alert alert-danger">{{$errors->first('footer')}}</div>
                                @endif
                                <img style="height: 120px" src="{{URL::to('/'.$site['footer'])}}" class="img-thumbnail">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="editor1" class="col-sm-2 col-form-label">{{trans('layout.footerword_ar')}}</label>
                            <div class="col-sm-4">
                                {{ Form::textarea('ar_footerword', $site['ar_footerword'], ['class'=>'form-control','id'=>'','rows'=>10]) }}
                                @if($errors->has('ar_footerword'))
                                <div class="alert alert-danger">{{$errors->first('ar_footerword')}}</div>
                                @endif
                            </div>
                            <label for="editor1" class="col-sm-2 col-form-label">{{trans('layout.footerword_en')}}</label>
                            <div class="col-sm-4">
                                {{ Form::textarea('en_footerword', $site['en_footerword'], ['class'=>'form-control','id'=>'','rows'=>10]) }}
                                @if($errors->has('en_footerword'))
                                <div class="alert alert-danger">{{$errors->first('en_footerword')}}</div>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">

                        </div>

                        <!--                          <div class="form-group row">
                                                    <label for="input_3" class="col-sm-2 col-form-label">{{trans('layout.docimage')}}</label>
                                                    <div class="col-sm-10">
                                                        {{ Form::file('third',['class'=>'form-control','id'=>'input_3']) }}
                                                        @if($errors->has('third'))
                                                        <div class="alert alert-danger">{{$errors->first('third')}}</div>
                                                        @endif
                                                        <img style="height: 120px" src="{{URL::to('/'.$site['third'])}}" class="img-thumbnail">
                        
                                                    </div>
                                                </div>-->
                        <div class="input-group">
                            <label for="input_16" class="col-sm-2 col-form-label">{{trans('layout.map')}}</label>
                            {{ Form::text('lat',  $site['lat'], ['class'=>'form-control','id'=>'input_15']) }}
                            <!--                            <div class="col-sm-10">
                                                            <div id="mapCanvas" style="height:300px;" class="col-md-12"></div>
                                                            <input type="hidden" value="{{$site['lat']}}" id="lat" name="lat" />
                                                            <input type="hidden" value="{{$site['lng']}}" id="lng" name="lng" />
                                                            @if($errors->has('lat'))
                                                            <div class="alert alert-danger">{{$errors->first('lat')}}</div>
                                                            @endif               
                                                        </div>-->
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="input_3" class="col-sm-2 col-form-label">{{trans('layout.video')}}</label>
                            <div class="col-sm-4">
                                {{ Form::file('video',['class'=>'form-control','id'=>'input_3']) }}

                                <video width="320" height="240" controls>
                                    <source src="{{URL::to('/'.$site['video'])}}" type="video/mp4">
                                    <source src="{{URL::to('/'.$site['video'])}}" type="video/ogg">
                                    Your browser does not support the video tag.
                                </video>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-lg" style="font-size: 16px;">{{trans('layout.save')}}</button>
                <a href="{{URL::to('admin')}}" class="btn btn-default btn-lg" style="font-size: 16px;">{{trans('layout.back')}}</a>
            </div>

        </form>

    </div>

</section>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbAGf9JYWiHnXDdIqVWWcJmDUZ-eBamc4&callback=initMap&language=ar&region=EG"></script>
<script type="text/javascript">
var marker;
var lat;
var lng;
var map;
function updateMarkerPosition(latLng) {
    document.getElementById('lat').value = latLng.lat();
    document.getElementById('lng').value = latLng.lng();
}

function placeMarker(location) {
    if (marker) {
        marker.setPosition(location);
    } else {
        marker = new google.maps.Marker({
            position: location,
            map: map
        });
    }
}

function initialize() {
    var lat = document.getElementById('lat').value;
    var lng = document.getElementById('lng').value;
    if (!lat && !lng) {
        var latLng = new google.maps.LatLng(24.598411724742483, 46.7138671875);
    } else {
        var latLng = new google.maps.LatLng(lat, lng);
    }

    map = new google.maps.Map(document.getElementById('mapCanvas'), {
        zoom: 13,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    marker = new google.maps.Marker({
        position: latLng,
        map: map
    });
    marker.set(map);
    updateMarkerPosition(latLng);
    google.maps.event.addListener(map, 'click', function (event) {
        placeMarker(event.latLng);
        updateMarkerPosition(event.latLng);
    });
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
@endsection
