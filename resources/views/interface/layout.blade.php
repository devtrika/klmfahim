<!DOCTYPE html>
<?php
$lang = LaravelLocalization::getCurrentLocale();
//$lang ='ar';
$site = \App\Site::first();
if ($lang == 'ar') {
    $trans = 'en';
} else {
    $trans = 'ar';
}
?>
<html dir="{{$lang=='ar' ?'rtl':'ltr'}}" lang="{{$lang}}">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no"
            />
        <title>{{$site[$lang.'_title']}}</title>
        <meta name="author" content="{{$site[$lang.'_title']}}">
        <meta name="description" content="{{$site[$lang.'_desc']}}"/>
        <meta name="keywords" content="{{$site['tags']}}"/>
        <meta name="generator" content="Mohammed Reda Trika 00201007869353">
        <link rel="canonical" href="{{URL::to('/')}}" />
        <meta property="og:locale" content="{{$lang}}" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="{{$site[$lang.'_title']}}" />
        <meta property="og:description" content="{{$site['desc']}}" />
        <meta property="og:url" content="{{URL::to('/')}}" />
        <meta property="og:site_name" content="{{$site['title']}}" />
        <meta name="twitter:card" content="summary"/>
        <meta name="twitter:description" content="{{$site[$lang.'_desc']}}"/>
        <meta name="twitter:title" content="{{$site[$lang.'_title']}}"/>
        <meta name="twitter:domain" content="{{$site[$lang.'_title']}}"/>

        <link rel="shortcut icon" type="img/png" href="{{URL::to('/')}}/{{$site['logo']}}" />
        <style>
            :root {
                --primary-color: #ff8239;
                --secondary-color: #3274ff;
                --text-color: #333;
                --background-color: #f4f4f5;
                --border-radius: 30px;
                --border-color: #eeeeee;
            }
        </style>
        @if($lang == 'ar')
        <link rel="stylesheet" href="{{URL::to('interface')}}/css/bootstrap.rtl.min.css" />
        @else
        <link rel="stylesheet" href="{{URL::to('interface')}}/css/bootstrap.min.css" />

        @endif
        <link rel="stylesheet" href="{{URL::to('interface')}}/css/swiper-bundle.min.css" />
        <link rel="stylesheet" href="{{URL::to('interface')}}/css/fontawesome.min.css" />
        <link rel="stylesheet" href="{{URL::to('interface')}}/css/sal.css" />
        <link rel="stylesheet" href="{{URL::to('interface')}}/css/main.css" />
    </head>

    <body class="common-home overflow">
        <!-- Start Header -->
        <header>
            <div class="top-header">
                <div class="container">
                    <div class="bar-content">
                        <div class="news-marquee">
                            <h6 class="marquee-title">
                                <i class="fa-solid fa-newspaper"></i>
                                {{trans('layout.blog')}}                
                            </h6>
                            <div class="marquee-body">
                                <div class="marquee">
                                    <?php $servs = App\Blog::orderby('id', 'desc')->limit(3)->get(); ?>
                                    @foreach($servs as $serv)
                                    <a href="{{URL::to('news/'.$serv['id'])}}/{{urlencode(strtolower($serv[$lang.'_title']))}}">
                                        {{$serv[$lang.'_title']}}
                                    </a>
                                    <span>-</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                        <div class="header-links">
                            @if(LaravelLocalization::getCurrentLocale() == 'en')
                            <a href="{{ LaravelLocalization::getLocalizedURL('ar') }}" class="lang">العربية</a>
                            @else
                            <a href="{{ LaravelLocalization::getLocalizedURL('en') }}" class="lang">English</a>
                            @endif          
                            <div class="socials">
                                @if($site['facebook'])
                                <a href="{{$site['facebook']}}" target="_blank" class="social">
                                    <i class="fa-brands fa-facebook"></i>
                                </a>
                                @endif
                                @if($site['instagram'])
                                <a href="{{$site['instagram']}}" target="_blank" class="social">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                                @endif
                                @if($site['youtube'])
                                <a href="{{$site['youtube']}}" target="_blank" class="social">
                                    <i class="fa-brands fa-youtube"></i>
                                </a>
                                @endif
                                @if($site['twitter'])
                                <a href="{{$site['twitter']}}" target="_blank" class="social">
                                    <i class="fa-brands fa-x-twitter"></i>
                                </a>
                                @endif
                                @if($site['google'])
                                <a href="{{$site['google']}}" target="_blank" class="social">
                                    <i class="fa-brands fa-snapchat"></i>
                                </a>
                                @endif
                                @if($site['linkedin'])
                                <a href="{{$site['linkedin']}}" target="_blank" class="social">
                                    <i class="fa-brands fa-linkedin"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="header">
                    <a href="{{URL::to('/')}}" class="logo">
                        <img src="{{URL::to('/')}}/{{$site['logo']}}" style='height:60px' class="img-fluid" />
                    </a>
                    <div class="overlay"></div>
                    <nav class="header-nav">
                        <a role="button" class="close-btn">
                            <i class="fa-solid fa-times"></i>
                        </a>
                        <ul class="nav-list">
                            <li>
                                <a href="{{URL::to('/')}}"
                                   @if(Request::is('/') || Request::is('home'))class="active" @endif > {{trans('layout.home')}} </a>
                            </li>
                            <li class="has_children">
                                <a href="{{URL::to('allservices')}}/{{trans('layout.bestservices')}}" 
                                   @if(Request::is('allservices/*') || Request::is('service/*/*'))class="active" @endif  >
                                   {{trans('layout.services')}}
                                   <i class="fa-solid fa-chevron-down"></i>
                                </a>
                                <ul class="nav-sublist">
                                    <?php $servs = App\Service::orderby('id', 'desc')->get(); ?>
                                    @foreach($servs as $serv)
                                    <li>
                                        <a
                                            @if(Request::is('service/'.$serv['id'].'/*'))class="active" @endif 
                                            href="{{URL::to('service/'.$serv['id'])}}/{{urlencode(strtolower($serv[$lang.'_title']))}}">
                                            {{$serv[$lang.'_title']}}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <?php $servs = App\Page::orderby('id', 'desc')->where('dept', 'up')->get(); ?>
                        @foreach($servs as $serv)
                        <li>
                            <a 
                                @if(Request::is('page/'.$serv['id'].'/*'))class="active" @endif 
                                href="{{URL::to('page/'.$serv['id'])}}/{{urlencode(strtolower($serv[$lang.'_title']))}}">
                                {{$serv[$lang.'_title']}}
                        </a>
                    </li>
                    @endforeach
                    <li>

                        <a @if(Request::is('allnews/*') || Request::is('news/*/*'))class="active" @endif href="{{URL::to('allnews/'.trans('layout.blog'))}}"> {{trans('layout.blog')}} </a>
                    </li>
                    <li>
                        <a 
                            @if(Request::is('contactus/*') || Request::is('contactus/*/*'))class="active" @endif href="{{URL::to('contactus/'.trans('layout.contact'))}}">{{trans('layout.contact')}} </a>
                    </li>
                </ul>
                <div class="header-tools">
                    @if(LaravelLocalization::getCurrentLocale() == 'en')
                    <a href="{{ LaravelLocalization::getLocalizedURL('ar') }}" class="lang">العربية</a>
                    @else
                    <a href="{{ LaravelLocalization::getLocalizedURL('en') }}" class="lang">English</a>
                    @endif 
                </div>
                <div class="socials" id='div_socials'>
                    @if($site['facebook'])
                    <a href="{{$site['facebook']}}" target="_blank" class="social">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    @endif
                    @if($site['instagram'])
                    <a href="{{$site['instagram']}}" target="_blank" class="social">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    @endif
                    @if($site['youtube'])
                    <a href="{{$site['youtube']}}" target="_blank" class="social">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                    @endif
                    @if($site['twitter'])
                    <a href="{{$site['twitter']}}" target="_blank" class="social">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    @endif
                    @if($site['google'])
                    <a href="{{$site['google']}}" target="_blank" class="social">
                        <i class="fa-brands fa-snapchat"></i>
                    </a>
                    @endif
                    @if($site['linkedin'])
                    <a href="{{$site['linkedin']}}" target="_blank" class="social">
                        <i class="fa-brands fa-linkedin"></i>
                    </a>
                    @endif
                </div>
                <!--                        <div class="header-tools">
                                            <a href="{{URL::to('lang')}}" class="lang"> English </a>
                                            <a href="#!" class="header-btn main-btn">
                                                <i class="fa-solid fa-user"></i>
                                                <span class="text"> دخول الموظفين </span>
                                            </a>
                                        </div>-->
            </nav>
            <a role="button" class="menu-btn">
                <i class="fa-solid fa-bars"></i>
            </a>
        </div>
    </div>
