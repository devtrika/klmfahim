@extends('front.layout')

@section('content')
@php
    $icons = ['fa-solid fa-building-flag', 'fa-solid fa-city', 'fa-solid fa-earth-americas'];
    $defaultJ = $jurisdictions->first();
@endphp

{{-- Hero --}}
<section class="hero">
    <svg class="hero-dial" viewBox="0 0 400 400" aria-hidden="true">
        <defs>
            <linearGradient id="cu" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0" stop-color="#e2b89a"/><stop offset="1" stop-color="#8c5536"/>
            </linearGradient>
        </defs>
        <g class="dial-spin" fill="none">
            <circle cx="200" cy="200" r="190" stroke="rgba(255,255,255,.07)" stroke-width="1"/>
            <circle cx="200" cy="200" r="150" stroke="url(#cu)" stroke-width="18" stroke-dasharray="560 400" stroke-linecap="round" opacity=".55"/>
            <circle cx="200" cy="200" r="150" stroke="rgba(255,255,255,.12)" stroke-width="18" stroke-dasharray="300 660" stroke-dashoffset="-600" stroke-linecap="round"/>
            @for ($i = 0; $i < 60; $i++)
                <line x1="200" y1="14" x2="200" y2="{{ $i % 5 === 0 ? 30 : 22 }}" stroke="rgba(255,255,255,{{ $i % 5 === 0 ? '.3' : '.12' }})" stroke-width="2" transform="rotate({{ $i * 6 }} 200 200)"/>
            @endfor
        </g>
        <path d="M262 132 L214 236 L204 206 L170 230 Z" fill="url(#cu)" opacity=".8"/>
        <path d="M262 132 L214 236 L204 206 Z" fill="#2a2a2d" opacity=".9"/>
    </svg>

    <div class="container hero-grid">
        <div>
            <span class="eyebrow">{{ __('front.hero_eyebrow') }}</span>
            <h1>{!! __('front.hero_title') !!}</h1>
            <p class="hero-text">{{ __('front.hero_text') }}</p>
            <div class="hero-cta">
                <a href="{{ url($lang.'/calculator') }}" class="btn btn-primary"><i class="fa-solid fa-calculator"></i> {{ __('front.calculate_cost') }}</a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener" class="btn btn-ghost"><i class="fa-brands fa-whatsapp"></i> {{ __('front.free_consultation') }}</a>
            </div>
            <div class="hero-trust"><i class="fa-solid fa-shield-halved"></i> {{ __('front.hero_trust') }}</div>
        </div>

        @if ($jurisdictions->isNotEmpty())
        <form class="quick-card" id="quickEstimate" data-visa="{{ $visaPrice }}" onsubmit="return false">
            <h3><i class="fa-solid fa-bolt"></i> {{ __('front.quick_estimate') }}</h3>
            <p class="hint">{{ __('front.quick_estimate_hint') }}</p>
            <div class="seg" role="radiogroup">
                @foreach ($jurisdictions as $j)
                    <input type="radio" name="jurisdiction" id="qj{{ $j->uuid }}" value="{{ $j->uuid }}" data-price="{{ $j->price }}" @checked($loop->first)>
                    <label for="qj{{ $j->uuid }}">{{ $j->{$lang.'_title'} }}</label>
                @endforeach
            </div>
            <div class="stepper-row">
                <span>{{ __('front.visas') }}</span>
                <div class="stepper">
                    <button type="button" data-step="-1" aria-label="-"><i class="fa-solid fa-minus"></i></button>
                    <output>1</output>
                    <input type="hidden" name="visas" value="1" min="0" max="10">
                    <button type="button" data-step="1" aria-label="+"><i class="fa-solid fa-plus"></i></button>
                </div>
            </div>
            <div class="price-line">
                <small>{{ __('front.starting_from') }}</small>
                <span class="price"><span data-total>{{ number_format($defaultJ->price + $visaPrice) }}</span><span class="cur">{{ $currency }}</span></span>
            </div>
            <a class="btn btn-dark btn-block" data-link data-base="{{ url($lang.'/calculator') }}" href="{{ url($lang.'/calculator') }}">
                {{ __('front.full_breakdown') }} <i class="fa-solid fa-arrow-right icon-flip"></i>
            </a>
        </form>
        @endif
    </div>
</section>

{{-- Stats --}}
<section class="stats">
    <div class="container">
        <div class="stats-grid">
            @foreach (['base', 'branches', 'structure', 'mantis'] as $field)
                <div class="stat">
                    <b><span data-count="{{ (int) $site->$field }}">{{ number_format((int) $site->$field) }}</span><span>+</span></b>
                    <small>{{ __('front.stat_'.$field) }}</small>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Trusted by --}}
