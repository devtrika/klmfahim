@php
    $lang = LaravelLocalization::getCurrentLocale();
    $money = fn ($n) => number_format((float) $n, 2);
    $phone = $site->mobile ?: $site->phone;
@endphp
<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $invoice->number }} — {{ $invoice->client_name }}</title>
    <link rel="icon" href="{{ asset('brand/mark.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front/vendor/fontawesome/css/fontawesome.min.css') }}">
    <style>
        :root { --ink: #1d1d1f; --copper: #b97a56; --copper-deep: #8c5536; --copper-3: #f6ebe4; --line: #ebe3dd; --muted: #6d6660; --sand: #f6f3f0; }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--sand); color: var(--ink); font-family: {!! $lang === 'ar' ? '"IBM Plex Sans Arabic", "Montserrat"' : '"Montserrat", "IBM Plex Sans Arabic"' !!}, sans-serif; font-size: 14px; line-height: 1.6; }
        .toolbar { max-width: 210mm; margin: 24px auto 0; display: flex; gap: 8px; flex-wrap: wrap; padding: 0 12px; }
        .toolbar a, .toolbar button { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 999px; border: 1px solid var(--line); background: #fff; color: var(--ink); font: inherit; font-weight: 600; cursor: pointer; text-decoration: none; }
        .toolbar .primary { background: var(--ink); color: #fff; border-color: var(--ink); }
        .toolbar .wa { background: #25d366; color: #fff; border-color: #25d366; }
        .toolbar .spacer { flex: 1; }
        .flash { max-width: 210mm; margin: 12px auto 0; padding: 10px 16px; background: #e9f6ef; color: #2f8f5b; border-radius: 12px; }
        .sheet { width: 210mm; min-height: 297mm; margin: 16px auto 40px; background: #fff; padding: 16mm 15mm; box-shadow: 0 20px 60px -30px rgba(0,0,0,.35); position: relative; overflow: hidden; }
        .sheet > *:not(footer) { position: relative; z-index: 1; }
        .sheet > footer { z-index: 1; }
        .sheet::before { content: ""; position: absolute; z-index: 0; inset-inline-end: -60mm; top: -60mm; width: 140mm; height: 140mm; border-radius: 50%; border: 18mm solid var(--copper-3); opacity: .7; }
        header { display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; position: relative; }
        .brand img { width: 150px; }
        .title { text-align: end; }
        .title h1 { margin: 0; font-family: "Montserrat", sans-serif; font-size: 30px; letter-spacing: .06em; text-transform: uppercase; }
        .title .sub { color: var(--copper-deep); font-weight: 700; font-size: 16px; }
        .status { display: inline-block; margin-top: 8px; padding: 4px 14px; border-radius: 999px; font-weight: 700; font-size: 12px; background: var(--copper-3); color: var(--copper-deep); }
        .status.paid { background: #e9f6ef; color: #2f8f5b; }
        .status.cancelled { background: #fbeceb; color: #b4372b; }
        .meta { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin: 32px 0 26px; position: relative; }
        .meta h3 { margin: 0 0 8px; font-size: 11px; letter-spacing: .12em; text-transform: uppercase; color: var(--copper-deep); }
        .meta p { margin: 0; }
        .meta .muted { color: var(--muted); }
        .facts { display: grid; grid-template-columns: repeat(3, 1fr); border: 1px solid var(--line); border-radius: 14px; overflow: hidden; margin-bottom: 26px; }
        .facts div { padding: 12px 16px; }
        .facts div + div { border-inline-start: 1px solid var(--line); }
        .facts small { display: block; color: var(--muted); font-size: 11px; }
        .facts b { font-family: "Montserrat", sans-serif; direction: ltr; unicode-bidi: embed; }
        table { width: 100%; border-collapse: collapse; }
        thead th { background: var(--ink); color: #fff; font-weight: 600; font-size: 12px; padding: 11px 12px; text-align: start; }
        thead th:first-child { border-start-start-radius: 10px; border-end-start-radius: 10px; }
        thead th:last-child { border-start-end-radius: 10px; border-end-end-radius: 10px; }
        tbody td { padding: 12px; border-bottom: 1px solid var(--line); vertical-align: top; }
        .num { text-align: end; white-space: nowrap; font-family: "Montserrat", sans-serif; direction: ltr; unicode-bidi: embed; }
        .totals { display: flex; justify-content: flex-end; margin-top: 18px; }
        .totals table { width: 300px; }
        .totals td { padding: 8px 12px; border: 0; }
        .totals tr.grand td { background: var(--copper-3); color: var(--copper-deep); font-weight: 800; font-size: 17px; }
        .totals tr.grand td:first-child { border-start-start-radius: 10px; border-end-start-radius: 10px; }
        .totals tr.grand td:last-child { border-start-end-radius: 10px; border-end-end-radius: 10px; }
        .notes { margin-top: 30px; padding: 16px 18px; border-radius: 14px; background: var(--sand); }
        .notes h3 { margin: 0 0 6px; font-size: 12px; color: var(--copper-deep); }
        footer { position: absolute; inset-inline: 15mm; bottom: 12mm; display: flex; justify-content: space-between; gap: 16px; padding-top: 12px; border-top: 1px solid var(--line); color: var(--muted); font-size: 12px; }
        footer span { display: inline-flex; gap: 6px; align-items: center; }
        footer i { color: var(--copper); }
        @media print {
            @page { size: A4; margin: 0; }
            body { background: #fff; }
            .toolbar, .flash { display: none !important; }
            .sheet { margin: 0; box-shadow: none; width: auto; min-height: 297mm; }
        }
        @media (max-width: 820px) {
            .sheet { width: auto; min-height: 0; margin: 12px; padding: 22px 18px 90px; }
            .meta, .facts { grid-template-columns: 1fr; }
            .facts div + div { border-inline-start: 0; border-top: 1px solid var(--line); }
            footer { inset-inline: 18px; bottom: 16px; flex-direction: column; gap: 4px; }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <a href="{{ URL::to('trika/invoices') }}"><i class="fa-solid fa-arrow-{{ $lang === 'ar' ? 'right' : 'left' }}"></i> {{ trans('layout.invoices') }}</a>
        <span class="spacer"></span>
        @if ($invoice->client_phone)
            <a class="wa" target="_blank" rel="noopener" href="https://wa.me/{{ preg_replace('/\D+/', '', $invoice->client_phone) }}?text={{ rawurlencode(trans('layout.invoice').' '.$invoice->number.' — '.$money($invoice->total).' AED') }}"><i class="fa-brands fa-whatsapp"></i> {{ trans('layout.whatsapp') }}</a>
        @endif
        @perm('invoices_edit')
            <a href="{{ URL::to('trika/invoices/'.$invoice->uuid.'/edit') }}"><i class="fa-solid fa-pen"></i> {{ trans('layout.edit') }}</a>
        @endperm
        <button class="primary" onclick="window.print()"><i class="fa-solid fa-print"></i> {{ trans('layout.print') }}</button>
    </div>
    @if (session('message'))<div class="flash">{{ session('message') }}</div>@endif

    <main class="sheet">
        <header>
            <div class="brand"><img src="{{ asset('brand/logo.png') }}" alt="Call Fahim"></div>
            <div class="title">
                <h1>{{ $site->trn ? 'Tax Invoice' : 'Invoice' }}</h1>
                <div class="sub">{{ $site->trn ? 'فاتورة ضريبية' : 'فاتورة' }}</div>
                <span @class(['status', $invoice->status])>{{ trans('layout.status_'.$invoice->status) }}</span>
            </div>
        </header>

        <section class="meta">
            <div>
                <h3>{{ trans('layout.from') }}</h3>
                <p><b>{{ $site->{$lang.'_title'} }}</b></p>
                <p class="muted">{{ $site->{$lang.'_address'} }}</p>
                @if ($site->trn)<p class="muted">TRN: <b>{{ $site->trn }}</b></p>@endif
            </div>
            <div>
                <h3>{{ trans('layout.bill_to') }}</h3>
                <p><b>{{ $invoice->client_name }}</b></p>
                @if ($invoice->client_address)<p class="muted">{{ $invoice->client_address }}</p>@endif
                @if ($invoice->client_phone)<p class="muted" dir="ltr" style="text-align:start">{{ $invoice->client_phone }}</p>@endif
                @if ($invoice->client_email)<p class="muted">{{ $invoice->client_email }}</p>@endif
                @if ($invoice->client_trn)<p class="muted">TRN: <b>{{ $invoice->client_trn }}</b></p>@endif
            </div>
        </section>

        <section class="facts">
            <div><small>{{ trans('layout.invoice_number') }}</small><b>{{ $invoice->number }}</b></div>
            <div><small>{{ trans('layout.issue_date') }}</small><b>{{ $invoice->issue_date->format('d/m/Y') }}</b></div>
            <div><small>{{ trans('layout.due_date') }}</small><b>{{ $invoice->due_date?->format('d/m/Y') ?? '—' }}</b></div>
        </section>

        <table>
            <thead>
                <tr>
                    <th style="width:40px">#</th>
                    <th>{{ trans('layout.item_description') }}</th>
                    <th class="num">{{ trans('layout.quantity') }}</th>
                    <th class="num">{{ trans('layout.unit_price') }}</th>
                    <th class="num">{{ trans('layout.line_total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->description }}</td>
                        <td class="num">{{ $item->quantity + 0 }}</td>
                        <td class="num">{{ $money($item->unit_price) }}</td>
                        <td class="num">{{ $money($item->total) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <table>
                <tr><td>{{ trans('layout.subtotal') }}</td><td class="num">{{ $money($invoice->subtotal) }}</td></tr>
                @if ($invoice->discount > 0)
                    <tr><td>{{ trans('layout.inv_discount') }}</td><td class="num">- {{ $money($invoice->discount) }}</td></tr>
                @endif
                <tr><td>{{ trans('layout.vat') }} ({{ $invoice->vat_rate + 0 }}%)</td><td class="num">{{ $money($invoice->vat_amount) }}</td></tr>
                <tr class="grand"><td>{{ trans('layout.total') }}</td><td class="num">{{ $money($invoice->total) }} AED</td></tr>
            </table>
        </div>

        @if ($invoice->notes)
            <div class="notes">
                <h3>{{ trans('layout.notes') }}</h3>
                {!! nl2br(e($invoice->notes)) !!}
            </div>
        @endif

        <footer>
            <span><i class="fa-solid fa-phone"></i> <span dir="ltr">{{ $phone }}</span></span>
            <span><i class="fa-solid fa-envelope"></i> {{ $site->email }}</span>
            <span>{{ trans('layout.thanks_business') }}</span>
        </footer>
    </main>
</body>
</html>
