@php
    $lang = LaravelLocalization::getCurrentLocale();
    $site = \App\Models\Site::current();
@endphp
<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#1d1d1f">
    <title>{{ trans('layout.login') }} · {{ $site->{$lang.'_title'} }}</title>
    <link rel="icon" type="image/png" href="{{ asset('brand/mark.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front/vendor/fontawesome/css/fontawesome.min.css') }}">
    <style>
        :root { --ink: #1d1d1f; --ink-2: #2a2a2d; --copper: #b97a56; --copper-2: #d3a283; --copper-deep: #8c5536; --line: #e6ddd6; --muted: #6d6660; --sand: #f8f4f1; }
        * { box-sizing: border-box; }
        html, body { height: 100%; }
        body {
            margin: 0; color: var(--ink); background: var(--sand); -webkit-font-smoothing: antialiased;
            font-family: {!! $lang === 'ar' ? '"IBM Plex Sans Arabic", "Montserrat"' : '"Montserrat", "IBM Plex Sans Arabic"' !!}, system-ui, sans-serif;
        }
        .auth { min-height: 100%; display: grid; grid-template-columns: 1fr 1fr; }

        /* Brand side */
        .brand {
            position: relative; overflow: hidden; color: #f3eeea; padding: 48px;
            display: flex; flex-direction: column; justify-content: space-between;
            background: radial-gradient(700px 500px at 80% 10%, rgba(185, 122, 86, .3), transparent 60%), var(--ink);
        }
        .brand::after { content: ""; position: absolute; inset-inline-end: -160px; bottom: -160px; width: 460px; height: 460px; border-radius: 50%; border: 56px solid rgba(185, 122, 86, .12); }
        .brand img { width: 190px; position: relative; z-index: 1; }
        .brand h1 { font-size: clamp(1.8rem, 3vw, 2.6rem); line-height: 1.25; margin: 0 0 12px; position: relative; z-index: 1; }
        .brand h1 span { color: var(--copper-2); }
        .brand p { color: #b9b1ab; margin: 0; max-width: 420px; line-height: 1.7; position: relative; z-index: 1; }
        .brand small { color: #8f8781; position: relative; z-index: 1; }

        /* Form side */
        .panel { display: flex; align-items: center; justify-content: center; padding: 40px 24px; }
        .card { width: 100%; max-width: 400px; }
        .card .mark { display: none; width: 64px; height: 64px; margin-bottom: 18px; }
        .card h2 { font-size: 1.75rem; margin: 0 0 6px; }
        .card .sub { color: var(--muted); margin: 0 0 28px; line-height: 1.6; }
        .field { margin-bottom: 18px; }
        .field label { display: block; font-weight: 600; font-size: .92rem; margin-bottom: 8px; }
        .control { position: relative; }
        .control > i { position: absolute; top: 50%; transform: translateY(-50%); inset-inline-start: 16px; color: #a39b95; pointer-events: none; }
        .input {
            width: 100%; height: 52px; padding-inline: 46px 16px; border-radius: 14px; border: 1.5px solid var(--line);
            background: #fff; color: var(--ink); font: inherit; font-size: 16px; /* 16px stops iOS zooming on focus */
            transition: border-color .2s ease, box-shadow .2s ease;
        }
        .input:focus { outline: none; border-color: var(--copper); box-shadow: 0 0 0 4px rgba(185, 122, 86, .15); }
        .input[type=password], .input.has-toggle { padding-inline-end: 50px; }
        .toggle {
            position: absolute; top: 50%; transform: translateY(-50%); inset-inline-end: 6px; width: 40px; height: 40px;
            border: 0; background: transparent; color: var(--muted); border-radius: 10px; cursor: pointer; font-size: 1rem;
        }
        .toggle:hover { background: var(--sand); color: var(--ink); }
        .row { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin: 4px 0 24px; }
        .check { display: inline-flex; align-items: center; gap: 10px; cursor: pointer; user-select: none; font-size: .95rem; }
        .check input { width: 20px; height: 20px; margin: 0; accent-color: var(--copper); }
        .btn {
            width: 100%; height: 54px; border: 0; border-radius: 999px; cursor: pointer;
            background: var(--ink); color: #fff; font: inherit; font-size: 1.02rem; font-weight: 700;
            display: inline-flex; align-items: center; justify-content: center; gap: 10px;
            transition: background .2s ease, transform .2s ease;
        }
        .btn:hover { background: var(--copper-deep); }
        .btn:active { transform: scale(.99); }
        .alert { display: flex; gap: 10px; align-items: flex-start; padding: 13px 16px; border-radius: 14px; margin-bottom: 20px; background: #fbeceb; color: #b4372b; font-weight: 500; line-height: 1.5; }
        .foot { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-top: 28px; font-size: .9rem; }
        .foot a { color: var(--muted); text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .foot a:hover { color: var(--copper-deep); }

        @media (max-width: 900px) {
            .auth { grid-template-columns: 1fr; }
            .brand { display: none; }
            .panel { align-items: flex-start; padding: max(40px, env(safe-area-inset-top)) 20px 32px; }
            .card .mark { display: block; }
            .card h2 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <main class="auth">
        <section class="brand" aria-hidden="true">
            <img src="{{ asset('brand/logo-light.png') }}" alt="">
            <div>
                <h1>{!! $lang === 'ar' ? 'لوحة تحكم <span>كلم فهيم</span>' : 'The <span>Call Fahim</span> control panel' !!}</h1>
                <p>{{ $site->{$lang.'_slogan'} }}</p>
            </div>
            <small>© {{ date('Y') }} {{ $site->{$lang.'_title'} }}</small>
        </section>

        <section class="panel">
            <div class="card">
                <img class="mark" src="{{ asset('brand/mark.png') }}" alt="{{ $site->{$lang.'_title'} }}">
                <h2>{{ trans('layout.login') }}</h2>
                <p class="sub">{{ trans('layout.sign_in') }}</p>

                @if (Session::has('error'))
                    <div class="alert" role="alert"><i class="fa-solid fa-circle-exclamation" style="margin-top:3px"></i><span>{{ Session::get('error') }}</span></div>
                @endif

                <form action="{{ URL::to('trika/login') }}" method="post" novalidate>
                    @csrf
                    <div class="field">
                        <label for="username">{{ trans('layout.username') }}</label>
                        <div class="control">
                            <i class="fa-solid fa-user"></i>
                            <input class="input" id="username" name="username" value="{{ old('username') }}" required autofocus
                                   autocomplete="username" autocapitalize="none" spellcheck="false" dir="ltr">
                        </div>
                    </div>
                    <div class="field">
                        <label for="password">{{ trans('layout.password') }}</label>
                        <div class="control">
                            <i class="fa-solid fa-lock"></i>
                            <input class="input has-toggle" id="password" name="password" type="password" required autocomplete="current-password" dir="ltr">
                            <button class="toggle" type="button" aria-label="show password" onclick="var p=document.getElementById('password');var s=p.type==='password';p.type=s?'text':'password';this.firstElementChild.className=s?'fa-solid fa-eye-slash':'fa-solid fa-eye';">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <label class="check"><input type="checkbox" name="remember" @checked(old('remember'))> {{ trans('layout.remember') }}</label>
                    </div>
                    <button class="btn" type="submit"><i class="fa-solid fa-arrow-right-to-bracket{{ $lang === 'ar' ? ' fa-flip-horizontal' : '' }}"></i> {{ trans('layout.login') }}</button>
                </form>

                <div class="foot">
                    <a href="{{ url($lang) }}"><i class="fa-solid fa-arrow-{{ $lang === 'ar' ? 'right' : 'left' }}"></i> {{ trans('layout.website') }}</a>
                    <a href="{{ LaravelLocalization::getLocalizedURL($lang === 'ar' ? 'en' : 'ar') }}"><i class="fa-solid fa-globe"></i> {{ $lang === 'ar' ? 'English' : 'العربية' }}</a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
