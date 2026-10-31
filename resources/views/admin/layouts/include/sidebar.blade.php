@php
    $lang = LaravelLocalization::getCurrentLocale();
    $arrow = $lang === 'ar' ? 'left' : 'right';
    $path = trim(preg_replace('#^(ar|en)/#', '', request()->path()), '/');
    $badges = [
        'requests' => can_do('requests') ? \App\Models\CostRequest::where('seen', false)->count() : 0,
        'contact' => can_do('contact') ? \App\Models\Contact::where('seen', 'no')->count() : 0,
    ];
    $modules = collect(config('permissions.modules'))->filter(fn ($m, $key) => can_do($key))->groupBy('section', true);
@endphp
<aside class="main-sidebar">
    <section class="sidebar" dir="{{ $lang === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="user-panel" style="display:flex;align-items:center;gap:10px;padding:16px 18px">
            <img src="{{ asset('brand/mark.png') }}" alt="" style="width:40px;height:40px">
            <div class="info" style="position:static;padding:0">
                <p style="margin:0;font-weight:600">{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('layout.online') }}</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree" style="padding-bottom:50px">
            <li @class(['active' => $path === 'trika'])>
                <a href="{{ URL::to('trika') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('layout.admin') }}</span></a>
            </li>
            <li>
                <a href="{{ URL::to($lang) }}" target="_blank"><i class="fa fa-external-link"></i> <span>{{ trans('layout.website') }}</span></a>
            </li>

            @foreach (config('permissions.sections') as $section)
                @continue(! $modules->has($section))
                <li class="header-label">{{ trans('layout.'.$section) }}</li>
                @foreach ($modules[$section] as $key => $module)
                    @php $canAdd = in_array('add', $module['actions']) && can_do($key.'_add'); @endphp
                    <li @class(['treeview' => $canAdd, 'active' => str_starts_with($path, $module['url'])])>
                        <a href="{{ $canAdd ? '#' : URL::to($module['url']) }}">
                            <i class="fa {{ $module['icon'] }}"></i>
                            <span>{{ trans('layout.'.$module['label']) }}</span>
                            @if ($badges[$key] ?? 0)<span class="badge-new">{{ $badges[$key] }}</span>@endif
                            @if ($canAdd)
                                <span class="pull-{{ $arrow }}-container"><i class="fa fa-angle-{{ $arrow }} pull-{{ $arrow }}"></i></span>
                            @endif
                        </a>
                        @if ($canAdd)
                            <ul class="treeview-menu">
                                <li><a href="{{ URL::to($module['url']) }}"><i class="fa fa-circle-o"></i> {{ trans('layout.show_all') }}</a></li>
                                <li><a href="{{ URL::to($module['url'].'/create') }}"><i class="fa fa-plus"></i> {{ trans('layout.add') }}</a></li>
                            </ul>
                        @endif
                    </li>
                @endforeach
            @endforeach

            <li class="header-label">&nbsp;</li>
            <li>
                <a href="{{ LaravelLocalization::getLocalizedURL($lang === 'ar' ? 'en' : 'ar') }}"><i class="fa fa-globe"></i> <span>{{ $lang === 'ar' ? 'English' : 'العربية' }}</span></a>
            </li>
            <li>
                <a href="{{ URL::to('trika/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('layout.logout') }}</span></a>
            </li>
        </ul>
    </section>
</aside>
