@extends('front.layout')

@section('title', $service->{$lang.'_title'})
@section('description', $service->{$lang.'_short'} ?: Str::limit(strip_tags($service->{$lang.'_desc'}), 155))

@section('content')
@include('front.partials.page-hero', [
    'title' => $service->{$lang.'_title'},
    'text' => $service->{$lang.'_short'},
    'crumbs' => [url($lang.'/services') => __('front.services')],
])

<section class="section">
    <div class="container article-grid">
        <article class="prose">
            @if ($service->image)
                <img src="{{ asset('upload/services/'.$service->image) }}" alt="{{ $service->{$lang.'_title'} }}">
            @endif
            {!! $service->{$lang.'_desc'} !!}
        </article>
        <aside class="aside-card">
            <span class="ico" style="width:52px;height:52px;border-radius:14px;background:var(--ink);color:var(--copper-2);display:grid;place-items:center;font-size:1.25rem;margin-bottom:16px">
                <i class="{{ $service->icon ?: 'fa-solid fa-briefcase' }}"></i>
            </span>
            <h3>{{ __('front.need_help') }}</h3>
            <p>{{ __('front.need_help_text') }}</p>
            <a class="btn btn-wa btn-block" target="_blank" rel="noopener"
               href="{{ rtrim($whatsapp, '/') }}?text={{ rawurlencode($service->{$lang.'_title'}) }}"><i class="fa-brands fa-whatsapp"></i> {{ __('front.whatsapp') }}</a>
            <a class="btn btn-dark btn-block" href="{{ url($lang.'/calculator') }}"><i class="fa-solid fa-calculator"></i> {{ __('front.calculate_cost') }}</a>
        </aside>
    </div>
</section>

@if ($related->isNotEmpty())
<section class="section section--sand">
    <div class="container">
        <div class="section-head">
            <h2>{{ __('front.related_services') }}</h2>
        </div>
        <div class="services-grid">
            @foreach ($related as $s)
                <a class="service-card reveal" href="{{ url($lang.'/services/'.$s->uuid.'/'.Str::slug($s->en_title)) }}">
                    <span class="ico"><i class="{{ $s->icon ?: 'fa-solid fa-briefcase' }}"></i></span>
                    <h3>{{ $s->{$lang.'_title'} }}</h3>
                    <p>{{ $s->{$lang.'_short'} }}</p>
                    <span class="more">{{ __('front.read_more') }} <i class="fa-solid fa-arrow-right icon-flip"></i></span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