</header>
<!-- End Header -->

@yield('content')
<!-- Start Footer -->
<footer style="background-image: url({{URL::to('interface')}}/images/footer.png)">
    <div class="container">
        <div class="footer">
            <div class="row">
                <div class="col-lg-4 text-center">
                    <div class="footer-info">
                        <div class="footer-logo">
                            <img src="{{URL::to('/')}}/{{$site['footer']}}" class="img-fluid" style='height:100px' />
                        </div>
                        <p class="footer-desc">
                            {{$site[$lang.'_footerword']}}
                        </p>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="footer-nav">
                        <h4 class="footer-title">{{trans('layout.fast_url')}}</h4>
                        <ul class="footer-list">
                            <li><a href="{{URL::to('/')}}"> {{trans('layout.home')}}</a></li>
                            <?php $servs = App\Page::orderby('id', 'desc')->where('dept', 'down')->get(); ?>
                            @foreach($servs as $serv)
                            <li>
                                <a href="{{URL::to('page/'.$serv['id'])}}/{{urlencode(strtolower($serv[$lang.'_title']))}}">
                                    {{$serv[$lang.'_title']}}
                                </a>
                            </li>
                            @endforeach                               
                            <li><a href="{{URL::to('contactus/'.trans('layout.contact'))}}"> {{trans('layout.contact')}}</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="footer-contacts">
                        <h4 class="footer-title">{{trans('layout.contact')}}</h4>
                        <ul class="footer-contacts-list">
                            <li>
                                <i class="fa-solid fa-location-dot"></i>
                                <h4>
                                    <span>{{trans('layout.address')}}</span>
                                    <span>{{$site[$lang.'_address']}}</span>
                                </h4>
                            </li>
                            <li>
                                <i class="fa-solid fa-envelope"></i>
                                <h4>
                                    <span>  {{trans('layout.email')}} : </span>
                                    <a href="mailto:{{$site['email']}} ">
                                        {{$site['email']}}                                            </a>
                                </h4>
                            </li>
                            <li>
                                <i class="fa-solid fa-mobile"></i>
                                <h4>
                                    <span> {{trans('layout.contact')}} : </span>
                                    <a href="tel:{{$site['mobile']}}"> {{$site['mobile']}}</a>

                                </h4>
                            </li>
                            <li>
                                <i class="fa-solid fa-phone"></i>
                                <h4>
                                    <span> {{trans('layout.contact')}}: </span>
                                    <a href="tel:{{$site['phone']}}"> {{$site['phone']}}</a>

                                </h4>
                            </li>

                        </ul>
                        <div class="socials">
                            @if($site['facebook'])
                            <a href="{{$site['facebook']}}" target="_blank" class="social">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                            @endif
                            @if($site['instagram'])
                            <a href="{{$site['instagram']}}" target="_blank" class="social">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            @endif
                            @if($site['youtube'])
                            <a href="{{$site['youtube']}}" target="_blank" class="social">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                            @endif
                            @if($site['twitter'])
                            <a href="{{$site['twitter']}}" target="_blank" class="social">
                                <i class="fa-brands fa-x-twitter"></i>
                            </a>
                            @endif
                            @if($site['google'])
                            <a href="{{$site['google']}}" target="_blank" class="social">
                                <i class="fa-brands fa-snapchat"></i>
                            </a>
                            @endif
                            @if($site['linkedin'])
                            <a href="{{$site['linkedin']}}" target="_blank" class="social">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="map">
