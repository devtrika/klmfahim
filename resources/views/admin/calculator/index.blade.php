@extends('admin.layouts.table')

@section('content')
@include('admin.partials.page-head', ['title' => trans('layout.calculator_items')])
<section class="content">
    @foreach (\App\Models\CalculatorItem::GROUPS as $group)
        <div class="box">
            <div class="box-header" style="display:flex;justify-content:space-between;align-items:center">
                <h3 class="box-title" style="margin:0">{{ trans('layout.calc_group_'.$group) }}</h3>
                @perm('calculator_add')<a href="{{ URL::to('trika/calculator/create?group='.$group) }}" class="btn btn-sm bg-fuchsia"><i class="fa fa-plus"></i> {{ trans('layout.add') }}</a>@endperm
            </div>
            <div class="box-body">
                <table class="table table-hover" style="margin:0">
                    <thead><tr><th>{{ trans('layout.title_ar') }}</th><th>{{ trans('layout.title_en') }}</th><th>{{ trans('layout.price') }}</th><th></th></tr></thead>
                    <tbody>
                        @forelse ($groups->get($group, []) as $item)
                            <tr>
                                <td>{{ $item->ar_title }}<br><small class="text-muted">{{ $item->ar_hint }}</small></td>
                                <td>{{ $item->en_title }}<br><small class="text-muted">{{ $item->en_hint }}</small></td>
                                <td><span class="label-copper">{{ number_format($item->price) }} AED</span></td>
                                <td class="text-nowrap">
                                    @perm('calculator_edit')<a href="{{ URL::to('trika/calculator/'.$item->uuid.'/edit') }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>@endperm
                                    @perm('calculator_delete')<form action="{{ URL::to('trika/calculator/'.$item->uuid) }}" method="post" style="display:inline" onsubmit="return confirm('?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></button>
                                    </form>@endperm
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-muted">—</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</section>
@endsection
