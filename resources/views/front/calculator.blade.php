@extends('front.layout')

@section('title', __('front.calculator'))
@section('description', __('front.calc_text'))

@section('content')
@include('front.partials.page-hero', ['title' => __('front.calc_title'), 'text' => __('front.calc_text'), 'crumbs' => [url($lang.'/calculator') => __('front.calculator')]])

@php
    $quote = session('quote');
    $visa = $items->get('visa', collect())->first();
    $shareholder = $items->get('shareholder', collect())->first();
    $old = fn ($key, $default = null) => old($key, $preset[$key] ?? $default);
    $titleOf = fn ($item) => $item->{$lang.'_title'};
@endphp

<section class="section" style="padding-top:48px">
    <div class="container">
        @if ($quote)
            {{-- Result after submitting --}}
            <div class="calc">
                <div class="calc-panel result">
                    <div class="result-icon"><i class="fa-solid fa-check"></i></div>
                    <h2>{{ __('front.thanks_title') }}</h2>
                    <p style="color:var(--muted);max-width:520px;margin-inline:auto">{{ __('front.thanks_text') }}</p>
                    @php
                        $wa = __('front.wa_quote_intro')."\n".collect($quote['lines'])
                            ->map(fn ($l) => '• '.__('front.lbl_'.$l['group']).': '.$l['title'])->implode("\n")
                            ."\n".__('front.your_estimate').': '.number_format($quote['estimate']).' '.$currency;
                        $waLink = rtrim($whatsapp, '/').'?text='.rawurlencode($wa);
                    @endphp
                    <div class="actions">
                        <a class="btn btn-wa" href="{{ $waLink }}" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> {{ __('front.send_on_whatsapp') }}</a>
                        <a class="btn btn-outline" href="{{ url($lang.'/calculator') }}"><i class="fa-solid fa-rotate-left"></i> {{ __('front.new_estimate') }}</a>
                    </div>
                </div>
                <aside class="summary" style="display:block">
                    <h3>{{ __('front.your_estimate') }}</h3>
                    <span class="price">{{ number_format($quote['estimate']) }}<span class="cur">{{ $currency }}</span></span>
                    <ul style="display:block">
                        @foreach ($quote['lines'] as $l)
                            <li><span>{{ __('front.lbl_'.$l['group']) }} · {{ $l['title'] }}</span><span class="ltr">{{ $l['price'] ? number_format($l['price']) : __('front.included') }}</span></li>
                        @endforeach
                    </ul>
                    <p class="note" style="display:block">{{ __('front.estimate_note') }}</p>
                </aside>
            </div>
        @else
            <form class="calc" id="calcForm" method="post" action="{{ url($lang.'/calculator') }}" novalidate
                  data-visa="{{ $visa->price ?? 0 }}" data-shareholder="{{ $shareholder->price ?? 0 }}" data-errors="{{ $errors->any() ? 1 : 0 }}">
                @csrf
                <div class="calc-panel">
                    <div class="progress">
                        <small>{{ __('front.calc_step') }} <span id="calcStepLabel">1</span> {{ __('front.calc_of') }} 6</small>
                        <div class="progress-bar"><span id="calcProgress"></span></div>
                    </div>

                    @foreach (['jurisdiction', 'activity'] as $group)
                        <div class="calc-step" data-require="{{ $group }}">
                            <h2>{{ __('front.q_'.$group) }}</h2>
                            <div class="choices">
                                @foreach ($items->get($group, []) as $item)
                                    <div class="choice">
                                        <input type="radio" name="{{ $group }}" id="{{ $group.$item->uuid }}" value="{{ $item->uuid }}"
                                               data-price="{{ $item->price }}" data-title="{{ $titleOf($item) }}" @checked($old($group) == $item->uuid)>
                                        <label for="{{ $group.$item->uuid }}">
                                            <b>{{ $titleOf($item) }}</b>
                                            @if ($item->{$lang.'_hint'})<small>{{ $item->{$lang.'_hint'} }}</small>@endif
                                            <span class="p">{{ $item->price ? '+ '.number_format($item->price).' '.$currency : __('front.included') }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <div class="calc-step">
                        <h2>{{ __('front.q_people') }}</h2>
                        <div class="people">
                            @foreach ([['visas', 0, 50, 1, $visa], ['shareholders', 1, 50, 1, $shareholder]] as [$name, $min, $max, $default, $item])
                                <div class="stepper-row">
                                    <span>
                                        {{ __('front.'.$name.'_count') }}
                                        @if ($item)<small>{{ number_format($item->price) }} {{ $currency }} — {{ $item->{$lang.'_hint'} ?? __('front.per_visa') }}</small>@endif
                                    </span>
                                    <div class="stepper">
                                        <button type="button" data-step="-1" aria-label="-"><i class="fa-solid fa-minus"></i></button>
                                        <output>{{ (int) $old($name, $default) }}</output>
                                        <input type="hidden" name="{{ $name }}" value="{{ (int) $old($name, $default) }}" min="{{ $min }}" max="{{ $max }}">
                                        <button type="button" data-step="1" aria-label="+"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="calc-step" data-require="office">
                        <h2>{{ __('front.q_office') }}</h2>
                        <div class="choices">
                            @foreach ($items->get('office', []) as $item)
                                <div class="choice">
                                    <input type="radio" name="office" id="office{{ $item->uuid }}" value="{{ $item->uuid }}"
                                           data-price="{{ $item->price }}" data-title="{{ $titleOf($item) }}" @checked($old('office') == $item->uuid)>
                                    <label for="office{{ $item->uuid }}">
                                        <b>{{ $titleOf($item) }}</b>
                                        @if ($item->{$lang.'_hint'})<small>{{ $item->{$lang.'_hint'} }}</small>@endif
                                        <span class="p">{{ $item->price ? '+ '.number_format($item->price).' '.$currency : __('front.included') }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="calc-step">
                        <h2>{{ __('front.q_extras') }}</h2>
                        <p style="color:var(--muted);margin-top:-12px">{{ __('front.extras_optional') }}</p>
                        <div class="choices">
                            @foreach ($items->get('extra', []) as $item)
                                <div class="choice">
                                    <input type="checkbox" name="extras[]" id="extra{{ $item->uuid }}" value="{{ $item->uuid }}"
                                           data-price="{{ $item->price }}" data-title="{{ $titleOf($item) }}" @checked(in_array($item->uuid, (array) old('extras', [])))>
                                    <label for="extra{{ $item->uuid }}">
                                        <b>{{ $titleOf($item) }}</b>
                                        <span class="p">+ {{ number_format($item->price) }} {{ $currency }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="calc-step">
                        <h2>{{ __('front.q_contact') }}</h2>
                        @if ($errors->has('jurisdiction') || $errors->has('activity') || $errors->has('office'))
                            <div class="alert" style="background:#fbeceb;color:#b4372b">{{ $errors->first('jurisdiction') ?: ($errors->first('activity') ?: $errors->first('office')) }}</div>
                        @endif
                        <div class="fields-2">
                            <div class="field">
                                <label for="c_name">{{ __('front.name') }}</label>
                                <input class="input" id="c_name" name="name" value="{{ old('name') }}" required autocomplete="name">
                                @error('name')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label for="c_phone">{{ __('front.phone') }}</label>
                                <input class="input ltr" id="c_phone" name="phone" type="tel" value="{{ old('phone') }}" required autocomplete="tel" placeholder="+971 5x xxx xxxx">
                                @error('phone')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="field">
                            <label for="c_email">{{ __('front.email') }}</label>
                            <input class="input" id="c_email" name="email" type="email" value="{{ old('email') }}" autocomplete="email">
                            @error('email')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="calc-nav">
                        <button type="button" class="btn btn-outline" data-prev><i class="fa-solid fa-arrow-left icon-flip"></i> {{ __('front.back') }}</button>
                        <button type="button" class="btn btn-dark" data-next>{{ __('front.next') }} <i class="fa-solid fa-arrow-right icon-flip"></i></button>
                        <button type="submit" class="btn btn-primary" data-submit hidden><i class="fa-solid fa-paper-plane"></i> {{ __('front.get_quote') }}</button>
                    </div>
                </div>

                <aside class="summary" id="calcSummary" data-empty="{{ __('front.not_selected') }}">
                    <div>
                        <h3>{{ __('front.your_estimate') }}</h3>
                        <span class="price"><span data-total>0</span><span class="cur">{{ $currency }}</span></span>
                    </div>
                    <ul>
                        @foreach (['jurisdiction', 'activity', 'visas', 'shareholders', 'office'] as $line)
                            <li data-line="{{ $line }}"><span>{{ __('front.lbl_'.$line) }}</span><span></span></li>
                        @endforeach
                        <li data-extras hidden><span>{{ __('front.lbl_extra') }}</span><span></span></li>
                    </ul>
                    <p class="note">{{ __('front.estimate_note') }}</p>
                </aside>
            </form>
        @endif
    </div>
</section>

<section class="section section--sand" style="padding-top:64px">
    <div class="container">
        <div class="section-head section-head--center">
            <span class="eyebrow">{{ __('front.support_eyebrow') }}</span>
            <h2>{{ __('front.support_title') }}</h2>
        </div>
        <div class="checklist">
            @foreach (\App\Models\Feature::orderBy('sort')->get() as $f)
                <div class="check"><i class="fa-solid fa-check"></i>{{ $f->{$lang.'_title'} }}</div>
            @endforeach
        </div>
    </div>
</section>
@endsection
