@extends('front.layout')

@section('title', __('front.contact'))
@section('description', __('front.contact_text'))

@section('content')
@include('front.partials.page-hero', ['title' => __('front.contact_title'), 'text' => __('front.contact_text'), 'crumbs' => [url($lang.'/contact') => __('front.contact')]])

@php $phone = $site->mobile ?: $site->phone; @endphp
<section class="section">
    <div class="container contact-grid">
        <div>
            <div class="contact-list">
                <a class="contact-item" href="{{ $whatsapp }}" target="_blank" rel="noopener">
                    <i class="fa-brands fa-whatsapp"></i>
                    <span><small>{{ __('front.whatsapp') }}</small><b>{{ $phone }}</b></span>
                </a>
                <a class="contact-item" href="tel:{{ preg_replace('/\D+/', '', $phone) }}">
                    <i class="fa-solid fa-phone"></i>
                    <span><small>{{ __('front.call') }}</small><b>{{ $phone }}</b></span>
                </a>
                <a class="contact-item" href="mailto:{{ $site->email }}">
                    <i class="fa-solid fa-envelope"></i>
                    <span><small>{{ __('front.email') }}</small><b>{{ $site->email }}</b></span>
                </a>
                <div class="contact-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <span><small>{{ __('front.address') }}</small>{{ $site->{$lang.'_address'} }}</span>
                </div>
            </div>
            @if (Str::startsWith($site->lat, 'https://www.google.com/maps/embed'))
                <div class="map"><iframe src="{{ $site->lat }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="map"></iframe></div>
            @endif
        </div>

        <form class="calc-panel" method="post" action="{{ url($lang.'/contact') }}">
            @csrf
            @if (session('message'))
                <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('message') }}</div>
            @endif
            <div class="fields-2">
                @foreach (['name' => ['text', 'name'], 'phone' => ['tel', 'tel']] as $field => [$type, $auto])
                    <div class="field">
                        <label for="f_{{ $field }}">{{ __('front.'.$field) }}</label>
                        <input class="input" id="f_{{ $field }}" name="{{ $field }}" type="{{ $type }}" value="{{ old($field) }}" autocomplete="{{ $auto }}" required>
                        @error($field)<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                @endforeach
            </div>
            <div class="fields-2">
                <div class="field">
                    <label for="f_email">{{ __('front.email') }}</label>
                    <input class="input" id="f_email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="field">
                    <label for="f_title">{{ __('front.subject') }}</label>
                    <input class="input" id="f_title" name="title" value="{{ old('title') }}" required>
                    @error('title')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="field">
                <label for="f_message">{{ __('front.message') }}</label>
                <textarea class="input" id="f_message" name="message" required>{{ old('message') }}</textarea>
                @error('message')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="field">
                <label for="f_captcha">{{ __('front.captcha') }}</label>
                <div class="captcha-row">
                    <span data-captcha-img>{!! captcha_img() !!}</span>
                    <button type="button" data-captcha-reload="{{ url('reload-captcha') }}" aria-label="reload"><i class="fa-solid fa-rotate"></i></button>
                    <input class="input ltr" id="f_captcha" name="captcha" autocomplete="off" required>
                </div>
                @error('captcha')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <button class="btn btn-primary btn-block" type="submit"><i class="fa-solid fa-paper-plane"></i> {{ __('front.send') }}</button>
        </form>
    </div>
</section>
@endsection
