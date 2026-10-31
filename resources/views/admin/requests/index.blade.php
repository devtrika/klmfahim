@extends('admin.layouts.table')

@section('content')
@include('admin.partials.page-head', ['title' => trans('layout.requests')])
<section class="content">
    <div class="box">
        <div class="box-body">
            <table id="example" class="table table-hover display nowrap table-responsive">
                <thead><tr><th>{{ trans('layout.date') }}</th><th>{{ trans('layout.name') }}</th><th>{{ trans('layout.phone') }}</th><th>{{ trans('layout.estimate') }}</th><th>{{ trans('layout.status') }}</th><th></th></tr></thead>
                <tbody>
                    @foreach ($requests as $r)
                        <tr>
                            <td data-order="{{ $r->created_at->timestamp }}">{{ $r->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $r->name }}</td>
                            <td dir="ltr">{{ $r->phone }}</td>
                            <td><b>{{ number_format($r->estimate) }}</b> AED</td>
                            <td>@if ($r->seen)<span class="label-copper">{{ trans('layout.seen') }}</span>@else<span class="label-ink">{{ trans('layout.unseen') }}</span>@endif</td>
                            <td class="text-nowrap"><a href="{{ URL::to('trika/requests/'.$r->uuid) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> {{ trans('layout.view') }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
