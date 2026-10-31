<section class="page-hero">
    <div class="container">
        <nav class="crumbs" aria-label="breadcrumb">
            <a href="{{ url($lang) }}">{{ __('front.home') }}</a>
            @foreach ($crumbs ?? [] as $href => $crumb)
                <span>/</span><a href="{{ $href }}">{{ $crumb }}</a>
            @endforeach
        </nav>
        <h1>{{ $title }}</h1>
        @isset($text)<p>{{ $text }}</p>@endisset
    </div>
</section>
