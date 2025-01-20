@php
    use Illuminate\Support\Facades\DB;

    // Total posts
    // $totalPosts = $posts->count(); // Użyj metody count() dla kolekcji Eloquent
    $totalPosts = count($posts); // Użyj metody count() dla kolekcji Eloquent

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
    // $paginatedPosts = $posts->slice($startIndex, $postsPerPage); // Użyj slice dla kolekcji
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
                    'url' => $post['url'],
                ])
            @endforeach

        </div> <!-- end bricks-wrapper -->

    </div> <!-- end masonry-->

    <!-- Pagination -->
    <div class="row pagination">
        <div class="column lg-12">
            <nav class="pgn">
                <ul>
                    <!-- Previous Button -->
                    @if ($currentPage > 1)
                        <li>
                            <a class="pgn__prev"
                                href="?{{ http_build_query(request()->except('page')) }}&page={{ $currentPage - 1 }}">
                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5" d="M10.25 6.75L4.75 12L10.25 17.25"></path>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5" d="M19.25 12H5"></path>
                                </svg>
                            </a>
                        </li>
                    @endif

                    <!-- Page Numbers -->
                    @for ($i = 1; $i <= $totalPages; $i++)
                        @if ($i == $currentPage)
                            <li><span class="pgn__num current">{{ $i }}</span></li>
                        @else
                            <li>
                                <a class="pgn__num"
                                    href="?{{ http_build_query(request()->except('page')) }}&page={{ $i }}">
                                    {{ $i }}
                                </a>
                            </li>
                        @endif
                    @endfor

                    <!-- Next Button -->
                    @if ($currentPage < $totalPages)
                        <li>
                            <a class="pgn__next"
                                href="?{{ http_build_query(request()->except('page')) }}&page={{ $currentPage + 1 }}">
                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5" d="M13.75 6.75L19.25 12L13.75 17.25"></path>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5" d="M19 12H4.75"></path>
                                </svg>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>

        </div> <!-- end column -->
    </div> <!-- end pagination -->

</div> <!-- end bricks -->
