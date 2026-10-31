@extends('front.layout')

@section('title', __('front.government'))
@section('description', __('front.gov_text'))

@section('content')
@include('front.partials.page-hero', ['title' => __('front.gov_title'), 'text' => __('front.gov_page_text'), 'crumbs' => [url($lang.'/government') => __('front.government')]])

<section class="section">
    <div class="container">
        @if ($services->isEmpty())
            <p>{{ __('front.no_items') }}</p>
        @else
            @include('front.partials.government', ['services' => $services, 'full' => true])
        @endif
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="container">@include('front.partials.cta')</div>
</section>
@endsection