<!--                                <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1855538.1861688872!2d47.94472407917842!3d24.72351491832893!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e2f03890d489399%3A0xba974d1c98e79fd5!2z2KfZhNix2YrYp9i2INin2YTYs9i52YjYr9mK2Kk!5e0!3m2!1sar!2seg!4v1571168802073!5m2!1sar!2seg"
                            frameborder="0"
                            style="border: 0"
                            allowfullscreen=""
                            ></iframe>-->
                        <iframe src="{{$site['lat']}}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p class="copyrights">{{trans('layout.allright')}} {{$site[$lang.'_title']}}</p>
</footer> 
<!-- End Footer -->

<div class="whats-fixed-btn">
    <a href="{{$site['whatsapp']}}" target="_blank">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
</div>
<div class="arrow-top">
    <i class="fa-solid fa-arrow-up"></i>
</div>
<script src="{{URL::to('interface')}}/js/jquery.min.js"></script>
<script src="{{URL::to('interface')}}/js/popper.min.js"></script>
<script src="{{URL::to('interface')}}/js/bootstrap.min.js"></script>
<script src="{{URL::to('interface')}}/js/swiper-bundle.min.js"></script>
<script src="{{URL::to('interface')}}/js/lazyload.js"></script>
<script src="{{URL::to('interface')}}/js/sal.js"></script>
<script src="{{URL::to('interface')}}/js/jquery.marquee.min.js"></script>
<script src="{{URL::to('interface')}}/js/main.js"></script>
<script>

