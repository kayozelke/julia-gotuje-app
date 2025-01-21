@include('front.header')

<style>
    .gallery-item img {
        transition: transform 0.3s ease;
    }

    .gallery-item img:hover {
        transform: scale(1.05);
    }
</style>

<!-- # site-content
        ================================================== -->
        {{-- removed class s-content--blog --}}
<div id="content" class="s-content">

    <div class="row entry-wrap">
        <div class="column lg-12">
            {{-- show breadcrumb if any category is set --}}
            @if (count($recurrent_parent_categories) != 0)
            <div class="content-primary">
                <h5 class="my-5">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style="list-style: none; padding: 0; margin: 0; display: inline;">
                            {{-- @if (count($recurrent_parent_categories) == 0) --}}
                                {{-- <li class="breadcrumb-item active" style="display: inline;">Wszystko
                                </li> --}}
                            {{-- @else --}}
                                <li class="breadcrumb-item" style="display: inline;">
                                    <a href="{{ route('main_categories') }}" style="text-decoration: none; color: inherit;">
                                        Wszystko
                                    </a>
                                </li>

                                {{-- Iterate through parent categories and add '/' separator --}}
                                @foreach (array_reverse($recurrent_parent_categories) as $par_category)
                                    <li style="display: inline;"> / </li> <!-- Separator -->

                                    <li class="breadcrumb-item" style="display: inline;">
                                        <a href="{{ route('categories', ['id' => $par_category->id]) }}"
                                            style="text-decoration: none; color: inherit;">
                                            {{ $par_category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            {{-- @endif --}}
                        </ol>
                    </nav>
                </h5>
                @endif
            </div>

            <article class="entry format-standard">

                <header class="entry__header">

                    <h1 class="entry__title">
                        {{ $post->title }}
                    </h1>

                    <div class="entry__meta">
                        <div class="entry__meta-author">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <circle cx="12" cy="8" r="3.25" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></circle>
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M6.8475 19.25H17.1525C18.2944 19.25 19.174 18.2681 18.6408 17.2584C17.8563 15.7731 16.068 14 12 14C7.93201 14 6.14367 15.7731 5.35924 17.2584C4.82597 18.2681 5.70558 19.25 6.8475 19.25Z">
                                </path>
                            </svg>
                            <!-- <a href="#"></a> -->
                            {{ $post->createdByUser->first_name ?? 'N/A' }} {{ $post->createdByUser->last_name ?? '' }}
                        </div>
                        <div class="entry__meta-date">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="7.25" stroke="currentColor" stroke-width="1.5">
                                </circle>
                                <path stroke="currentColor" stroke-width="1.5" d="M12 8V12L14 14"></path>
                            </svg>
                            <!-- August 15, 2021 -->
                            {{ $post->updated_at }}
                        </div>
                        <!-- if parent category -->
                        @if ($post->parent_category)
                            <div class="entry__meta-cat">
                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M19.25 17.25V9.75C19.25 8.64543 18.3546 7.75 17.25 7.75H4.75V17.25C4.75 18.3546 5.64543 19.25 6.75 19.25H17.25C18.3546 19.25 19.25 18.3546 19.25 17.25Z">
                                    </path>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M13.5 7.5L12.5685 5.7923C12.2181 5.14977 11.5446 4.75 10.8127 4.75H6.75C5.64543 4.75 4.75 5.64543 4.75 6.75V11">
                                    </path>
                                </svg>
                                <span class="cat-links">
                                    <a href="{{ route('categories', ['id' => $post->parent_category->id]) }}">
                                        {{ $post->parent_category->name }}
                                    </a>
                                </span>
                            </div>
                        @endif
                    </div>
                </header>

                {{-- <div class="entry__media">
                    <figure class="featured-image">
                        <img src="{{ asset('front/images/thumbs/single/standard-1200.jpg') }}"
                            srcset=" {{ asset('front/images/thumbs/single/standard-2400.jpg 2400w,
                                                                                            front/images/thumbs/single/standard-1200.jpg 1200w, 
                                                                                            front/images/thumbs/single/standard-600.jpg 600w') }}"
                            sizes="(max-width: 2400px) 100vw, 2400px" alt="">
                    </figure>
                </div> --}}

                <div class="content-primary">

                    <div class="entry__content">

                        <div>
                            {!! $post->content !!}
                        </div>

                        {{-- <hr>
                        <p class="lead">
                            Duis ex ad cupidatat tempor Excepteur cillum cupidatat fugiat nostrud cupidatat dolor
                            sunt sint sit nisi est eu exercitation incididunt adipisicing veniam velit id fugiat
                            enim mollit amet anim veniam dolor dolor irure velit commodo cillum sit nulla ullamco
                            magna amet magna cupidatat qui labore cillum cillum cupidatat fugiat nostrud. </p>

                        <!-- <p class="drop-cap">
                            Eligendi quam at quis. Sit vel neque quam consequuntur expedita quisquam. Incidunt quae
                            qui error. Rerum non facere mollitia ut magnam laboriosam. Quisquam neque quia ex eligendi
                            repellat illum quibusdam aut. Architecto quam consequuntur totam ratione reprehenderit est
                            praesentium impedit maiores incididunt adipisicing veniam velit .
                        </p> -->

                        <p>
                            Duis ex ad cupidatat tempor Excepteur cillum cupidatat fugiat nostrud cupidatat dolor
                            sunt sint sit nisi est eu exercitation incididunt adipisicing veniam velit id fugiat
                            enim mollit amet anim veniam dolor dolor irure velit commodo cillum sit nulla ullamco
                            magna amet magna cupidatat qui labore cillum sit in tempor veniam consequat non laborum
                            adipisicing aliqua ea nisi sint ut quis proident ullamco ut dolore culpa occaecat ut
                            laboris in sit minim cupidatat ut dolor voluptate enim veniam consequat occaecat fugiat
                            in adipisicing in amet Ut nulla nisi non ut enim aliqua laborum mollit quis nostrud sed sed.
                        </p>

                        <figure class="alignwide">
                            <img src="{{ asset('front/images/sample-1200.jpg') }}"
                                srcset="{{ asset('front/images/sample-2400.jpg 2400w,
                                                                                                        front/images/sample-1200.jpg 1200w, 
                                                                                                        front/images/sample-600.jpg 600w') }}"
                                sizes="(max-width: 2400px) 100vw, 2400px" alt="">
                        </figure>

                        <p>
                            Duis ex ad cupidatat tempor Excepteur cillum cupidatat fugiat nostrud cupidatat dolor
                            sunt sint sit nisi est eu exercitation incididunt adipisicing veniam velit id fugiat
                            enim mollit amet anim veniam dolor dolor irure velit commodo cillum sit nulla ullamco
                            magna amet magna cupidatat qui labore cillum sit in tempor veniam consequat non laborum
                            adipisicing aliqua ea nisi sint ut quis proident ullamco ut dolore culpa occaecat ut
                            laboris in sit minim cupidatat ut dolor voluptate enim veniam consequat occaecat fugiat
                            in adipisicing in amet Ut nulla nisi non ut enim aliqua laborum mollit quis nostrud sed sed.
                        </p> --}}

                        <!-- <p class="entry__tags">
                            <strong>Tags:</strong>

                            <span class="entry__tag-list">
                                <a href="#0">orci</a>
                                <a href="#0">lectus</a>
                                <a href="#0">varius</a>
                                <a href="#0">turpis</a>
                            </span>

                        </p> -->

                        <!-- <div class="entry__author-box">
                            <figure class="entry__author-avatar">
                                <img alt="" src="{{ asset('front/images/avatars/user-06.jpg') }}" class="avatar">
                            </figure>
                            <div class="entry__author-info">
                                <h5 class="entry__author-name">
                                    <a href="#0">
                                        Naruto Uzumaki
                                    </a>
                                </h5>
                                <p>
                                    Pellentesque ornare sem lacinia quam venenatis vestibulum. Nulla vitae elit libero,
                                    a pharetra augue laboris in sit minim cupidatat ut dolor voluptate enim veniam
                                    consequat occaecat.
                                </p>
                            </div>
                        </div> -->

                    </div> <!-- end entry-content -->

                    <!-- <div class="post-nav">
                        <div class="post-nav__prev">
                            <a href="single-standard.html" rel="prev">
                                <span>Prev</span>
                                The Pomodoro Technique Really Works.
                            </a>
                        </div>
                        <div class="post-nav__next">
                            <a href="single-standard.html" rel="next">
                                <span>Next</span>
                                How Imagery Drives User Experience.
                            </a>
                        </div>
                    </div> -->

                </div> <!-- end content-primary -->

                    {{-- Galeria obrazków --}}
                {{-- <div class="container mt-4">
                    <div class="row">
                        @foreach ($post->imagesByPriority as $image)
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="card h-100">
                                    <img src="{{ asset($image->file_location) }}" class="card-img-top img-fluid" alt="{{ $image->title }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $image->title }}</h5>
                                        <p class="card-text">{{ $image->label }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div> --}}

                <div class="container my-4">
                    {{-- <h1 class="text-center my-4">
                        Responsive Image Gallery
                    </h1> --}}

                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                        @foreach ($post->imagesByPriority as $image)
                            <div class="col">
                                {{-- <div class="position-relative gallery-item" style="cursor: pointer;"> --}}
                                <div class="position-relative gallery-item">
                                    <a href="{{ $image->file_location }}">
                                        <img src="{{ $image->file_location }}" alt="{{ $image->title }}" class="w-100" style="height: 280px; object-fit: cover">
                                        {{-- <div class="position-absolute top-50 start-50 translate-middle text-center d-none">
                                            <div class="bg-success bg-opacity-70 text-white px-4 py-2">
                                                {{ $image->title }}
                                            </div>
                                        </div> --}}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


            </article> <!-- end entry -->


        </div>
    </div> <!-- end entry-wrap -->

</div> <!-- end s-content -->

@include('front.footer')

{{-- script from https://www.geeksforgeeks.org/how-to-create-a-responsive-image-gallery-in-bootstrap/ --}}
{{-- <script>
        
    // Show caption on hover 
        let position_relative = 
            document.querySelectorAll('.position-relative');

        position_relative.forEach(item => {
            item.addEventListener('mouseover', event => {
                const caption = item.querySelector('.position-absolute');
                caption.classList.remove('d-none');
            });
            item.addEventListener('mouseleave', event => {
                const caption = item.querySelector('.position-absolute');
                caption.classList.add('d-none');
            });
        });
</script> --}}