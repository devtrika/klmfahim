@php
    $lang = LaravelLocalization::getCurrentLocale();
    $site = \App\Models\Site::current();
    $user = Auth::user();
    $path = trim(preg_replace('#^(ar|en)/#', '', request()->path()), '/');
    $newRequests = can_do('requests') ? \App\Models\CostRequest::where('seen', false)->count() : 0;
    $newMessages = can_do('contact') ? \App\Models\Contact::where('seen', 'no')->count() : 0;
    $badges = ['requests' => $newRequests, 'contact' => $newMessages];
    $modules = collect(config('permissions.modules'))->filter(fn ($m, $key) => can_do($key))->groupBy('section', true);
    $hour = (int) now()->format('G');
    $greeting = trans($hour < 12 ? 'layout.good_morning' : ($hour < 18 ? 'layout.good_afternoon' : 'layout.good_evening'));
@endphp
<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#1d1d1f">
    <title>@hasSection('title')@yield('title') · @endif{{ trans('layout.admin') }} · {{ $site->{$lang.'_title'} }}</title>
    <link rel="icon" type="image/png" href="{{ asset('brand/mark.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin_panel/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_panel/vendor/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css">
    <link rel="stylesheet" href="{{ asset('admin_panel/css/admin.css') }}?v={{ filemtime(public_path('admin_panel/css/admin.css')) }}">
    {{-- Loaded in <head> so inline page scripts can use $ right away. --}}
    <script src="{{ asset('admin_panel/vendor/jquery.min.js') }}"></script>
    @stack('head')
