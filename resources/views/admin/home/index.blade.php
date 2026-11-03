@extends('admin.layouts.shell')

@section('title', trans('layout.dashboard'))

@php
    $lang = LaravelLocalization::getCurrentLocale();
    $money = fn ($n) => number_format((float) $n);
    // Change against last month, as a signed percentage (null when there is nothing to compare).
    $delta = fn ($now, $before) => $before > 0 ? round(($now - $before) / $before * 100) : null;
@endphp

@section('content')
<div class="cf-hello">
    <div>
        <h1>{{ trans('layout.dashboard') }}</h1>
        <p>{{ trans('layout.dashboard_hint') }}</p>
    </div>
    <div class="cf-quick">
        @perm('invoices_add')<a class="btn btn-primary" href="{{ URL::to('trika/invoices/create') }}"><i class="fa fa-file-text"></i> {{ trans('layout.invoice_add') }}</a>@endperm
        @perm('services_add')<a class="btn btn-default" href="{{ URL::to('trika/services/create') }}"><i class="fa fa-plus"></i> {{ trans('layout.service_add') }}</a>@endperm
        @perm('calculator')<a class="btn btn-default" href="{{ URL::to('trika/calculator') }}"><i class="fa fa-calculator"></i> {{ trans('layout.calculator_items') }}</a>@endperm
    </div>
</div>

{{-- KPI row --}}
<div class="cf-kpis">
    @isset($invoices)
        @php $d = $delta($invoices['paid_month'], $invoices['paid_last_month']); @endphp
        <a class="cf-kpi dark" href="{{ URL::to('trika/invoices?status=paid') }}">
            <span class="cf-kpi-top">{{ trans('layout.kpi_revenue_month') }} <i class="fa fa-line-chart"></i></span>
            <b dir="ltr">{{ $money($invoices['paid_month']) }}<small>AED</small></b>
            <span class="sub">
                @if ($d !== null)<span style="color:{{ $d >= 0 ? '#7fd3a6' : '#f0a39b' }}">{{ $d >= 0 ? '▲' : '▼' }} {{ abs($d) }}%</span> {{ trans('layout.vs_last_month') }}
                @else {{ trans('layout.kpi_total') }}: <span dir="ltr">{{ $money($invoices['paid_total']) }} AED</span>@endif
            </span>
        </a>
        <a class="cf-kpi" href="{{ URL::to('trika/invoices?status=unpaid') }}">
            <span class="cf-kpi-top">{{ trans('layout.kpi_outstanding') }} <i class="fa fa-hourglass-half"></i></span>
            <b dir="ltr">{{ $money($invoices['unpaid']) }}<small>AED</small></b>
            <span class="sub">{{ $invoices['unpaid_count'] }} {{ trans('layout.status_unpaid') }}@if ($invoices['overdue_count']) · <span style="color:var(--red)">{{ $invoices['overdue_count'] }} {{ trans('layout.overdue') }}</span>@endif</span>
        </a>
    @endisset
    @isset($requests)
        @php $d = $delta($requests['month'], $requests['last_month']); @endphp
        <a class="cf-kpi" href="{{ URL::to('trika/requests') }}">
            <span class="cf-kpi-top">{{ trans('layout.kpi_requests_month') }} <i class="fa fa-inbox"></i></span>
            <b>{{ $requests['month'] }}@if ($requests['new'])<small>· {{ $requests['new'] }} {{ trans('layout.unseen') }}</small>@endif</b>
            <span class="sub">
                @if ($d !== null)<span style="color:{{ $d >= 0 ? 'var(--green)' : 'var(--red)' }}">{{ $d >= 0 ? '▲' : '▼' }} {{ abs($d) }}%</span> {{ trans('layout.vs_last_month') }}
                @else {{ trans('layout.kpi_total') }}: {{ $requests['total'] }}@endif
            </span>
        </a>
        <div class="cf-kpi">
            <span class="cf-kpi-top">{{ trans('layout.kpi_avg_quote') }} <i class="fa fa-calculator"></i></span>
            <b dir="ltr">{{ $money($requests['avg']) }}<small>AED</small></b>
            <span class="sub">{{ trans('layout.kpi_pipeline') }}: <span dir="ltr">{{ $money($requests['pipeline']) }} AED</span></span>
        </div>
    @endisset
    @if (! isset($invoices) && ! isset($requests))
        <div class="cf-kpi"><span class="cf-kpi-top">{{ trans('layout.services') }} <i class="fa fa-briefcase"></i></span><b>{{ $content['services']->sum() }}</b></div>
        <div class="cf-kpi"><span class="cf-kpi-top">{{ trans('layout.blog') }} <i class="fa fa-newspaper-o"></i></span><b>{{ $content['posts'] }}</b></div>
    @endif
</div>

