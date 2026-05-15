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
<!-- Start Hero -->
<main class="hero-section">
    <div class="main-slider">
        <div class="swiper">
            <div class="swiper-wrapper">
                <?php $sliders = \App\Slider::orderby('id', 'desc')->get(); ?>
                @foreach($sliders as $slider)

                <div class="swiper-slide">
                    <div class="main-slide">
                        <div class="slide-img loading-img lazy-img-parent">
                            <img
                                data-src="{{URL::to('upload/slider/'.$slider['image'])}}"
                                class="img-fluid lazy-img"
                                />
                        </div>
<!--                        <div class="slide-text">
                            <figure class="slide-icon">
                                <img src="{{url('interface')}}/images/hero/icon.png" />
                            </figure>
                            <h2 class="slide-title">{{$slider[$lang.'_title']}}</h2>
                            <p class="slide-desc">
                                {{$slider[$lang.'_desc']}}                       
                            </p>
                            <a href="tel:{{$site['mobile']}}" class="main-btn slide-btn">
                                <i class="fa-solid fa-phone"></i>
                                {{trans('layout.contact')}} 
                            </a>
                        </div>-->
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        <div class="swiper-btn-prev swiper-btn">
            <i class="fa-solid fa-chevron-right"></i>
        </div>
        <div class="swiper-btn-next swiper-btn">
            <i class="fa-solid fa-chevron-left"></i>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</main>
<!-- End Hero -->
<!-- Start Partners -->
<section class="partners-section">
    <div class="container">
        <div class="partners-content">
            <h2 class="section-title" data-sal="slide-down">
                <span>{{trans('layout.clients')}} </span>
            </h2>
            <div
                class="partners-slider custom-slider"
                data-sal="slide-up"
                style="--sal-delay: 0.15s"
                >
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php $opinions = App\Client::get();
                        ?>
                        @foreach($opinions as $opinion)
                        <div class="swiper-slide">
                            <div class="partner-item">
                                <a
                                    href="{{$opinion['href']}}" target='_blank'
                                    class="partner-img loading-img lazy-img-parent"
                                    >
                                    <img
                                        data-src="{{URL::to('upload/clients/'.$opinion['image'])}}"
                                        alt="{{$opinion[$lang."_title"]}}"
                                        class="img-fluid lazy-img"
                                        />
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</section>
<!-- End Partners -->
<!-- Strat About -->
<section class="about-section">
    <div class="container">
        <div class="about-content">
            <div class="about-text">
                <?php $serv = App\Page::orderby('id', 'desc')->where('id', '1')->first();
                
                ?>

                <h2 class="section-title" data-sal="slide-down">
                    <span>{{$serv[$lang.'_title']}}</span>
                </h2>
                <p
                    class="about-desc"
                    data-sal="slide-down"
                    style="--sal-delay: 0.15s"
                    >
                    {{Illuminate\Support\Str::limit(strip_tags($serv[$lang.'_desc']), 250)}}
                </p>
                <a
                    href="{{URL::to('page/'.$serv['id'])}}/{{urlencode(strtolower($serv[$lang.'_title']))}}"
                    class="main-btn about-btn"
                    data-sal="slide-down"
                    style="--sal-delay: 0.3s"
                    >
                    {{trans('layout.readmore')}}
                </a>
            </div>
            <div class="about-media">
                 <div class="about-video" data-sal="zoom-in" style="--sal-delay: 0.2s;text-align: center">
                  <video width="320" height="300" controls>
                                    <source src="{{URL::to('/'.$site['video'])}}" type="video/mp4">
                                    <source src="{{URL::to('/'.$site['video'])}}" type="video/ogg">
                                    Your browser does not support the video tag.
                                </video>
                </div> 
<!--                <div
                    class="about-img loading-img lazy-img-parent"
                    data-sal="zoom-in"
                    style="--sal-delay: 0.2s"
                    >
                   
                </div>-->
            </div>
        </div>
    </div>
</section>
<!-- End About -->

