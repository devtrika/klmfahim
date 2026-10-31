<a class="post reveal" href="{{ url($lang.'/news/'.$post->uuid.'/'.Str::slug($post->en_title)) }}">
    <div class="post-img">
        @if ($post->image)
            <img src="{{ asset('upload/news/'.$post->image) }}" alt="{{ $post->{$lang.'_title'} }}" loading="lazy">
        @endif
    </div>
    <div class="post-body">
        <time datetime="{{ $post->created_at?->toDateString() }}">{{ $post->created_at?->translatedFormat('j F Y') }}</time>
        <h3>{{ $post->{$lang.'_title'} }}</h3>
        <span class="more" style="color:var(--copper-deep);font-weight:600">{{ __('front.read_more') }} <i class="fa-solid fa-arrow-right icon-flip"></i></span>
    </div>
</a>
