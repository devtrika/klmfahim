@extends('admin.layouts.shell')

@section('title', trans('layout.not_allow'))

@section('content')
<div class="cf-card cf-deny">
    <div class="cf-card-body" style="padding:36px 28px">
        <i class="fa fa-lock"></i>
        <h2 style="font-size:20px;margin:0 0 8px">{{ trans('layout.not_allow') }}</h2>
        <p class="text-muted" style="margin:0 0 22px">{{ trans('layout.not_allow_hint') }}</p>
        <a class="btn btn-info" href="{{ URL::to('trika') }}"><i class="fa fa-th-large"></i> {{ trans('layout.dashboard') }}</a>
    </div>
</div>
@endsection
