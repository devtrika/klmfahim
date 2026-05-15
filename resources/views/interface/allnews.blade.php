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
<!-- Strat News -->
<section class="news-section">
    <div class="container">
        <div class="news-content">
            <h2 class="section-title" data-sal="slide-down">
                <span>{{trans('layout.blog')}}</span>
            </h2>
            <div class="div-padding">
                <div class="container">

                    <div class="row">
                        <?php $allnews = App\Blog::orderby('id', 'desc')->paginate(12);
                        ?>
                        @foreach($allnews as $serv)
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 align-left wow fadeInUp">
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
                <div class="container">
                    <div class="row justify-content-center" >
                        <div class="col-sm-3  text-center">
                            {{$allnews->links("pagination::bootstrap-4")}}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- End News -->
@endsection