<!-- Strat Statistics -->
<section class="statistics-section">
    <div class="container">
        <div class="statistics-content">
            <div class="statistics-box" data-sal="flip-down">
                <div class="statistics-icon">
                    <i class="fa-solid fa-calendar-alt"></i>
                </div>
                <div class="statistics-text">
                    <h4> {{trans('layout.base')}}</h4>
                    <h5 class="count">{{$site['base']}}</h5>
                </div>
            </div>
            <div
                class="statistics-box"
                data-sal="flip-down"
                style="--sal-delay: 0.15s"
                >
                <div class="statistics-icon">
                    <i class="fa-solid fa-align-center"></i>
                </div>
                <div class="statistics-text">
                    <h4> {{trans('layout.branches')}}</h4>
                    <h5 class="count">{{$site['branches']}}</h5>
                </div>
            </div>
            <div
                class="statistics-box"
                data-sal="flip-down"
                style="--sal-delay: 0.3s"
                >
                <div class="statistics-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="statistics-text">
                    <h4> {{trans('layout.structure')}}</h4>
                    <h5 class="count">{{$site['structure']}}</h5>
                </div>
            </div>
            <div
                class="statistics-box"
                data-sal="flip-down"
                style="--sal-delay: 0.45s"
                >
                <div class="statistics-icon">
                    <i class="fa-solid fa-cogs"></i>
                </div>
                <div class="statistics-text">
                    <h4> {{trans('layout.mantis')}}</h4>
                    <h5 class="count">{{$site['mantis']}}</h5>
                </div>
            </div>
            <!--            <div
                            class="statistics-box"
                            data-sal="flip-down"
                            style="--sal-delay: 0.45s"
                            >
                            <div class="statistics-icon">
                                <i class="fa-solid fa-building"></i>
                            </div>
                            <div class="statistics-text">
                                <h4>مصاعد تم تركيبها</h4>
                                <h5 class="count">120</h5>
                            </div>
                        </div>
                        <div
                            class="statistics-box"
                            data-sal="flip-down"
                            style="--sal-delay: 0.3s"
                            >
                            <div class="statistics-icon">
                                <i class="fa-solid fa-sliders"></i>
                            </div>
                            <div class="statistics-text">
                                <h4>مصاعد تحت التنفيذ</h4>
                                <h5 class="count">123</h5>
                            </div>
                        </div>
                        <div
                            class="statistics-box"
                            data-sal="flip-down"
                            style="--sal-delay: 0.15s"
                            >
                            <div class="statistics-icon">
                                <i class="fa-solid fa-file-text"></i>
                            </div>
                            <div class="statistics-text">
                                <h4>عقود صيانة</h4>
                                <h5 class="count">300</h5>
                            </div>
                        </div>-->
        </div>
    </div>
</section>
<!-- End Statistics -->

<!-- Strat About -->
<section class="about-section">
    <div class="container">
        <div class="about-content">
            <div class="about-media">
                <div
                    class="about-img loading-img lazy-img-parent"
                    data-sal="zoom-in"
                    style="--sal-delay: 0.2s"
                    >
                        <?php $serv = App\Page::orderby('id', 'desc')->where('id', '2')->first(); ?>
                    <img data-src="{{URL::to('upload/pages/'.$serv['image'])}}" class="img-fluid lazy-img" />
                </div>
            </div>

            <div class="about-text">
                <h2 class="section-title" data-sal="slide-down">
                    <span>{{$serv[$lang.'_title']}}</span>
                </h2>
                <p
                    class="about-desc"
                    data-sal="slide-down"
                    style="--sal-delay: 0.15s"
                    >
                    {{Illuminate\Support\Str::limit(strip_tags($serv[$lang.'_desc']), 250)}}

                </p>
                <a
                    href="{{URL::to('page/'.$serv['id'])}}/{{urlencode(strtolower($serv[$lang.'_title']))}}"
                    class="main-btn about-btn"
                    data-sal="slide-down"
                    style="--sal-delay: 0.3s"
                    >
                    {{trans('layout.readmore')}}
                </a>
            </div>
        </div>
        
        <div class="about-content">
            <div class="about-text">
                <?php $serv = App\Page::orderby('id', 'desc')->where('id', '3')->first(); ?>

                <h2 class="section-title" data-sal="slide-down">
                    <span>{{$serv[$lang.'_title']}}</span>
                </h2>
                <p
                    class="about-desc"
                    data-sal="slide-down"
                    style="--sal-delay: 0.15s"
                    >
                    {{Illuminate\Support\Str::limit(strip_tags($serv[$lang.'_desc']), 250)}}

                </p>
                <a
                    href="{{URL::to('page/'.$serv['id'])}}/{{urlencode(strtolower($serv[$lang.'_title']))}}"
                    class="main-btn about-btn"
                    data-sal="slide-down"
                    style="--sal-delay: 0.3s"
                    >
                    {{trans('layout.readmore')}}
                </a>
            </div>
            <div class="about-media">
                <div
                    class="about-img loading-img lazy-img-parent"
                    data-sal="zoom-in"
                    style="--sal-delay: 0.2s"
                    >
                    <img data-src="{{URL::to('upload/pages/'.$serv['image'])}}" class="img-fluid lazy-img" />
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End About -->


