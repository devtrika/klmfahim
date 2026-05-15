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
<!-- Start Breadcrumb -->
<section
    class="breadcrumb-section"
    style="background-image: url({{url('interface')}}/images/breadcrumb.jpg)"
    >
    <div class="container">
        <div class="breadcrumb-content">
            <h1 class="page-title">{{$page[$lang.'_title']}}</h1>
            <!--            <ul class="breadcrumb-list">
                            <li>
                                <a href="index.html"> الرئيسية </a>
                            </li>
                            <li>
                                <a href="#!"> مشاريعنا </a>
                            </li>
                            <li>
                                <a href="project.html"> مشروع رقم 6 </a>
                            </li>
                        </ul>-->
        </div>
    </div>
</section>
<!-- End Breadcrumb -->

<section class="page-content">
    <div class="container">
        <div class="single-project">
            <div class="single-img text-center">
                <img src="{{URL::to('upload')}}/{{$type}}/{{$page['image']}}" style='max-height: 400px' class="img-fluid" />
            </div>
            <div class="single-content">
                <div class="main-info">
                    <h2 class="section-title">
                        <span> {{$page[$lang.'_title']}}</span>
                    </h2>
                    <p>
                        {!! $page[$lang.'_desc'] !!}
                    </p>
                </div>
                <!--                <div class="side-info">
                                    <h2 class="section-title">
                                        <span> تفاصيل المنتج </span>
                                    </h2>
                                    <div class="info-item">
                                        <strong class="info-title">اسم المشروع : </strong>
                                        <div>
                                            <div class="info-value">مشروع رقم 6</div>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <strong class="info-title">المميزات: </strong>
                                        <div>
                                            <div class="info-value">
                                                لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <strong class="info-title">اسم العميل : </strong>
                                        <div>
                                            <div class="info-value">احمد محمد</div>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <strong class="info-title">تاريخ الانتهاء : </strong>
                                        <div>
                                            <div class="info-value">6/11/2023</div>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <strong class="info-title">المشاركة : </strong>
                                        <div>
                                            <div class="info-share">
                                                <a href="#!" target="_blank" class="share">
                                                    <i class="fa-brands fa-pinterest"></i>
                                                </a>
                                                <a href="#!" target="_blank" class="share">
                                                    <i class="fa-brands fa-twitter"></i>
                                                </a>
                                                <a href="#!" target="_blank" class="share">
                                                    <i class="fa-brands fa-facebook"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
            </div>
        </div>

        <!--        <div class="related-projects">
                    <h2 class="section-title">
                        <span> المشاريع المشابهة </span>
                    </h2>
                    <div class="related-slider custom-slider">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="project-item">
                                        <a href="project.html" class="project-img">
                                            <div class="img-holder loading-img lazy-img-parent">
                                                <img
                                                    data-src="{{url('interface')}}/images/projects/1.jpg"
                                                    class="img-fluid lazy-img"
                                                    />
                                            </div>
                                        </a>
                                        <div class="project-text">
                                            <h3 class="project-name">
                                                <a href="project.html"> اسم مشروع تجريبى 1</a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="project-item">
                                        <a href="project.html" class="project-img">
                                            <div class="img-holder loading-img lazy-img-parent">
                                                <img
                                                    data-src="{{url('interface')}}/images/projects/2.jpg"
                                                    class="img-fluid lazy-img"
                                                    />
                                            </div>
                                        </a>
                                        <div class="project-text">
                                            <h3 class="project-name">
                                                <a href="project.html"> اسم مشروع تجريبى 2</a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="project-item">
                                        <a href="project.html" class="project-img">
                                            <div class="img-holder loading-img lazy-img-parent">
                                                <img
                                                    data-src="{{url('interface')}}/images/projects/4.jpg"
                                                    class="img-fluid lazy-img"
                                                    />
                                            </div>
                                        </a>
                                        <div class="project-text">
                                            <h3 class="project-name">
                                                <a href="project.html"> اسم مشروع تجريبى 4</a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="project-item">
                                        <a href="project.html" class="project-img">
                                            <div class="img-holder loading-img lazy-img-parent">
                                                <img
                                                    data-src="{{url('interface')}}/images/projects/5.jpg"
                                                    class="img-fluid lazy-img"
                                                    />
                                            </div>
                                        </a>
                                        <div class="project-text">
                                            <h3 class="project-name">
                                                <a href="project.html"> اسم مشروع تجريبى 5</a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>-->
    </div>
</section>
@endsection