</head>
<body class="cf-admin">
    <aside class="cf-side" id="cfSide">
        <a class="cf-brand" href="{{ URL::to('trika') }}">
            <img src="{{ asset('brand/mark.png') }}" alt="">
            <span><b>Call Fahim</b><small>{{ trans('layout.admin') }}</small></span>
        </a>

        <nav class="cf-nav" aria-label="admin">
            <div @class(['cf-nav-item', 'is-active' => $path === 'trika'])>
                <a class="cf-link" href="{{ URL::to('trika') }}"><i class="fa fa-th-large"></i><span>{{ trans('layout.dashboard') }}</span></a>
            </div>

            @foreach (config('permissions.sections') as $section)
                @continue(! $modules->has($section))
                <div class="cf-nav-label">{{ trans('layout.'.$section) }}</div>
                @foreach ($modules[$section] as $key => $module)
                    @php $canAdd = in_array('add', $module['actions']) && can_do($key.'_add'); @endphp
                    <div @class(['cf-nav-item', 'is-active' => str_starts_with($path, $module['url'])])>
                        <a class="cf-link" href="{{ URL::to($module['url']) }}">
                            <i class="fa {{ $module['icon'] }}"></i><span>{{ trans('layout.'.$module['label']) }}</span>
                            @if ($badges[$key] ?? 0)<em class="cf-badge">{{ $badges[$key] }}</em>@endif
                        </a>
                        @if ($canAdd)
                            <a class="cf-add" href="{{ URL::to($module['url'].'/create') }}" title="{{ trans('layout.add') }}" aria-label="{{ trans('layout.add') }}"><i class="fa fa-plus"></i></a>
                        @endif
                    </div>
                @endforeach
            @endforeach
        </nav>

        <div class="cf-side-foot">
            <span class="cf-avatar">{{ mb_substr($user->name ?: 'A', 0, 1) }}</span>
            <span class="who"><b>{{ $user->name }}</b><small dir="ltr">{{ $user->username }}</small></span>
            <a class="cf-icon-btn" href="{{ URL::to('trika/logout') }}" title="{{ trans('layout.logout') }}" aria-label="{{ trans('layout.logout') }}"><i class="fa fa-sign-out"></i></a>
        </div>
    </aside>
    <div class="cf-scrim" data-side-close></div>

    <div class="cf-main">
        <header class="cf-top">
            <button class="cf-icon-btn cf-menu-btn" type="button" data-side-open aria-label="menu"><i class="fa fa-bars"></i></button>
            <div class="cf-greet">{{ $greeting }}، {{ \Illuminate\Support\Str::before($user->name, ' ') }}<small>{{ now()->translatedFormat('l j F Y') }}</small></div>

            <div class="cf-top-actions">
                <div class="cf-bell">
                    <button class="cf-icon-btn" type="button" data-dropdown="cfNotes" aria-label="notifications"><i class="fa fa-bell-o"></i></button>
                    @if ($newRequests + $newMessages)<span class="dot">{{ $newRequests + $newMessages }}</span>@endif
                    <div class="cf-dropdown" id="cfNotes" hidden>
                        @if ($newRequests)
                            <a href="{{ URL::to('trika/requests') }}"><i class="fa fa-inbox"></i><span><b>{{ $newRequests }} {{ trans('layout.requests_new') }}</b><small>{{ trans('layout.requests') }}</small></span></a>
                        @endif
                        @if ($newMessages)
                            <a href="{{ URL::to('trika/contact') }}"><i class="fa fa-envelope-o"></i><span><b>{{ $newMessages }} {{ trans('layout.new_messages') }}</b><small>{{ trans('layout.contact') }}</small></span></a>
                        @endif
                        @unless ($newRequests + $newMessages)
                            <div class="empty"><i class="fa fa-check-circle-o"></i> {{ trans('layout.all_caught_up') }}</div>
                        @endunless
                    </div>
                </div>
                <a class="cf-pill" href="{{ LaravelLocalization::getLocalizedURL($lang === 'ar' ? 'en' : 'ar') }}"><i class="fa fa-globe"></i><span class="txt">{{ $lang === 'ar' ? 'English' : 'العربية' }}</span></a>
                <a class="cf-pill" href="{{ URL::to($lang) }}" target="_blank" rel="noopener"><i class="fa fa-external-link"></i><span class="txt">{{ trans('layout.website') }}</span></a>
            </div>
        </header>

        <main class="cf-content">
            @yield('content')
        </main>

        <footer class="cf-foot">
            <span>© {{ date('Y') }} {{ $site->{$lang.'_title'} }}</span>
            <a href="https://enter-hash.com/{{ $lang }}" target="_blank" rel="noopener" style="color:inherit">EnterHash</a>
        </footer>
    </div>

    <script src="{{ asset('admin_panel/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
    <script>
    (function () {
        var rtl = document.documentElement.dir === 'rtl';
        var body = document.body;

        // Mobile sidebar
        document.querySelectorAll('[data-side-open]').forEach(function (b) { b.addEventListener('click', function () { body.classList.add('cf-side-open'); }); });
        document.querySelectorAll('[data-side-close]').forEach(function (b) { b.addEventListener('click', function () { body.classList.remove('cf-side-open'); }); });

        // Dropdowns
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-dropdown]');
            document.querySelectorAll('.cf-dropdown').forEach(function (d) {
                if (!btn || d.id !== btn.dataset.dropdown) { if (!d.contains(e.target)) d.hidden = true; }
            });
            if (btn) { var d = document.getElementById(btn.dataset.dropdown); d.hidden = !d.hidden; }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { body.classList.remove('cf-side-open'); document.querySelectorAll('.cf-dropdown').forEach(function (d) { d.hidden = true; }); }
        });

        // Dismissible alerts (replaces Bootstrap's JS)
        document.addEventListener('click', function (e) {
            var x = e.target.closest('[data-dismiss="alert"]');
            if (x) { var a = x.closest('.alert'); if (a) a.remove(); }
        });

        // Data tables: search + paging, newest first is up to each table's order
        if (window.jQuery && $.fn.DataTable) {
            $('table#example, table.data-table').each(function () {
                if ($.fn.DataTable.isDataTable(this)) return;
                $(this).DataTable({
                    pageLength: 25,
                    order: [],
                    autoWidth: false,
                    dom: '<"cf-dt-top"lf>rt<"cf-dt-bottom"ip>',
                    language: rtl ? {
                        search: '', searchPlaceholder: 'بحث…', lengthMenu: 'عرض _MENU_',
                        info: '_START_–_END_ من _TOTAL_', infoEmpty: '0 نتائج', infoFiltered: '(من _MAX_)',
                        zeroRecords: 'لا توجد نتائج', emptyTable: 'لا توجد بيانات بعد',
                        paginate: { previous: '›', next: '‹' }
                    } : {
                        search: '', searchPlaceholder: 'Search…', lengthMenu: 'Show _MENU_',
                        info: '_START_–_END_ of _TOTAL_', infoEmpty: '0 results', infoFiltered: '(of _MAX_)',
                        zeroRecords: 'No matching records', emptyTable: 'Nothing here yet',
                        paginate: { previous: '‹', next: '›' }
                    }
                });
            });
        }

        // Rich text editors
        if (window.jQuery && $.fn.summernote) {
            $('.cf-content textarea:not([data-plain])').summernote({
                height: 220,
                toolbar: [['style', ['bold', 'italic', 'underline', 'clear']], ['para', ['ul', 'ol', 'paragraph']], ['insert', ['link']], ['view', ['codeview']]]
            });
        }
    })();
    </script>
    @yield('scripts')
    @stack('scripts')
</body>
</html>
