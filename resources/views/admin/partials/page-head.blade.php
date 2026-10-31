@php $pull = LaravelLocalization::getCurrentLocale() === 'ar' ? 'pull-right' : 'pull-left'; @endphp
<section class="content-header">
    <h1>{{ $title }}</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item {{ $pull }}"><a href="{{ URL::to('admin') }}">{{ trans('layout.home') }}</a></li>
        @isset($parent)<li class="breadcrumb-item {{ $pull }}"><a href="{{ URL::to($parent[0]) }}">{{ $parent[1] }}</a></li>@endisset
        <li class="breadcrumb-item active {{ $pull }}">{{ $current ?? $title }}</li>
    </ol>
</section>
@if (Session::has('message'))
    <section class="content" style="min-height:0;padding-bottom:0">
        <div class="alert alert-success alert-dismissible">{{ Session::get('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </div>
    </section>
@endif
