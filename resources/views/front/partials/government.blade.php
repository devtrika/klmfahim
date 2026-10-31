{{-- Government transactions block: pitch + why-us on one side, service tiles on the other. --}}
<div class="gov">
    <div class="gov-intro reveal">
        <span class="eyebrow">{{ __('front.gov_eyebrow') }}</span>
        <h2>{{ __('front.gov_title') }}</h2>
        <p>{{ __('front.gov_text') }}</p>
        <ul class="why">
            @foreach ([['fa-user-tie', 1], ['fa-bolt', 2], ['fa-mobile-screen', 3], ['fa-landmark', 4]] as [$icon, $n])
                <li><i class="fa-solid {{ $icon }}"></i><span><b>{{ __('front.why'.$n.'_title') }}</b>{{ __('front.why'.$n.'_text') }}</span></li>
            @endforeach
        </ul>
        @if ($showAllLink ?? false)
            <a href="{{ url($lang.'/government') }}" class="btn btn-primary">{{ __('front.all_gov_services') }} <i class="fa-solid fa-arrow-right icon-flip"></i></a>
        @else
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener" class="btn btn-wa"><i class="fa-brands fa-whatsapp"></i> {{ __('front.whatsapp') }}</a>
        @endif
    </div>
    <div class="gov-grid">
        @foreach ($services as $s)
            <a class="gov-tile reveal" href="{{ url($lang.'/services/'.$s->uuid.'/'.Str::slug($s->en_title)) }}">
                <i class="{{ $s->icon ?: 'fa-solid fa-landmark' }}"></i>
                <span>
                    <b>{{ $s->{$lang.'_title'} }}</b>
                    @if ($full ?? false)<small>{{ $s->{$lang.'_short'} }}</small>@endif
                </span>
            </a>
        @endforeach
    </div>
</div>
