<div class="d-flex justify-content-center align-items-center">
    @foreach($available_locales as $locale_name => $available_locale)
        @if($available_locale === $current_locale)
            <span class="mx-2 btn btn-danger">{{ $locale_name }}</span>
        @else
            <a class="mx-1 btn btn-outline-primary" href="{{ route('lang', ['locale' => $available_locale]) }}">
                <span>{{ $locale_name }}</span>
            </a>
        @endif
    @endforeach
</div>
