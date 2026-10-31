@extends('admin.layouts.table')

@section('content')
@include('admin.partials.page-head', ['title' => trans('layout.features')])
<section class="content">
    <div class="box">
        <div class="box-header">
            @perm('features_add')<a href="{{ URL::to('admin/features/create') }}" class="btn btn-lg bg-fuchsia"><i class="fa fa-plus"></i> {{ trans('layout.add') }}</a>@endperm
        </div>
        <div class="box-body">
            <table class="table table-hover">
                <thead><tr><th>#</th><th>{{ trans('layout.feature_title_ar') }}</th><th>{{ trans('layout.feature_title_en') }}</th><th></th></tr></thead>
                <tbody>
                    @foreach ($features as $f)
                        <tr>
                            <td>{{ $f->sort }}</td>
                            <td>{{ $f->ar_title }}</td>
                            <td>{{ $f->en_title }}</td>
                            <td class="text-nowrap">
                                @perm('features_edit')<a href="{{ URL::to('admin/features/'.$f->uuid.'/edit') }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> {{ trans('layout.edit') }}</a>@endperm
                                @perm('features_delete')<form action="{{ URL::to('admin/features/'.$f->uuid) }}" method="post" style="display:inline" onsubmit="return confirm('?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> {{ trans('layout.delete') }}</button>
                                </form>@endperm
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
