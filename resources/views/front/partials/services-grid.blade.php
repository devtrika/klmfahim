@php $categories = $services->pluck('category')->unique()->values(); @endphp
@if ($categories->count() > 1)
    <div class="tabs" role="tablist" data-tabs="{{ $gridId }}">
        <button type="button" class="tab is-active" data-filter="all" role="tab" aria-selected="true">{{ __('front.view_all') }}</button>
        @foreach ($categories as $cat)
            <button type="button" class="tab" data-filter="{{ $cat }}" role="tab" aria-selected="false">{{ __('front.cat_'.$cat) }}</button>
        @endforeach
    </div>
@endif
<div class="services-grid" id="{{ $gridId }}">
    @foreach ($services as $s)
        <a class="service-card reveal" data-category="{{ $s->category }}" href="{{ url($lang.'/services/'.$s->uuid.'/'.Str::slug($s->en_title)) }}">
            <span class="ico"><i class="{{ $s->icon ?: 'fa-solid fa-briefcase' }}"></i></span>
            <h3>{{ $s->{$lang.'_title'} }}</h3>
            <p>{{ $s->{$lang.'_short'} ?: Str::limit(strip_tags($s->{$lang.'_desc'}), 110) }}</p>
            <span class="more">{{ __('front.read_more') }} <i class="fa-solid fa-arrow-right icon-flip"></i></span>
        </a>
    @endforeach
</div>