{{-- Charts --}}
@if (isset($requests) || isset($invoices))
<div class="cf-grid">
    @isset($requests)
        <section class="cf-card">
            <div class="cf-card-head"><h3>{{ trans('layout.chart_requests') }}</h3><small>{{ trans('layout.last_30_days') }}</small></div>
            <div class="cf-card-body"><div class="cf-chart"><canvas id="chartRequests"></canvas></div></div>
        </section>
    @endisset
    @isset($invoices)
        <section class="cf-card">
            <div class="cf-card-head"><h3>{{ trans('layout.chart_revenue') }}</h3><small>{{ trans('layout.last_6_months') }}</small></div>
            <div class="cf-card-body"><div class="cf-chart"><canvas id="chartRevenue"></canvas></div></div>
        </section>
    @endisset
</div>
@endif

<div class="cf-grid">
    {{-- Latest quote requests --}}
    @isset($requests)
        <section class="cf-card">
            <div class="cf-card-head"><h3>{{ trans('layout.latest_requests') }}</h3><a href="{{ URL::to('trika/requests') }}">{{ trans('layout.show_all') }}</a></div>
            <div class="cf-card-body">
                @forelse ($requests['latest'] as $r)
                    @if ($loop->first)<ul class="cf-list">@endif
                    <li>
                        <span class="ic">{{ mb_substr($r->name, 0, 1) }}</span>
                        <a class="main" href="{{ URL::to('trika/requests/'.$r->uuid) }}">
                            <b>{{ $r->name }} @unless ($r->seen)<span class="cf-tag blue">{{ trans('layout.unseen') }}</span>@endunless</b>
                            <small dir="ltr" style="display:inline-block">{{ $r->phone }}</small> · <small>{{ $r->created_at->diffForHumans() }}</small>
                        </a>
                        <span class="end"><b dir="ltr">{{ $money($r->estimate) }}</b><small class="text-muted">AED</small></span>
                    </li>
                    @if ($loop->last)</ul>@endif
                @empty
                    <div class="cf-empty"><i class="fa fa-inbox"></i>{{ trans('layout.empty_requests') }}</div>
                @endforelse
            </div>
        </section>
    @endisset

    {{-- Most requested company types --}}
    @isset($requests)
        <section class="cf-card">
            <div class="cf-card-head"><h3>{{ trans('layout.top_types') }}</h3></div>
            <div class="cf-card-body">
                @php $max = max(1, (int) $requests['types']->max()); @endphp
                @forelse ($requests['types'] as $title => $count)
                    @if ($loop->first)<div class="cf-bars">@endif
                    <div class="cf-bar-row"><span>{{ $title }}</span><b>{{ $count }}</b><div class="track"><span style="width:{{ round($count / $max * 100) }}%"></span></div></div>
                    @if ($loop->last)</div>@endif
                @empty
                    <div class="cf-empty"><i class="fa fa-bar-chart"></i>{{ trans('layout.empty_types') }}</div>
                @endforelse
            </div>
        </section>
    @endisset
</div>

