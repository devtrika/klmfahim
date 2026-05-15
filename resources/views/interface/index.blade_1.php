@extends('interface.layout')

@section('content')
<?php
$lang = LaravelLocalization::getCurrentLocale() ;
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
<!-- ***** Header Area End ***** -->

<!-- ***** Hero Area Start ***** -->

<!-- ***** Hero Area End ***** -->
<!-- ***** New slider Start ***** -->

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <?php
        $slides = App\Slider::all();
        $m=0;
        ?>
         @foreach($slides as $slide)
        <div class="carousel-item @if($m == 0) active @endif ">
            <img class="d-block w-100" src="{{URL::to('upload/slider/'.$slide['image'])}}" alt="image slide">
        </div>
        <?php
        $m=1;
        ?>
        @endforeach
        
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


<!-- ***** New slider End ***** -->



<!-- ***** Contact Info Area Start ***** -->
<div class="medica-contact-info-area">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-12 col-md-4 col-lg-4">
                <div class="single-contact-info d-flex justify-content-center align-items-center text-center">
                    <div class="contact-icon mb-15">
                        <!--<img src="{{URL::to('interface')}}/img/icons/alarm-clock.png" alt="">-->
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                    </div>
                    <div class="contact-meta">
                        <p>{{$site[$lang.'_office']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-4">
                <div class="single-contact-info d-flex justify-content-center align-items-center text-center">
                    <div class="contact-icon mb-15">
                        <!--<img src="{{URL::to('interface')}}/img/icons/envelope.png" alt="">-->
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </div>
                    <div class="contact-meta">
                        <p>{{$site['mobile']}} | {{$site['phone']}} <br> {{$site['email']}}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-4">
                <div class="single-contact-info d-flex justify-content-center align-items-center text-center">
                    <div class="contact-icon mb-15">
                        <!--<img src="{{URL::to('interface')}}/img/icons/map-pin.png" alt="">-->
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                    </div>
                    <div class="contact-meta">
                        <p>{{$site[$lang.'_address']}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Contact Info Area End ***** -->

<!-- ***** About Us Area Start ***** -->
<section class="medica-about-us-area">
    <!-- Card Area -->
    <div class="medica-card-area">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="medica-emergency-card wow fadeInUp" data-wow-delay="0.2s">
                        <?php $page = App\Page::where('id', '3')->first(); ?>
                        <h5>{{$page[$lang.'_title']}}</h5>
                        <p>{{ str_limit(strip_tags($page[$lang.'_desc']), 300) }}..</p>
                        <a href="{{URL::to('page/'.$page['id'])}}">{{trans('interface.readmore')}}</a>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="medica-doctors-card wow fadeInUp" data-wow-delay="0.4s">
                        <?php $page = App\Page::where('id', '2')->first(); ?>
                        <h5>{{$page[$lang.'_title']}}</h5>
                        <p>{{ str_limit(strip_tags($page[$lang.'_desc']), 300) }}..</p>
                        <a href="{{URL::to('page/'.$page['id'])}}">{{trans('interface.readmore')}}</a>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="medica-appointment-card wow fadeInUp" data-wow-delay="0.6s">
                        <h5>{{trans('layout.booknew')}}</h5>
                        <form method="post" id="myForm" action="{{URL::to('booking')}}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="text" class="form-control text-white" onblur="validOnblur('name');"
                                       placeholder="{{trans('layout.name')}}"      onkeypress="validOnblur('name');"  maxlength="50" name="name" id="name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" onblur="validOnblur('phone');"
                                       placeholder="{{trans('layout.phone')}}"    onkeypress="validOnblur('phone');"  maxlength="50" name="phone" id="phone">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control"
                                       placeholder="{{trans('layout.email')}}"      maxlength="50" name="email" id="email" >
                            </div>
                            <input type="button" class="btn medica-btn mt-15" onclick="validAll()" value="{{trans('layout.booknow')}}">
                        </form>
                    </div>
                </div>
            </div>
        </div><script>

            function validAll() {
                if (document.getElementById("name").value && document.getElementById("phone").value ) {
                    document.getElementById("myForm").submit();
                } else {
                    validOnblur("name");
                    validOnblur("phone");
                }
            }
            function validateEmail() {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(document.getElementById("email").value);
            }
            function validOnblur(op) {
                switch (op) {
                    case 'name':
                        document.getElementById("name").value ? document.getElementById("name").classList.remove("vald_txt") : document.getElementById("name").classList.add("vald_txt");
                        // document.getElementById("name").value ? document.getElementById("spn_name").classList.remove("vald_txt") : document.getElementById("spn_name").classList.add("vald_txt");
                        break;

                    case 'phone':
                        document.getElementById("phone").value ? document.getElementById("phone").classList.remove("vald_txt") : document.getElementById("phone").classList.add("vald_txt");
                        // document.getElementById("phone").value && validateEmail() ? document.getElementById("spn_phone").classList.remove("vald_txt") : document.getElementById("spn_phone").classList.add("vald_txt");
                        break;
                }
            }

        </script>
    </div>
    <!-- About Contact -->
    <div class="medica-about-content section_padding_100">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-7">
                    <div class="medica-about-text">

                        <?php $page = App\Page::where('id', '1')->first(); ?>


                        <h2>{{$page[$lang.'_title']}}</h2>
                        <p>{{ str_limit(strip_tags($page[$lang.'_desc']), 500) }}..</p>
                        <a href="{{URL::to('page/'.$page['id'])}}" class="btn medica-btn btn-2" >{{trans('interface.readmore')}}</a>

                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="medica-about-thumbnail medica-rounded-thumbnail">
                        <img src="{{URL::to('upload')}}/pages/{{$page['image']}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** About Us Area End ***** -->

<!-- ***** Services Area Start ***** -->
<section class="medica-services-area section_padding_100 bg-img gradient-background-overlay" style="background-image: url({{URL::to('interface')}}/img/bg-img/service.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_heading white-heading">
               <!--     <img src="{{URL::to('interface')}}/img/icons/hospital2.png" alt="">-->
                    <h2>{{trans('layout.services')}}</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <?php $servs = App\Service::paginate('6'); ?>
            @foreach($servs as $serv)
            <div class="col-12 col-sm-6 col-lg-4 ">
                <a href="{{URL::to('service/'.$serv['id'])}}" title="{{$serv[$lang.'_title']}}" class="more-btn-2">
                    <div class="single-service-area wow fadeInUp" data-wow-delay="0.2s">
                        <div class="single-service-area-img-container">
                            <img  style="height: 125px;width: 138px;" src="{{URL::to('upload')}}/services/{{$serv['image']}}" alt="{{$serv[$lang.'_title']}}">
                        </div>
                        <h5>{{$serv[$lang.'_title']}}</h5>
                       
                    </div>
                </a>
            </div>
            @endforeach

            <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.9s">
                <a href="{{URL::to('services')}}" class="btn medica-btn">{{trans('interface.readmore')}}</a>
            </div>
        </div>
    </div>
</section>


<!-- ***** Testimonials Area Start ***** -->
<section class="medica-testimonials-area section_padding_100 bg-img background-overlay" style="direction:ltr;background-image: url({{URL::to('interface')}}/img/bg-img/hero2.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_heading white-heading">
                <!--    <img src="{{URL::to('interface')}}/img/icons/stethoscope.png" alt="">-->
                    <h2>{{trans('layout.opinions')}}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="testimonials-slider owl-carousel">
        <!-- Single Testimonials Slide -->
        <?php $clients = \App\Opinon::all();
        ?>
        @foreach($clients as $client)
        <div class="single-testimonial-slide">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h6>{{strip_tags($client[$lang.'_desc'])}}</h6>
                        <div class="testimonial-given-author-info">
                            <img src="{{URL::to('upload')}}/opinions/{{$client['image']}}" alt="{{$client[$lang.'_title']}}">
                            <h6>{{$client[$lang.'_title']}}</h6>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- ***** Partners Area Start ***** -->
<!--<div class="medica-our-partners-area section_padding_100">-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col-12">-->
<!--                <div class="our-partners-logo d-flex align-items-center justify-content-center">-->
                   <?php
// $clients = \App\Client::all();
                  ?>
<!--                    @foreach($clients as $client)-->
<!--                    <a href="{{URL::to('client/'.$client['id'])}}">-->
<!--                        <img style="height: 80px;width: 80px"  src="{{URL::to('upload')}}/clients/{{$client['image']}}" alt="{{$client[$lang.'_title']}}" >-->
<!--                    </a>-->
<!--                    @endforeach-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- ***** Partners Area End ***** -->

@endsection