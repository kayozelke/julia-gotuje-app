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
                    Tu coś będzie
                </h6>
            </div>
            
        </div>
    </article>

    <div>
        @include('front.components.memory_game')
    </div>
</section> <!-- end s-content -->

@include('front.footer')
