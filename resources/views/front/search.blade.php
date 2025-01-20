@include('front.header', ['isHomePage' => false])
<section id="content" class="s-content">
    <div class="row">
        <div class="col-6">Test</div>
        <div class="col-6">{{ $results }}</div>
    </div>
</section> <!-- end s-content -->
@include('front.footer')