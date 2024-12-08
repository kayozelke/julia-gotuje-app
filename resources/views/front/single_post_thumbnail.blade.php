<article class="brick entry" data-animate-el>

    <div class="entry__thumb">
        <a href="single-standard.html" class="thumb-link">
            {{-- <img src="{{ $src }}" srcset="{{ $srcset }}" alt=""> --}}
            <img src="{{ asset($src) }}" srcset="{{ asset($srcset) }}" alt="">
        </a>
    </div> <!-- end entry__thumb -->

    <div class="entry__text">
        <div class="entry__header">
            <h1 class="entry__title">
                <a href="{{ route('single_post') }}">{{ $title ?? 'Default Title' }}</a>
            </h1>
        </div>
        {{-- <div class="entry__excerpt">
            <p>
                Lorem ipsum Sed eiusmod esse aliqua sed incididunt aliqua incididunt mollit id
                et sit proident dolor nulla
                sed commodo est ad minim elit reprehenderit nisi officia aute incididunt velit
                sint in aliqua cillum in.
            </p>
        </div>
        <a class="entry__more-link" href="#0">Read More</a> --}}
    </div> <!-- end entry__text -->

</article> <!-- end article -->
