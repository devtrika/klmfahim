@extends('admin.layouts.form')

@section('content')
@php $editing = $service->exists; @endphp
@include('admin.partials.page-head', ['title' => trans('layout.services'), 'parent' => ['admin/services', trans('layout.services')], 'current' => trans($editing ? 'layout.service_edit' : 'layout.service_add')])
<section class="content">
    <div class="box box-default">
        <form action="{{ URL::to('admin/services'.($editing ? '/'.$service->uuid : '')) }}" method="post" enctype="multipart/form-data">
            @csrf
            @if ($editing) @method('PUT') @endif
            <div class="box-body">
                @include('admin.partials.field', ['name' => 'category', 'label' => trans('layout.category'), 'type' => 'select', 'value_' => $service->category,
                    'options' => ['setup' => trans('layout.category_setup'), 'government' => trans('layout.category_government'), 'corporate' => trans('layout.category_corporate')]])
                @include('admin.partials.field', ['name' => 'ar_title', 'label' => trans('layout.service_title_ar'), 'value_' => $service->ar_title])
                @include('admin.partials.field', ['name' => 'en_title', 'label' => trans('layout.service_title_en'), 'value_' => $service->en_title])
                @include('admin.partials.field', ['name' => 'ar_short', 'label' => trans('layout.short_ar'), 'value_' => $service->ar_short])
                @include('admin.partials.field', ['name' => 'en_short', 'label' => trans('layout.short_en'), 'value_' => $service->en_short])
                @include('admin.partials.field', ['name' => 'icon', 'label' => trans('layout.icon'), 'value_' => $service->icon, 'placeholder' => 'fa-solid fa-briefcase',
                    'help' => 'fontawesome.com/icons — fa-solid fa-...'])
                @include('admin.partials.field', ['name' => 'sort', 'label' => trans('layout.sort'), 'type' => 'number', 'min' => 0, 'value_' => $service->sort ?? 0])

                <div class="form-group row">
                    <label for="f_image" class="col-sm-3 col-form-label">{{ trans('layout.service_image') }} ({{ trans('layout.optional') }})</label>
                    <div class="col-sm-9">
                        <input type="file" name="image" id="f_image" class="form-control" accept="image/*">
                        @if ($service->image)
                            <img src="{{ asset('upload/services/'.$service->image) }}" alt="" style="height:120px;margin-top:10px;border-radius:12px">
                        @endif
                        @error('image')<div class="alert alert-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                @foreach (['ar' => 'summernote', 'en' => 'summernote1'] as $l => $editor)
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">{{ trans('layout.service_desc_'.$l) }}</label>
                        <div class="col-sm-9">
                            <textarea name="{{ $l }}_desc" id="{{ $editor }}" class="form-control" rows="10">{{ old($l.'_desc', $service->{$l.'_desc'}) }}</textarea>
                            @error($l.'_desc')<div class="alert alert-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-lg">{{ trans($editing ? 'layout.edit' : 'layout.add') }}</button>
                <a href="{{ URL::to('admin/services') }}" class="btn btn-default btn-lg">{{ trans('layout.back') }}</a>
            </div>
        </form>
    </div>
</section>
@endsection
