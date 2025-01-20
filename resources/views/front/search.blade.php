@include('front.header', ['isHomePage' => false])
<section id="content" class="s-content">
    {{-- <div class="row">
        <div class="col-6">Test</div>
        <div class="col-6">{{ $results }}</div>
    </div> --}}
    <article class="entry">
        <div class="row">
            <div class="column lg-12 text-center">
                <h6 class="my-3 fw-lighter">
                    Wyniki wyszukiwania dla '{{ $query }}':
                </h6>
            </div>
            @foreach ($results as $result)
                <div class="column lg-12">
                    <h5 class="my-3">
                        <a href="{{ $result['url'] }}">{{ $result['title'] }}</a>
                    </h5>
                </div>
            @endforeach

            {{-- if results array is empty --}}
            @if (!($results) || $results == null) {
                <div class="column lg-12 text-center">
                    <h4 class="my-3">
                        Brak wyników
                    </h4>
                </div>
            }
            @endif
            
        </div>
    </article>
</section> <!-- end s-content -->

@include('front.footer')
