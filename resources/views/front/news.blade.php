@extends('front.layout')

@section('title', __('front.news'))

@section('content')
@include('front.partials.page-hero', ['title' => __('front.news_title'), 'crumbs' => [url($lang.'/news') => __('front.news')]])

<section class="section">
    <div class="container">
        @if ($posts->isEmpty())
            <p style="text-align:center;color:var(--muted)">{{ __('front.no_items') }}</p>
        @else
            <div class="cards-3">
                @foreach ($posts as $post)
                    @include('front.partials.post-card', ['post' => $post])
                @endforeach
            </div>
            <div style="margin-top:36px">{{ $posts->links() }}</div>
        @endif
    </div>
</section>
@endsection
