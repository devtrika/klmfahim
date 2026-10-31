@extends('admin.layouts.form')

@section('content')
@php
    $editing = $invoice->exists;
    $rows = old('items', $items);
    $statuses = collect(\App\Models\Invoice::STATUSES)->mapWithKeys(fn ($s) => [$s => trans('layout.status_'.$s)])->all();
@endphp
@include('admin.partials.page-head', ['title' => trans('layout.invoices'), 'parent' => ['trika/invoices', trans('layout.invoices')], 'current' => $editing ? $invoice->number : trans('layout.invoice_add')])
<section class="content">
    <form action="{{ URL::to('trika/invoices'.($editing ? '/'.$invoice->uuid : '')) }}" method="post" id="invoiceForm">
        @csrf
        @if ($editing) @method('PUT') @endif
        <input type="hidden" name="cost_request_id" value="{{ old('cost_request_id', $invoice->cost_request_id) }}">

        <div class="row">
            <div class="col-lg-6">
                <div class="box box-default">
                    <div class="box-header"><h3 class="box-title" style="margin:0">{{ trans('layout.invoice') }}</h3></div>
                    <div class="box-body">
                        @include('admin.partials.field', ['name' => 'number', 'label' => trans('layout.invoice_number'), 'value_' => $invoice->number])
                        @include('admin.partials.field', ['name' => 'status', 'label' => trans('layout.status'), 'type' => 'select', 'options' => $statuses, 'value_' => $invoice->status])
                        @include('admin.partials.field', ['name' => 'issue_date', 'label' => trans('layout.issue_date'), 'type' => 'date', 'value_' => $invoice->issue_date?->format('Y-m-d')])
                        @include('admin.partials.field', ['name' => 'due_date', 'label' => trans('layout.due_date'), 'type' => 'date', 'value_' => $invoice->due_date?->format('Y-m-d')])
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="box box-default">
                    <div class="box-header"><h3 class="box-title" style="margin:0">{{ trans('layout.bill_to') }}</h3></div>
                    <div class="box-body">
                        @include('admin.partials.field', ['name' => 'client_name', 'label' => trans('layout.client_name'), 'value_' => $invoice->client_name])
                        @include('admin.partials.field', ['name' => 'client_phone', 'label' => trans('layout.phone'), 'value_' => $invoice->client_phone])
                        @include('admin.partials.field', ['name' => 'client_email', 'label' => trans('layout.email'), 'type' => 'email', 'value_' => $invoice->client_email])
                        @include('admin.partials.field', ['name' => 'client_address', 'label' => trans('layout.address'), 'value_' => $invoice->client_address])
                        @include('admin.partials.field', ['name' => 'client_trn', 'label' => trans('layout.trn').' ('.trans('layout.optional').')', 'value_' => $invoice->client_trn])
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header"><h3 class="box-title" style="margin:0">{{ trans('layout.items') }}</h3></div>
            <div class="box-body">
                <table class="table" id="itemsTable">
                    <thead><tr><th style="width:50%">{{ trans('layout.item_description') }}</th><th>{{ trans('layout.quantity') }}</th><th>{{ trans('layout.unit_price') }}</th><th>{{ trans('layout.line_total') }}</th><th></th></tr></thead>
                    <tbody>
                        @foreach ($rows as $i => $row)
                            <tr data-item>
                                <td><input class="form-control" name="items[{{ $i }}][description]" value="{{ $row['description'] }}" required></td>
                                <td><input class="form-control" type="number" step="0.01" min="0.01" name="items[{{ $i }}][quantity]" value="{{ $row['quantity'] + 0 }}" data-qty required></td>
                                <td><input class="form-control" type="number" step="0.01" min="0" name="items[{{ $i }}][unit_price]" value="{{ $row['unit_price'] + 0 }}" data-price required></td>
                                <td dir="ltr" style="vertical-align:middle" data-line>0.00</td>
                                <td><button type="button" class="btn btn-sm btn-danger" data-remove><i class="fa fa-times"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($errors->has('items') || $errors->has('items.*'))
                    <div class="alert alert-danger">{{ $errors->first('items') ?: collect($errors->get('items.*'))->flatten()->first() }}</div>
                @endif
                <button type="button" class="btn btn-default" id="addItem"><i class="fa fa-plus"></i> {{ trans('layout.add_line') }}</button>

                <div class="row" style="margin-top:24px">
                    <div class="col-lg-6">
                        @include('admin.partials.field', ['name' => 'notes', 'label' => trans('layout.notes'), 'type' => 'textarea', 'rows' => 5, 'value_' => $invoice->notes])
                    </div>
                    <div class="col-lg-6">
                        <table class="table" style="max-width:420px;margin-inline-start:auto">
                            <tr><td>{{ trans('layout.subtotal') }}</td><td dir="ltr" id="tSubtotal" style="text-align:end">0.00</td></tr>
                            <tr><td>{{ trans('layout.inv_discount') }}</td><td><input class="form-control" type="number" step="0.01" min="0" name="discount" value="{{ old('discount', $invoice->discount + 0) }}" id="discount"></td></tr>
                            <tr><td>{{ trans('layout.vat') }} (%)</td><td><input class="form-control" type="number" step="0.01" min="0" max="100" name="vat_rate" value="{{ old('vat_rate', $invoice->vat_rate + 0) }}" id="vatRate"></td></tr>
                            <tr><td>{{ trans('layout.vat') }}</td><td dir="ltr" id="tVat" style="text-align:end">0.00</td></tr>
                            <tr><th>{{ trans('layout.total') }}</th><th dir="ltr" id="tTotal" style="text-align:end;font-size:20px;color:#8c5536">0.00</th></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-save"></i> {{ trans($editing ? 'layout.edit' : 'layout.add') }}</button>
                <a href="{{ URL::to('trika/invoices'.($editing ? '/'.$invoice->uuid : '')) }}" class="btn btn-default btn-lg">{{ trans('layout.back') }}</a>
            </div>
        </div>
    </form>