function validAll() {
    if (document.getElementById("email").value && document.getElementById("name").value && document.getElementById("phone").value &&
            document.getElementById("message").value && document.getElementById("title").value && document.getElementById("captcha").value && validateEmail()) {
        document.getElementById("myForm").submit();
    } else {
        validOnblur("name");
        validOnblur("email");
        validOnblur("phone");
        validOnblur("title");
        validOnblur("message");
        validOnblur("captcha");


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
        case 'email':
            document.getElementById("email").value && validateEmail() ? document.getElementById("email").classList.remove("vald_txt") : document.getElementById("email").classList.add("vald_txt");
            // document.getElementById("email").value && validateEmail() ? document.getElementById("spn_email").classList.remove("vald_txt") : document.getElementById("spn_email").classList.add("vald_txt");
            break;
        case 'phone':
            document.getElementById("phone").value ? document.getElementById("phone").classList.remove("vald_txt") : document.getElementById("phone").classList.add("vald_txt");
            // document.getElementById("phone").value && validateEmail() ? document.getElementById("spn_phone").classList.remove("vald_txt") : document.getElementById("spn_phone").classList.add("vald_txt");
            break;
        case 'title':
            document.getElementById("title").value ? document.getElementById("title").classList.remove("vald_txt") : document.getElementById("title").classList.add("vald_txt");
            //   document.getElementById("title").value && validateEmail() ? document.getElementById("spn_title").classList.remove("vald_txt") : document.getElementById("spn_title").classList.add("vald_txt");
            break;
        case 'message':
            document.getElementById("message").value ? document.getElementById("message").classList.remove("vald_txt") : document.getElementById("message").classList.add("vald_txt");
//                document.getElementById("message").innerHTML? document.getElementById("spn_message").classList.remove("vald_txt") : document.getElementById("spn_message").classList.add("vald_txt");
            break;
        case 'captcha':
            document.getElementById("captcha").value ? document.getElementById("captcha").classList.remove("vald_txt") : document.getElementById("captcha").classList.add("vald_txt");
//                document.getElementById("msg").innerHTML? document.getElementById("spn_msg").classList.remove("vald_txt") : document.getElementById("spn_msg").classList.add("vald_txt");
            break;
    }
}
$('#reload').click(function () {
    $.ajax({
        type: 'GET',
        url: '/reload-captcha',
        success: function (data) {
            $("#spn_cpatch").html(data.captcha);
        }
    });
});
</script>
</body>
</html>