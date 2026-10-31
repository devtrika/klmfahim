<div class="cta-band reveal">
    <div>
        <h2>{{ __('front.cta_title') }}</h2>
        <p>{{ __('front.cta_text') }}</p>
    </div>
    <div class="actions">
        <a href="{{ url($lang.'/calculator') }}" class="btn btn-dark"><i class="fa-solid fa-calculator"></i> {{ __('front.calculate_cost') }}</a>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener" class="btn btn-wa"><i class="fa-brands fa-whatsapp"></i> {{ __('front.whatsapp') }}</a>
    </div>
</div>