</section>

<template id="itemRow">
    <tr data-item>
        <td><input class="form-control" data-name="description" required></td>
        <td><input class="form-control" type="number" step="0.01" min="0.01" value="1" data-name="quantity" data-qty required></td>
        <td><input class="form-control" type="number" step="0.01" min="0" value="0" data-name="unit_price" data-price required></td>
        <td dir="ltr" style="vertical-align:middle" data-line>0.00</td>
        <td><button type="button" class="btn btn-sm btn-danger" data-remove><i class="fa fa-times"></i></button></td>
    </tr>
</template>

<script>
(function () {
    var form = document.getElementById('invoiceForm');
    var body = document.querySelector('#itemsTable tbody');
    var money = function (n) { return (Math.round(n * 100) / 100).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); };
    var next = body.querySelectorAll('[data-item]').length;

    function recalc() {
        var subtotal = 0;
        body.querySelectorAll('[data-item]').forEach(function (row) {
            var line = (parseFloat(row.querySelector('[data-qty]').value) || 0) * (parseFloat(row.querySelector('[data-price]').value) || 0);
            row.querySelector('[data-line]').textContent = money(line);
            subtotal += line;
        });
        var discount = Math.min(parseFloat(document.getElementById('discount').value) || 0, subtotal);
        var vat = (subtotal - discount) * (parseFloat(document.getElementById('vatRate').value) || 0) / 100;
        document.getElementById('tSubtotal').textContent = money(subtotal);
        document.getElementById('tVat').textContent = money(vat);
        document.getElementById('tTotal').textContent = money(subtotal - discount + vat) + ' AED';
    }

    document.getElementById('addItem').addEventListener('click', function () {
        var row = document.getElementById('itemRow').content.firstElementChild.cloneNode(true);
        row.querySelectorAll('[data-name]').forEach(function (input) { input.name = 'items[' + next + '][' + input.dataset.name + ']'; });
        next++;
        body.appendChild(row);
        row.querySelector('input').focus();
        recalc();
    });
    body.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-remove]');
        if (btn && body.querySelectorAll('[data-item]').length > 1) { btn.closest('tr').remove(); recalc(); }
    });
    form.addEventListener('input', recalc);
    recalc();
})();
</script>
@endsection