<div class="cf-grid-2">
    {{-- Latest invoices --}}
    @isset($invoices)
        <section class="cf-card">
            <div class="cf-card-head"><h3>{{ trans('layout.latest_invoices') }}</h3><a href="{{ URL::to('trika/invoices') }}">{{ trans('layout.show_all') }}</a></div>
            <div class="cf-card-body">
                @forelse ($invoices['latest'] as $inv)
                    @if ($loop->first)<ul class="cf-list">@endif
                    <li>
                        <span class="ic"><i class="fa fa-file-text-o"></i></span>
                        <a class="main" href="{{ URL::to('trika/invoices/'.$inv->uuid) }}">
                            <b dir="ltr" style="text-align:start">{{ $inv->number }}</b>
                            <small>{{ $inv->client_name }} · {{ $inv->issue_date->format('d/m/Y') }}</small>
                        </a>
                        <span class="end">
                            <b dir="ltr">{{ $money($inv->total) }}</b>
                            <span @class(['cf-tag', 'green' => $inv->status === 'paid', 'red' => $inv->status === 'cancelled', 'gray' => $inv->status === 'draft', 'blue' => $inv->status === 'unpaid'])>{{ trans('layout.status_'.$inv->status) }}</span>
                        </span>
                    </li>
                    @if ($loop->last)</ul>@endif
                @empty
                    <div class="cf-empty"><i class="fa fa-file-text-o"></i>{{ trans('layout.empty_invoices') }}</div>
                @endforelse
            </div>
        </section>
    @endisset

    {{-- Latest messages --}}
    @isset($messages)
        <section class="cf-card">
            <div class="cf-card-head"><h3>{{ trans('layout.latest_messages') }}</h3><a href="{{ URL::to('trika/contact') }}">{{ trans('layout.show_all') }}</a></div>
            <div class="cf-card-body">
                @forelse ($messages['latest'] as $m)
                    @if ($loop->first)<ul class="cf-list">@endif
                    <li>
                        <span class="ic">{{ mb_substr($m->name, 0, 1) }}</span>
                        <a class="main" href="{{ URL::to('trika/contact/'.$m->uuid.'/edit') }}">
                            <b>{{ $m->title ?: $m->name }} @if ($m->seen === 'no')<span class="cf-tag blue">{{ trans('layout.unseen') }}</span>@endif</b>
                            <small>{{ $m->name }} · {{ $m->created_at?->diffForHumans() }}</small>
                        </a>
                    </li>
                    @if ($loop->last)</ul>@endif
                @empty
                    <div class="cf-empty"><i class="fa fa-envelope-o"></i>{{ trans('layout.empty_messages') }}</div>
                @endforelse
            </div>
        </section>
    @endisset

    {{-- Site content at a glance --}}
    <section class="cf-card">
        <div class="cf-card-head"><h3>{{ trans('layout.site_content') }}</h3>@perm('site')<a href="{{ URL::to('trika/site') }}">{{ trans('layout.site') }}</a>@endperm</div>
        <div class="cf-card-body">
            <ul class="cf-list">
                @foreach (['setup' => 'fa-building', 'government' => 'fa-university', 'corporate' => 'fa-briefcase'] as $cat => $icon)
                    <li><span class="ic"><i class="fa {{ $icon }}"></i></span><span class="main"><b>{{ trans('layout.category_'.$cat) }}</b><small>{{ trans('layout.services') }}</small></span><span class="end"><b>{{ $content['services'][$cat] ?? 0 }}</b></span></li>
                @endforeach
                <li><span class="ic"><i class="fa fa-newspaper-o"></i></span><span class="main"><b>{{ trans('layout.blog') }}</b></span><span class="end"><b>{{ $content['posts'] }}</b></span></li>
                <li><span class="ic"><i class="fa fa-handshake-o"></i></span><span class="main"><b>{{ trans('layout.clients') }}</b></span><span class="end"><b>{{ $content['partners'] }}</b></span></li>
                <li><span class="ic"><i class="fa fa-paper-plane-o"></i></span><span class="main"><b>{{ trans('layout.newsletter') }}</b></span><span class="end"><b>{{ $content['subscribers'] }}</b></span></li>
            </ul>
        </div>
    </section>
</div>
@endsection

@push('scripts')
@if (isset($requests) || isset($invoices))
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
(function () {
    if (!window.Chart) return;
    var rtl = document.documentElement.dir === 'rtl';
    var font = getComputedStyle(document.body).fontFamily;
    Chart.defaults.font.family = font;
    Chart.defaults.color = '#7a726c';
    var grid = { color: '#efe8e2', drawTicks: false };
    var common = {
        responsive: true, maintainAspectRatio: false, layout: { padding: { left: 6, right: 6 } },
        plugins: { legend: { display: false }, tooltip: { rtl: rtl, backgroundColor: '#1d1d1f', padding: 10, cornerRadius: 10, displayColors: false } },
        scales: {
            x: { reverse: rtl, grid: { display: false }, ticks: { maxRotation: 0, autoSkipPadding: 14, padding: 6 } },
            y: { position: rtl ? 'right' : 'left', beginAtZero: true, grid: grid, border: { display: false }, ticks: { precision: 0, padding: 8 } }
        }
    };

    @isset($requests)
    var reqEl = document.getElementById('chartRequests');
    var ctx = reqEl.getContext('2d');
    var fill = ctx.createLinearGradient(0, 0, 0, 260);
    fill.addColorStop(0, 'rgba(185,122,86,.28)');
    fill.addColorStop(1, 'rgba(185,122,86,0)');
    new Chart(reqEl, {
        type: 'line',
        data: {
            labels: @json($requests['daily']->keys()->map(fn ($d) => \Illuminate\Support\Carbon::parse($d)->translatedFormat('j M'))),
            datasets: [{ data: @json($requests['daily']->values()), borderColor: '#b97a56', backgroundColor: fill, fill: true, tension: .3, cubicInterpolationMode: 'monotone', borderWidth: 2.5, pointRadius: 0, pointHoverRadius: 5, pointBackgroundColor: '#b97a56' }]
        },
        options: common
    });
    @endisset

    @isset($invoices)
    new Chart(document.getElementById('chartRevenue'), {
        type: 'bar',
        data: {
            labels: @json($invoices['monthly']->keys()),
            datasets: [{ data: @json($invoices['monthly']->values()), backgroundColor: '#1d1d1f', hoverBackgroundColor: '#b97a56', borderRadius: 8, maxBarThickness: 34 }]
        },
        options: Object.assign({}, common, {
            plugins: Object.assign({}, common.plugins, { tooltip: Object.assign({}, common.plugins.tooltip, { callbacks: { label: function (c) { return c.parsed.y.toLocaleString('en-US') + ' AED'; } } }) })
        })
    });
    @endisset
})();
</script>
@endif
@endpush
