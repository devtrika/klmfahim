@extends('admin.layouts.table')

@section('content')
@include('admin.partials.page-head', ['title' => trans('layout.invoices')])
<section class="content">
    <div class="cf-tiles">
        @foreach (['unpaid' => 'fa-hourglass-half', 'paid' => 'fa-check-circle', 'draft' => 'fa-pencil'] as $status => $icon)
            <a class="cf-tile" href="{{ URL::to('admin/invoices?status='.$status) }}">
                <i class="fa {{ $icon }}"></i>
                <span>
                    <b>{{ number_format($totals[$status]->amount ?? 0, 2) }}</b>
                    <small>{{ trans('layout.status_'.$status) }} · {{ $totals[$status]->n ?? 0 }}</small>
                </span>
            </a>
        @endforeach
    </div>

    <div class="box">
        <div class="box-header" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;justify-content:space-between">
            <div style="display:flex;gap:6px;flex-wrap:wrap">
                <a href="{{ URL::to('admin/invoices') }}" @class(['btn btn-sm', 'btn-info' => ! request('status'), 'btn-default' => request('status')])>{{ trans('layout.show_all') }}</a>
                @foreach (\App\Models\Invoice::STATUSES as $status)
                    <a href="{{ URL::to('admin/invoices?status='.$status) }}" @class(['btn btn-sm', 'btn-info' => request('status') === $status, 'btn-default' => request('status') !== $status])>{{ trans('layout.status_'.$status) }}</a>
                @endforeach
            </div>
            @perm('invoices_add')
                <a href="{{ URL::to('admin/invoices/create') }}" class="btn btn-lg bg-fuchsia"><i class="fa fa-plus"></i> {{ trans('layout.invoice_add') }}</a>
            @endperm
        </div>
        <div class="box-body">
            <table id="example" class="table table-hover display nowrap table-responsive">
                <thead><tr><th>{{ trans('layout.invoice_number') }}</th><th>{{ trans('layout.issue_date') }}</th><th>{{ trans('layout.client') }}</th><th>{{ trans('layout.total') }}</th><th>{{ trans('layout.status') }}</th><th></th></tr></thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td><b dir="ltr">{{ $invoice->number }}</b></td>
                            <td data-order="{{ $invoice->issue_date->format('Ymd') }}">{{ $invoice->issue_date->format('Y-m-d') }}</td>
                            <td>{{ $invoice->client_name }}</td>
                            <td dir="ltr" style="text-align:start"><b>{{ number_format($invoice->total, 2) }}</b> AED</td>
                            <td><span class="{{ $invoice->status === 'paid' ? 'label-copper' : 'label-ink' }}">{{ trans('layout.status_'.$invoice->status) }}</span></td>
                            <td class="text-nowrap">
                                <a href="{{ URL::to('admin/invoices/'.$invoice->uuid) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> {{ trans('layout.view') }}</a>
                                @perm('invoices_edit')
                                    <a href="{{ URL::to('admin/invoices/'.$invoice->uuid.'/edit') }}" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
                                @endperm
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
