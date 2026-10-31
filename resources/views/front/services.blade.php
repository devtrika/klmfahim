@extends('front.layout')

@section('title', __('front.services'))
@section('description', __('front.services_text'))

@section('content')
@include('front.partials.page-hero', ['title' => __('front.services_title'), 'text' => __('front.services_text'), 'crumbs' => [url($lang.'/services') => __('front.services')]])

<section class="section">
    <div class="container">
        @if ($services->isEmpty())
            <p>{{ __('front.no_items') }}</p>
        @else
            @include('front.partials.services-grid', ['services' => $services, 'gridId' => 'allServices'])
        @endif
    </div>
</section>

@if ($features->isNotEmpty())
<section class="section section--sand">
    <div class="container">
        <div class="section-head section-head--center reveal">
            <span class="eyebrow">{{ __('front.support_eyebrow') }}</span>
            <h2>{{ __('front.support_title') }}</h2>
        </div>
        <div class="checklist">
            @foreach ($features as $f)
                <div class="check reveal"><i class="fa-solid fa-check"></i>{{ $f->{$lang.'_title'} }}</div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section">
    <div class="container">@include('front.partials.cta')</div>
</section>
@endsection
