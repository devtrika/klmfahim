@extends('admin.layouts.table')

@section('content')
@include('admin.partials.page-head', ['title' => trans('layout.requests'), 'parent' => ['admin/requests', trans('layout.requests')], 'current' => $item->name])
@php
    $digits = preg_replace('/\D+/', '', $item->phone);
    $lang = LaravelLocalization::getCurrentLocale();
@endphp
<section class="content">
    <div class="row">
        <div class="col-lg-4">
            <div class="box">
                <div class="box-body">
                    <h3 style="margin-top:0">{{ $item->name }}</h3>
                    <p dir="ltr" style="text-align:start"><i class="fa fa-phone"></i> {{ $item->phone }}</p>
                    @if ($item->email)<p><i class="fa fa-envelope"></i> {{ $item->email }}</p>@endif
                    <p class="text-muted"><i class="fa fa-clock-o"></i> {{ $item->created_at->format('Y-m-d H:i') }}</p>
                    <a class="btn btn-primary btn-block" target="_blank" rel="noopener" href="https://wa.me/{{ $digits }}"><i class="fa fa-whatsapp"></i> {{ trans('layout.reply_whatsapp') }}</a>
                    <a class="btn btn-default btn-block" href="tel:{{ $digits }}"><i class="fa fa-phone"></i> {{ $item->phone }}</a>
                    @perm('invoices_add')
                        <a class="btn btn-info btn-block" href="{{ URL::to('admin/invoices/create?request='.$item->uuid) }}"><i class="fa fa-file-text"></i> {{ trans('layout.create_invoice') }}</a>
                    @endperm
                    @perm('requests_delete')
                    <form action="{{ URL::to('admin/requests/'.$item->uuid) }}" method="post" onsubmit="return confirm('?')" style="margin-top:10px">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-block"><i class="fa fa-trash-o"></i> {{ trans('layout.delete') }}</button>
                    </form>
                    @endperm
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="box">
                <div class="box-header"><h3 class="box-title" style="margin:0">{{ trans('layout.details') }}</h3></div>
                <div class="box-body">
                    <table class="table">
                        @foreach ($item->selections as $line)
                            <tr>
                                <td class="text-muted">{{ trans('front.lbl_'.$line['group']) }}</td>
                                <td>{{ $line['title'] }}</td>
                                <td class="text-nowrap" dir="ltr">{{ $line['price'] ? number_format($line['price']).' AED' : '—' }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="2">{{ trans('layout.estimate') }}</th>
                            <th class="text-nowrap" dir="ltr" style="font-size:20px;color:#8c5536">{{ number_format($item->estimate) }} AED</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
