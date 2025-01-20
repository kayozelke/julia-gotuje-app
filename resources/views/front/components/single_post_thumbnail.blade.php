<article class="brick entry" data-animate-el>

    <div class="entry__thumb">
        <a href="{{ $url }}" class="thumb-link">
            {{-- <img src="{{ $src }}" srcset="{{ $srcset }}" alt=""> --}}
            <img src="{{ asset($src) }}" srcset="{{ asset($srcset) }}" alt="">
        </a>
    </div> <!-- end entry__thumb -->

    <div class="entry__text">
        <div class="entry__header">
            <h1 class="entry__title">
                <a href="{{ $url }}">{{ $title ?? 'Default Title' }}</a>
            </h1>
        </div>
    </div> <!-- end entry__text -->

</article> <!-- end article -->