<!-- Strat Services -->
<section class="services-section">
    <div class="container">
        <div class="services-content">
            <h2 class="section-title" data-sal="slide-down">
                <span>{{trans('layout.bestservices')}}</span>
            </h2>
            <div
                class="services-slider custom-slider"
                data-sal="slide-up"
                style="--sal-delay: 0.15s"
                >
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php $services = App\Service::limit(3)->get(); ?>
                        @foreach($services as $service)
                        <div class="swiper-slide">
                            <a href="{{URL::to('service/'.$service['id'])}}/{{urlencode(strtolower($service[$lang.'_title']))}}" class="service-item">
                                <div class="service-img loading-img lazy-img-parent">
                                    <img
                                        data-src="{{URL::to('upload/services/'.$service['image'])}}"
                                        class="img-fluid lazy-img"
                                        />
                                </div>
                                <div class="service-title">{{$service[$lang."_title"]}}</div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div
                class="section-more"
                data-sal="slide-down"
                style="--sal-delay: 0.3s"
                >
                <a href="{{URL::to('allservices')}}/{{trans('layout.bestservices')}}" class="main-btn"> {{trans('layout.readmore')}} </a>
            </div>
        </div>
    </div>
</section>
<!-- End Services -->



<!-- Strat Testimonials -->
<section class="testimonials-section">
    <div class="container">
        <div class="testimonials-content">
            <h2 class="section-title" data-sal="slide-down">
                <span>{{trans('layout.theysaid')}}</span>
            </h2>
            <div
                class="testimonials-slider custom-slider"
                data-sal="slide-up"
                style="--sal-delay: 0.2s"
                >
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php $opinions = App\Opinon::get(); ?>
                        @foreach($opinions as $opinion)
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="testimonial-head">
                                    <div class="testimonial-platform">
                                        <img
                                            data-src="{{URL::to('upload/opinions/'.$opinion['image'])}}"
                                            class="img-fluid lazy-img"
                                            />                                
                                    </div>
                                    <div class="testimonial-user">
                                        <h3 class="user-name">{{$opinion[$lang."_title"]}}</h3>
                                    </div>
                                </div>
                                <p class="testimonial-review">
                                    {{$opinion[$lang."_desc"]}}
                                </p>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</section>
<!-- End Testimonials -->

<!-- Strat News -->
<section class="news-section">
    <div class="container">
        <div class="news-content">
            <h2 class="section-title" data-sal="slide-down">
                <span>{{trans('layout.blog')}}</span>
            </h2>
            <div
                class="news-slider custom-slider"
                data-sal="slide-up"
                style="--sal-delay: 0.15s"
                >
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php $servs = App\Blog::orderby('id', 'desc')->limit(3)->get(); ?>
                        @foreach($servs as $serv)

                        <div class="swiper-slide">
                            <div class="news-item">
                                <a href="{{URL::to('news/'.$serv['id'])}}/{{urlencode(strtolower($serv[$lang.'_title']))}}" class="news-img loading-img lazy-img-parent">
                                    <img
                                        data-src="{{URL::to('upload/news/'.$serv['image'])}}"
                                        class="img-fluid lazy-img"
                                        />
                                </a>
                                <div class="news-text">
                                    <div class="news-numbers">
                                        <span>
                                            <i class="fa-solid fa-calendar-alt"></i>
                                            {{$serv->created_at->toDateString()}}
                                        </span>
                                        <span>
                                            <i class="fa-solid fa-eye"></i>
                                            {{$serv['views']}}
                                        </span>
                                    </div>
                                    <h3 class="news-title">
                                        <a href="{{URL::to('news/'.$serv['id'])}}/{{urlencode(strtolower($serv[$lang.'_title']))}}">
                                            {{$serv[$lang.'_title']}}
                                        </a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        @endforeach



                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div
                class="section-more"
                data-sal="slide-down"
                style="--sal-delay: 0.3s"
                >
                <a href="{{URL::to('allnews')}}/{{trans('layout.blog')}}" class="main-btn"> {{trans('layout.readmore')}} </a>
            </div>
        </div>
    </div>
</section>
<!-- End News -->


@endsection