@if ($partners->isNotEmpty())
<section class="trusted">
    <div class="container">
        <h2>{{ __('front.trusted_title') }}</h2>
    </div>
    <div class="marquee">
        <div class="marquee-track">
            @foreach ([1, 2] as $pass)
                @foreach ($partners as $p)
                    <div class="partner" @if ($pass === 2) aria-hidden="true" @endif>
                        @if ($p->image && is_file(public_path('upload/clients/'.$p->image)))
                            <img src="{{ asset('upload/clients/'.$p->image) }}" alt="{{ $p->en_title }}" loading="lazy">
                        @else
                            <span class="partner-mark">{{ Str::upper(Str::substr(preg_replace('/[^A-Za-z]/', '', $p->en_title), 0, 2)) }}</span>
                            <span class="partner-name"><b>{{ $p->en_title }}</b><small>{{ $p->ar_title }}</small></span>
                        @endif
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Setup options --}}
@if ($jurisdictions->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">{{ __('front.options_eyebrow') }}</span>
            <h2>{{ __('front.options_title') }}</h2>
            <p>{{ __('front.options_text') }}</p>
        </div>
        <div class="options-grid">
            @foreach ($jurisdictions as $j)
                <article @class(['option reveal', 'is-featured' => $loop->first])>
                    @if ($loop->first)<span class="option-badge"><i class="fa-solid fa-star"></i></span>@endif
                    <div class="option-icon"><i class="{{ $icons[$loop->index] ?? 'fa-solid fa-building' }}"></i></div>
                    <h3>{{ $j->{$lang.'_title'} }}</h3>
                    <p>{{ $j->{$lang.'_hint'} }}</p>
                    <span class="from">{{ __('front.starting_from') }}</span>
                    <span class="price">{{ number_format($j->price) }}<span class="cur">{{ $currency }}</span></span>
                    <a href="{{ url($lang.'/calculator?jurisdiction='.$j->uuid) }}" @class(['btn', 'btn-primary' => $loop->first, 'btn-outline' => ! $loop->first])>
                        {{ __('front.calculate_cost') }} <i class="fa-solid fa-arrow-right icon-flip"></i>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Government services --}}
@if ($government->isNotEmpty())
<section class="section section--sand">
    <div class="container">
        @include('front.partials.government', ['services' => $government, 'showAllLink' => true])
    </div>
</section>
@endif

{{-- End-to-end support --}}
@if ($features->isNotEmpty())
<section class="section">
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

{{-- Services --}}
@if ($services->isNotEmpty())
<section class="section section--sand">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">{{ __('front.services_eyebrow') }}</span>
            <h2>{{ __('front.services_title') }}</h2>
            <p>{{ __('front.services_text') }}</p>
        </div>
        @include('front.partials.services-grid', ['services' => $services, 'gridId' => 'homeServices'])
    </div>
</section>
@endif

{{-- Process --}}
<section class="section section--dark">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">{{ __('front.process_eyebrow') }}</span>
            <h2>{{ __('front.process_title') }}</h2>
        </div>
        <div class="process">
            @foreach ([1, 2, 3, 4] as $n)
                <div class="step reveal">
                    <h3>{{ __('front.step'.$n.'_title') }}</h3>
                    <p>{{ __('front.step'.$n.'_text') }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Calculator CTA --}}
<section class="section">
    <div class="container">
        @include('front.partials.cta')
    </div>
</section>

{{-- Testimonials --}}
@if ($opinions->isNotEmpty())
<section class="section section--sand">
    <div class="container">
        <div class="section-head section-head--center reveal">
            <span class="eyebrow">{{ __('front.testimonials_eyebrow') }}</span>
            <h2>{{ __('front.testimonials_title') }}</h2>
        </div>
        <div class="cards-3 quotes-row">
            @foreach ($opinions as $o)
                <figure class="quote reveal">
                    <div class="quote-top">
                        <i class="fa-solid fa-quote-{{ $lang === 'ar' ? 'right' : 'left' }}"></i>
                        <span class="stars" aria-label="5/5">@for ($s = 0; $s < 5; $s++)<i class="fa-solid fa-star"></i>@endfor</span>
                    </div>
                    <blockquote class="quote-body">{!! strip_tags($o->{$lang.'_desc'}) !!}</blockquote>
                    <figcaption class="quote-who">
                        @if ($o->image && is_file(public_path('upload/opinions/'.$o->image)))
                            <img src="{{ asset('upload/opinions/'.$o->image) }}" alt="" loading="lazy">
                        @else
                            <span class="av">{{ Str::substr($o->{$lang.'_title'}, 0, 1) }}</span>
                        @endif
                        <b>{{ $o->{$lang.'_title'} }}</b>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Blog --}}
@if ($posts->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">{{ __('front.news_eyebrow') }}</span>
            <h2>{{ __('front.news_title') }}</h2>
        </div>
        <div class="cards-3">
            @foreach ($posts as $post)
                @include('front.partials.post-card', ['post' => $post])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Accepted payment methods --}}
<section class="pay-strip">
    <div class="container">
        @include('front.partials.payments', ['light' => true])
    </div>
</section>
@endsection
