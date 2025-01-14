@php
    use Illuminate\Support\Facades\DB;

    $posts = [
        [
            'src' => 'front/images/thumbs/masonry/statue-600.jpg',
            'srcset' => 'front/images/thumbs/masonry/statue-600.jpg 1x, front/images/thumbs/masonry/statue-1200.jpg 2x',
            'title' => 'Just a Normal Simple Blog Post',
        ],
        [
            'src' => 'front/images/thumbs/masonry/beetle-600.jpg',
            'srcset' => 'front/images/thumbs/masonry/beetle-600.jpg 1x, front/images/thumbs/masonry/beetle-1200.jpg 2x',
            'title' => 'Throwback To The Good Old Days.',
        ],
        [
            'src' => 'front/images/thumbs/masonry/grayscale-600.jpg',
            'srcset' => 'front/images/thumbs/masonry/statue-600.jpg 1x, front/images/thumbs/masonry/statue-1200.jpg 2x',
            'title' => '5 Grayscale Coloring Techniques.',
        ],
        [
            'src' => 'front/images/thumbs/masonry/woodcraft-600.jpg',
            'srcset' =>
                'front/images/thumbs/masonry/woodcraft-600.jpg 1x, front/images/thumbs/masonry/woodcraft-1200.jpg 2x',
            'title' => 'What Minimalism Really Looks Like.',
        ],
        [
            'src' => 'front/images/thumbs/masonry/tulips-600.jpg',
            'srcset' => 'front/images/thumbs/masonry/tulips-600.jpg 1x, front/images/thumbs/masonry/tulips-1200.jpg 2x',
            'title' => '10 Interesting Facts About Caffeine.',
        ],
        [
            'src' => 'front/images/thumbs/masonry/red-and-blue-600.jpg',
            'srcset' =>
                'front/images/thumbs/masonry/red-and-blue-600.jpg 1x, front/images/thumbs/masonry/red-and-blue-1200.jpg 2x',
            'title' => 'Red and Blue Photo Effects.',
        ],
        [
            'src' => 'front/images/thumbs/masonry/white-lamp-600.jpg',
            'srcset' =>
                'front/images/thumbs/masonry/white-lamp-600.jpg 1x, front/images/thumbs/masonry/white-lamp-1200.jpg 2x',
            'title' => '10 Practical Ways to Be Minimalist.',
        ],
        [
            'src' => 'front/images/thumbs/masonry/books-600.jpg',
            'srcset' => 'front/images/thumbs/masonry/books-600.jpg 1x, front/images/thumbs/masonry/books-1200.jpg 2x',
            'title' => 'What Does Reading Do to Your Brain?',
        ],
        [
            'src' => 'front/images/thumbs/masonry/lamp-600.jpg',
            'srcset' => 'front/images/thumbs/masonry/lamp-600.jpg 1x, front/images/thumbs/masonry/lamp-1200.jpg 2x',
            'title' => 'Symmetry In Modern Design.',
        ],
        [
            'src' => 'front/images/thumbs/masonry/clock-600.jpg',
            'srcset' => 'front/images/thumbs/masonry/clock-600.jpg 1x, front/images/thumbs/masonry/clock-1200.jpg 2x',
            'title' => '10 Tips for Managing Time Effectively.',
        ],
        [
            'src' => 'front/images/thumbs/masonry/phone-and-keyboard-600.jpg',
            'srcset' =>
                'front/images/thumbs/masonry/phone-and-keyboard-600.jpg 1x, front/images/thumbs/masonry/phone-and-keyboard-1200.jpg 2x',
            'title' => 'Need Web Hosting for Your Websites?',
        ],
        [
            'src' => 'front/images/thumbs/masonry/wheel-600.jpg',
            'srcset' => 'front/images/thumbs/masonry/wheel-600.jpg 1x, front/images/thumbs/masonry/wheel-1200.jpg 2x',
            'title' => 'Black And White Photography Tips.',
        ],
    ];

    // Total posts
    $totalPosts = count($posts);

    // Fetch posts_per_page from the database
    $postsPerPage = DB::table('general_settings')->where('key', 'posts_per_page')->value('value'); // Get the value column directly

    // Calculate total pages
    $postsPerPage = (int) $postsPerPage;
    $totalPages = ceil($totalPosts / $postsPerPage);

    // Get the current page from the query string, default to 1
    $currentPage = request('page', 1);

    // Validate the current page
    $currentPage = max(1, min($currentPage, $totalPages));

    // Calculate the slice for the current page
    $startIndex = ($currentPage - 1) * $postsPerPage;
    $paginatedPosts = array_slice($posts, $startIndex, $postsPerPage);
@endphp

<!-- masonry -->
<div id="bricks" class="bricks">

    <div class="masonry">

        <div class="bricks-wrapper" data-animate-block>

            <div class="grid-sizer"></div>

            <!-- Display paginated posts -->
            @foreach ($paginatedPosts as $post)
                @include('front.components.single_post_thumbnail', [
                    'src' => $post['src'],
                    'srcset' => $post['srcset'],
                    'title' => $post['title'],
                ])
            @endforeach

        </div> <!-- end bricks-wrapper -->

    </div> <!-- end masonry-->

    <!-- Pagination -->
    <div class="row pagination">
        <div class="column lg-12">
            <nav class="pgn">
                <ul>
                    <li>
                        @if ($currentPage > 1)
                            <a class="pgn__prev"
                                href="{{ url('categories') }}?id={{ $categoryId }}&page={{ $currentPage - 1 }}">Previous</a>
                        @endif
                    </li>

                    @for ($i = 1; $i <= $totalPages; $i++)
                        <li>
                            <a class="{{ $i == $currentPage ? 'current' : '' }}"
                                href="{{ url('categories') }}?id={{ $categoryId }}&page={{ $i }}">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor

                    <li>
                        @if ($currentPage < $totalPages)
                            <a class="pgn__next"
                                href="{{ url('categories') }}?id={{ $categoryId }}&page={{ $currentPage + 1 }}">Next</a>
                        @endif
                    </li>
                </ul>
            </nav>

        </div> <!-- end column -->
    </div> <!-- end pagination -->

</div> <!-- end bricks -->
