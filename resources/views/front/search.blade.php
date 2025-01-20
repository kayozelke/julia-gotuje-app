@include('front.header', ['isHomePage' => false])
<section id="content" class="s-content">
    {{-- <div class="row">
        <div class="col-6">Test</div>
        <div class="col-6">{{ $results }}</div>
    </div> --}}
    <article class="entry">
        <div class="row">
            <div class="column lg-12">
                Wynik nr 1
            </div>
            <hr>
            <div class="column lg-12">
                Wynik nr 2
            </div>
        </div>
    </article>
</section> <!-- end s-content -->
@include('front.footer')