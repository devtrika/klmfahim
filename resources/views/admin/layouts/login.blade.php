@php $lang = LaravelLocalization::getCurrentLocale(); $site = \App\Models\Site::current(); @endphp
<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $site->{$lang.'_title'} }} · {{ trans('layout.admin') }}</title>
    <link rel="icon" type="image/png" href="{{ $site->logoUrl() }}">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin_panel/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_panel/vendor/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_panel/css/admin.css') }}?v={{ filemtime(public_path('admin_panel/css/admin.css')) }}">
</head>
<body class="cf-admin" style="display:grid;place-items:center;min-height:100vh;padding:24px">
    <div style="width:100%;max-width:420px">
        <a href="{{ url($lang) }}" style="display:block;text-align:center;margin-bottom:20px"><img src="{{ asset('brand/logo.png') }}" alt="{{ $site->{$lang.'_title'} }}" style="width:150px"></a>
        <div class="cf-card"><div class="cf-card-body" style="padding:26px">@yield('content')</div></div>
    </div>
</body>
</html>
