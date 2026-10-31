@extends('front.layout')

@section('title', $item->{$lang.'_title'})
@section('description', Str::limit(strip_tags($item->{$lang.'_desc'}), 155))

@section('content')
@include('front.partials.page-hero', [
    'title' => $item->{$lang.'_title'},
    'crumbs' => $kind === 'news' ? [url($lang.'/news') => __('front.news')] : [],
])

<section class="section">
    <div class="container article-grid">
        <article class="prose">
            @if ($item->image)
                <img src="{{ asset('upload/'.($kind === 'news' ? 'news' : 'pages').'/'.$item->image) }}" alt="{{ $item->{$lang.'_title'} }}">
            @endif
            {!! $item->{$lang.'_desc'} !!}
        </article>
        <aside class="aside-card">
            <h3>{{ __('front.cta_title') }}</h3>
            <p>{{ __('front.cta_text') }}</p>
            <a class="btn btn-primary btn-block" href="{{ url($lang.'/calculator') }}"><i class="fa-solid fa-calculator"></i> {{ __('front.calculate_cost') }}</a>
            <a class="btn btn-wa btn-block" href="{{ $whatsapp }}" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> {{ __('front.whatsapp') }}</a>
        </aside>
    </div>
</section>
@endsection
