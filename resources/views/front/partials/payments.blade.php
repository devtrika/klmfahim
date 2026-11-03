{{-- Accepted payment methods. $compact = badges only (no heading). --}}
<div @class(['pay', 'pay--compact' => $compact ?? false, 'pay--light' => $light ?? false])>
    @unless ($compact ?? false)
        <div class="pay-head">
            <i class="fa-solid fa-shield-halved"></i>
            <span><b>{{ __('front.pay_title') }}</b><small>{{ __('front.pay_note') }}</small></span>
        </div>
    @endunless
    <ul class="pay-list" aria-label="{{ __('front.pay_title') }}">
        <li class="pay-badge stripe" title="Stripe"><i class="fa-brands fa-stripe"></i></li>
        <li class="pay-badge tabby" title="Tabby">tabby</li>
        <li class="pay-badge tamara" title="Tamara">tamara</li>
        <li class="pay-badge" title="Visa"><i class="fa-brands fa-cc-visa" style="color:#1a1f71"></i></li>
        <li class="pay-badge" title="Mastercard"><i class="fa-brands fa-cc-mastercard" style="color:#eb001b"></i></li>
        <li class="pay-badge" title="Apple Pay"><i class="fa-brands fa-apple-pay" style="color:#000"></i></li>
    </ul>
</div>
