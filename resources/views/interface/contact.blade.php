@extends('interface.layout')

@section('content')
<?php
$lang = LaravelLocalization::getCurrentLocale();
$site = \App\Site::first();
?>
<style>
    .vald_txt {
        color: #F22613 !important;
        border-color: #F22613 !important;
        box-shadow: 0 0 6px #f8b9b7;
        border: 1px solid #F22613;

    }
</style>
<!-- Start Breadcrumb -->
<section
    class="breadcrumb-section"
    style="background-image: url({{url('interface')}}/images/breadcrumb.jpg)"
    >
    <div class="container">
        <div class="breadcrumb-content">
            <h1 class="page-title">{{trans('layout.contact')}}</h1>
        </div>
    </div>
</section>
<!-- End Breadcrumb -->
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
<section class="page-content">
    <div class="contact-methods-content">
        <div class="container">
            <div class="contact-methods-list">
                <a href="mailto:{{$site['email']}}" class="contact-method-item">
                    <i class="fa-solid fa-envelope"></i>
                    <span class="value en"> {{$site['email']}}</span>
                </a>
                <a href="tel:{{$site['mobile']}}" class="contact-method-item">
                    <i class="fa-solid fa-mobile"></i>
                    <span class="value en"> {{$site['mobile']}} </span>
                </a>
                <a href="tel:{{$site['phone']}}" class="contact-method-item">
                    <i class="fa-solid fa-phone"></i>
                    <span class="value en"> {{$site['phone']}} </span>
                </a>
                <div class="contact-method-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <span class="value">{{$site[$lang.'_address']}}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="contact-form-content">
        <div class="container">
            <div class="contact-row">
                <div class="contact-img loading-img lazy-img-parent">
                    <img data-src="{{url('interface')}}/images/contact.png" class="img-fluid lazy-img" />
                </div>
                <div class="contact-form">
                    <h2 class="section-title"><span>{{trans('layout.youhaveques')}}</span></h2>
                    <h4 class="contact-subtitle">
                        {{trans('layout.contactusifyouhaveques')}}
                    </h4>
                    <form method="post" id="myForm" class="cont-pg-form" action="{{URL::to('contactus')}}">
                        {{ csrf_field() }}
                        <div class="form-grid">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="custom-input"
                                    onblur="validOnblur('name');"
                                    onkeypress="validOnblur('name');" 
                                    maxlength="50" name="name" id="name"
                                    placeholder="{{trans('layout.name')}}"
                                    />
                                @if($errors->has('name'))
                                <div class="alert alert-danger">{{$errors->first('name')}}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="custom-input"
                                    placeholder="{{trans('layout.phone')}}"
                                    onblur="validOnblur('phone');"
                                    onkeypress="validOnblur('phone');"  maxlength="50" name="phone" id="phone"
                                    />
                            </div>
                            <div class="form-group">
                                <input
                                    type="email"
                                    class="custom-input"
                                    placeholder="{{trans('layout.email')}}"
                                    onblur="validOnblur('email');"
                                    onkeypress="validOnblur('email');"  maxlength="50" name="email" id="email"
                                    />
                            </div>
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="custom-input"
                                    placeholder="{{trans('interface.message_title')}}"
                                    onblur="validOnblur('title');"
                                    onkeypress="validOnblur('title');"  maxlength="50" name="title" id="title"
                                    />
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea
                                class="custom-input"
                                placeholder="{{trans('interface.message_text')}}"
                                name="message" id="message" rows="10"
                                onblur="validOnblur('message');" onkeypress="validOnblur('message');"
                                ></textarea>
                        </div>
                        <div class="form-grid">

                            <div class="form-group ">
                                <div class="captcha">
                                    <span id="spn_cpatch">{!! captcha_img() !!}</span>
                                    <button type="button" class="btn btn-danger" class="reload" id="reload">
                                        &#x21bb;
                                    </button>
                                </div>
                                <input id="captcha" onblur="validOnblur('captcha');" onkeypress="validOnblur('captcha');" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                                @if($errors->has('captcha'))
                                <div class="alert alert-danger">{{$errors->first('captcha')}}</div>
                                @endif
                            </div>
                        </div>
                        <input type="button"  class="main-btn submit-btn" onclick="validAll()" value="{{trans('interface.send')}}">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="contact-map">
        <iframe
            src="{{$site['lat']}}"
            width="600"
            height="450"
            frameborder="0"
            style="border: 0"
            allowfullscreen=""
            ></iframe>
    </div>
