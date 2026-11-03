<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#1d1d1f">
    <title>@hasSection('title')@yield('title') · @endif{{ $site->{$lang.'_title'} }} — {{ $site->{$lang.'_slogan'} }}</title>
    <meta name="description" content="@yield('description', $site->{$lang.'_footerword'})">
    <meta name="keywords" content="{{ $site->tags }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="{{ $otherLang }}" href="{{ LaravelLocalization::getLocalizedURL($otherLang) }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="{{ $lang === 'ar' ? 'ar_AE' : 'en_AE' }}">
    <meta property="og:site_name" content="{{ $site->{$lang.'_title'} }}">
    <meta property="og:title" content="@yield('title', $site->{$lang.'_title'})">
    <meta property="og:description" content="@yield('description', $site->{$lang.'_footerword'})">
    <meta property="og:image" content="{{ asset('brand/logo.png') }}">
    <link rel="icon" type="image/png" href="{{ $site->logoUrl() }}">
    <link rel="apple-touch-icon" href="{{ $site->logoUrl() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front/vendor/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/app.css') }}?v={{ filemtime(public_path('front/css/app.css')) }}">
    @stack('head')
</head>
<body>
    @php
        $path = trim(preg_replace('#^'.$lang.'/?#', '', request()->path()), '/');
        $active = fn (string $prefix) => $prefix === '' ? $path === '' : str_starts_with($path, $prefix);
        $nav = [
            ['', 'front.home', 'fa-house'],
            ['services', 'front.services', 'fa-briefcase'],
            ['government', 'front.government', 'fa-landmark'],
            ['calculator', 'front.calculator', 'fa-calculator'],
            ['news', 'front.news', 'fa-newspaper'],
            ['contact', 'front.contact', 'fa-envelope'],
        ];
        $phone = $site->mobile ?: $site->phone;
        // CMS pages: "up" ones go in the header, "up" and "down" ones in the footer.
        $cmsPages = \App\Models\Page::whereIn('dept', ['up', 'down'])->orderBy('id')->get(['id', 'uuid', 'dept', 'ar_title', 'en_title']);
        $headerPages = $cmsPages->where('dept', 'up');
        $pageUrl = fn ($p) => url($lang.'/page/'.$p->uuid.'/'.Str::slug($p->en_title));
        $onPage = fn ($p) => $path === 'page/'.$p->uuid || str_starts_with($path, 'page/'.$p->uuid.'/');
        // The logo text stays English in both languages (site settings, English fields); last word bold.
        $brandWords = explode(' ', trim($site->en_title ?: 'Call Fahim'));
        $brandLast = array_pop($brandWords);
        $brandName = ($brandWords ? e(implode(' ', $brandWords)).' ' : '').'<b>'.e($brandLast).'</b>';
    @endphp

    <header class="site-header" id="siteHeader">
        <div class="container header-inner">
            <a href="{{ url($lang) }}" class="brand" aria-label="{{ $site->{$lang.'_title'} }}">
                <img src="{{ $site->logoUrl() }}" alt="" width="46" height="46">
                <span class="brand-text">
                    <span class="brand-name">{!! $brandName !!}</span>
                    @if ($site->en_slogan)<span class="brand-tag">{{ $site->en_slogan }}</span>@endif
                </span>
            </a>

            <nav class="main-nav" aria-label="{{ __('front.menu') }}">
                @foreach ($nav as [$href, $label])
                    <a href="{{ url($lang.($href ? '/'.$href : '')) }}" @class(['is-active' => $active($href)])>{{ __($label) }}</a>
                    @if ($href === '' && $headerPages->count() === 1)
                        @php $p = $headerPages->first(); @endphp
                        <a href="{{ $pageUrl($p) }}" @class(['is-active' => $onPage($p)])>{{ $p->{$lang.'_title'} }}</a>
                    @elseif ($href === '' && $headerPages->count() > 1)
                        <div class="nav-drop">
                            <button type="button" @class(['is-active' => $headerPages->contains($onPage)]) aria-haspopup="true">{{ __('front.company') }} <i class="fa-solid fa-chevron-down"></i></button>
                            <div class="nav-drop-menu">
                                @foreach ($headerPages as $p)
                                    <a href="{{ $pageUrl($p) }}">{{ $p->{$lang.'_title'} }}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </nav>

            <div class="header-actions">
                <a class="lang-switch" href="{{ LaravelLocalization::getLocalizedURL($otherLang) }}" hreflang="{{ $otherLang }}">
                    <i class="fa-solid fa-globe"></i> <span class="lang-long">{{ __('front.switch_lang') }}</span><span class="lang-short">{{ $otherLang === 'ar' ? 'ع' : 'EN' }}</span>
                </a>
                <a class="btn btn-primary btn-sm" href="{{ url($lang.'/calculator') }}">
                    <i class="fa-solid fa-calculator"></i> {{ __('front.calculate_cost') }}
                </a>
                <button class="menu-toggle" type="button" data-drawer-open aria-label="{{ __('front.menu') }}">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
            </div>
        </div>
    </header>

    <div class="drawer" id="drawer" aria-hidden="true">
        <div class="drawer-backdrop" data-drawer-close></div>
        <aside class="drawer-panel">
            <div class="drawer-head">
                <a href="{{ url($lang) }}" class="brand">
                    <img src="{{ $site->logoUrl() }}" alt="" width="40" height="40">
                    <span class="brand-text"><span class="brand-name">{!! $brandName !!}</span></span>
                </a>
                <button class="menu-toggle" style="display:inline-flex" type="button" data-drawer-close aria-label="close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            @foreach ($nav as [$href, $label, $icon])
                <a href="{{ url($lang.($href ? '/'.$href : '')) }}" @class(['is-active' => $active($href)])>
                    <i class="fa-solid {{ $icon }}"></i> {{ __($label) }}
                </a>
            @endforeach
            @foreach ($headerPages as $p)
                <a href="{{ $pageUrl($p) }}" @class(['is-active' => $onPage($p)])><i class="fa-solid fa-circle-info"></i> {{ $p->{$lang.'_title'} }}</a>
            @endforeach
            <a href="{{ LaravelLocalization::getLocalizedURL($otherLang) }}"><i class="fa-solid fa-globe"></i> {{ __('front.switch_lang') }}</a>
            <a class="btn btn-primary btn-block" href="{{ url($lang.'/calculator') }}"><i class="fa-solid fa-calculator"></i> {{ __('front.calculate_cost') }}</a>
            <div class="drawer-foot">
                <div class="ltr">{{ $phone }}</div>
                <div>{{ $site->email }}</div>
            </div>
        </aside>
    </div>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <img class="footer-logo" src="{{ $site->footerLogoUrl() }}" alt="{{ $site->{$lang.'_title'} }}" loading="lazy">
                    <p>{{ $site->{$lang.'_footerword'} }}</p>
                    <div class="socials">
                        @foreach (['facebook' => 'facebook-f', 'instagram' => 'instagram', 'linkedin' => 'linkedin-in', 'twitter' => 'x-twitter', 'youtube' => 'youtube'] as $field => $icon)
                            @if ($site->$field && ! preg_match('#\.com/+$#', $site->$field))
                                <a href="{{ $site->$field }}" target="_blank" rel="noopener" aria-label="{{ $field }}"><i class="fa-brands fa-{{ $icon }}"></i></a>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div>
                    <h4>{{ __('front.quick_links') }}</h4>
                    <ul>
                        @foreach ($nav as [$href, $label])
                            <li><a href="{{ url($lang.($href ? '/'.$href : '')) }}">{{ __($label) }}</a></li>
                        @endforeach
                        @foreach ($cmsPages as $p)
                            <li><a href="{{ $pageUrl($p) }}">{{ $p->{$lang.'_title'} }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4>{{ __('front.services') }}</h4>
                    <ul>
                        @foreach (\App\Models\Service::orderBy('sort')->limit(5)->get() as $s)
                            <li><a href="{{ url($lang.'/services/'.$s->uuid.'/'.Str::slug($s->en_title)) }}">{{ $s->{$lang.'_title'} }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4>{{ __('front.contact') }}</h4>
                    <ul>
                        <li><i class="fa-solid fa-location-dot"></i> {{ $site->{$lang.'_address'} }}</li>
                        <li><a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}" class="ltr"><i class="fa-solid fa-phone"></i> {{ $phone }}</a></li>
                        <li><a href="mailto:{{ $site->email }}"><i class="fa-solid fa-envelope"></i> {{ $site->email }}</a></li>
                        <li><a href="{{ $whatsapp }}" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> {{ __('front.whatsapp') }}</a></li>
                    </ul>
                </div>
            </div>
            @unless ($active('')) @include('front.partials.payments') @endunless
            <div class="footer-bottom" style="margin-top:0">
                <span>© {{ date('Y') }} {{ $site->{$lang.'_title'} }} — {{ __('front.rights') }}</span>
                <a class="credit" href="https://enter-hash.com/{{ $lang }}" target="_blank" rel="noopener">
                    {{ __('front.made_by') }}
                    <span class="credit-mark" dir="ltr"><span>Enter<b>Hash</b></span> <code>&lt;build/&gt;</code></span>
                </a>
            </div>
        </div>
    </footer>

    <a class="wa-float" href="{{ $whatsapp }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>

    <nav class="mobile-bar" aria-label="mobile">
        <a href="{{ url($lang) }}" @class(['is-active' => $active('')])><i class="fa-solid fa-house"></i><span class="label">{{ __('front.home') }}</span></a>
        <a href="{{ url($lang.'/services') }}" @class(['is-active' => $active('services')])><i class="fa-solid fa-briefcase"></i><span class="label">{{ __('front.services') }}</span></a>
        <a href="{{ $whatsapp }}" class="wa-center" target="_blank" rel="noopener"><span class="bubble"><i class="fa-brands fa-whatsapp"></i></span><span class="label">{{ __('front.whatsapp') }}</span></a>
        <a href="{{ url($lang.'/calculator') }}" @class(['is-active' => $active('calculator')])><i class="fa-solid fa-calculator"></i><span class="label">{{ __('front.bar_calculator') }}</span></a>
        <a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}"><i class="fa-solid fa-phone"></i><span class="label">{{ __('front.call') }}</span></a>
    </nav>

    <script src="{{ asset('front/js/app.js') }}?v={{ filemtime(public_path('front/js/app.js')) }}" defer></script>
    @stack('scripts')
</body>
</html>