</section>
<!--<div id="page-tit" class="text-center gallery-h1">
    <div class="container">
        <h1 class="wow fadeInUp">{{trans('interface.contact')}}</h1>
    </div>
</div>
<div class="div-padding">

    <div class="container">

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
        <br> 
    <div class="row">

    

        <div class="col-xs-12 col-md-3 pull-right wow fadeInUp" data-wow-delay="0.4s">
            <h4 class="cont-pg-item"><i class="fa fa-envelope"></i> {{$site['email']}}</h4>
        </div>
        <div class="col-xs-12 col-md-3 pull-right wow fadeInUp" data-wow-delay="0.4s">
            <h4 class="cont-pg-item"><i class="fa fa-phone"></i> {{$site['phone']}}</h4>
        </div>
        <div class="col-xs-12 col-md-3 pull-right wow fadeInUp" data-wow-delay="0.4s">
            <h4 class="cont-pg-item"><i class="fa fa-mobile"></i> {{$site['mobile']}}</h4>
        </div>
        <div class="col-xs-12 col-md-3 pull-right wow fadeInUp" data-wow-delay="0.4s">
            <h4 class="cont-pg-item"><i class="fa fa-fax"></i> {{$site['fax']}}</h4>
        </div>

        <div class="col-xs-12 col-md-12 pull-right wow fadeInUp">
            <br>

            <form method="post" id="myForm" class="cont-pg-form" action="{{URL::to('contactus')}}">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="input_1">{{trans('layout.name')}}</label>

                    <input type="text" class="form-control " onblur="validOnblur('name');"
                           onkeypress="validOnblur('name');"  maxlength="50" name="name" id="name"/>

                    @if($errors->has('name'))
                    <div class="alert alert-danger">{{$errors->first('name')}}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="input_2">{{trans('layout.phone')}}</label>

                    <input type="text" class="form-control " onblur="validOnblur('phone');"
                           onkeypress="validOnblur('phone');"  maxlength="50" name="phone" id="phone"/>

                    @if($errors->has('phone'))
                    <div class="alert alert-danger">{{$errors->first('phone')}}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="input_3">{{trans('layout.email')}}</label>

                    <input type="text" class="form-control " onblur="validOnblur('email');"
                           onkeypress="validOnblur('email');"  maxlength="50" name="email" id="email"/>

                    @if($errors->has('email'))
                    <div class="alert alert-danger">{{$errors->first('email')}}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="input_4">{{trans('interface.message_title')}}</label>

                    <input type="text" class="form-control " onblur="validOnblur('title');"
                           onkeypress="validOnblur('title');"  maxlength="50" name="title" id="title"/>

                    @if($errors->has('title'))
                    <div class="alert alert-danger">{{$errors->first('title')}}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="input_5">{{trans('interface.message_text')}}</label>
                    <textarea class="form-control" name="message" id="message" rows="10"
                              onblur="validOnblur('message');" onkeypress="validOnblur('message');"/></textarea>

                    @if($errors->has('message'))
                    <div class="alert alert-danger">{{$errors->first('message')}}</div>
                    @endif
                </div>
                <input type="button"  class="btn btn-primary" onclick="validAll()" value="{{trans('interface.send')}}">

            </form>

        </div>
    </div>
</div> </div>-->
<br>





@endsection