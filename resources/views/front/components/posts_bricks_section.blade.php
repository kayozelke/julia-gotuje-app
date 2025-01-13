<!-- masonry -->
<div id="bricks" class="bricks">

    <div class="masonry">

        <div class="bricks-wrapper" data-animate-block>

            <div class="grid-sizer"></div>

            @php
                $posts = [
                    [
                        'src' => 'front/images/thumbs/masonry/statue-600.jpg',
                        'srcset' =>
                            'front/images/thumbs/masonry/statue-600.jpg 1x, front/images/thumbs/masonry/statue-1200.jpg 2x',
                        'title' => 'Just a Normal Simple Blog Post',
                    ],
                    [
                        'src' => 'front/images/thumbs/masonry/beetle-600.jpg',
                        'srcset' =>
                            'front/images/thumbs/masonry/beetle-600.jpg 1x, front/images/thumbs/masonry/beetle-1200.jpg 2x',
                        'title' => 'Throwback To The Good Old Days.',
                    ],
                    [
                        'src' => 'front/images/thumbs/masonry/grayscale-600.jpg',
                        'srcset' =>
                            'front/images/thumbs/masonry/statue-600.jpg 1x, front/images/thumbs/masonry/statue-1200.jpg 2x',
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
                        'srcset' =>
                            'front/images/thumbs/masonry/tulips-600.jpg 1x, front/images/thumbs/masonry/tulips-1200.jpg 2x',
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
                        'srcset' =>
                            'front/images/thumbs/masonry/books-600.jpg 1x, front/images/thumbs/masonry/books-1200.jpg 2x',
                        'title' => 'What Does Reading Do to Your Brain?',
                    ],
                    [
                        'src' => 'front/images/thumbs/masonry/lamp-600.jpg',
                        'srcset' =>
                            'front/images/thumbs/masonry/lamp-600.jpg 1x, front/images/thumbs/masonry/lamp-1200.jpg 2x',
                        'title' => 'Symmetry In Modern Design.',
                    ],
                    [
                        'src' => 'front/images/thumbs/masonry/clock-600.jpg',
                        'srcset' =>
                            'front/images/thumbs/masonry/clock-600.jpg 1x, front/images/thumbs/masonry/clock-1200.jpg 2x',
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
                        'srcset' =>
                            'front/images/thumbs/masonry/wheel-600.jpg 1x, front/images/thumbs/masonry/wheel-1200.jpg 2x',
                        'title' => 'Black And White Photography Tips.',
                    ],
                ];
            @endphp

            @foreach ($posts as $post)
                @include('front.components.single_post_thumbnail', [
                    'src' => $post['src'],
                    'srcset' => $post['srcset'],
                    'title' => $post['title'],
                ])
            @endforeach

        </div> <!-- end bricks-wrapper -->

    </div> <!-- end masonry-->

    <!-- pagination -->
    <div class="row pagination">
        <div class="column lg-12">
            <nav class="pgn">
                <ul>
                    <li>
                        <a class="pgn__prev" href="#0">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" d="M10.25 6.75L4.75 12L10.25 17.25"></path>
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" d="M19.25 12H5"></path>
                            </svg>
                        </a>
                    </li>
                    <li><a class="pgn__num" href="#0">1</a></li>
                    <li><span class="pgn__num current">2</span></li>
                    <li><a class="pgn__num" href="#0">3</a></li>
                    <li><a class="pgn__num" href="#0">4</a></li>
                    <li><a class="pgn__num" href="#0">5</a></li>
                    <li><span class="pgn__num dots">…</span></li>
                    <li><a class="pgn__num" href="#0">8</a></li>
                    <li>
                        <a class="pgn__next" href="#0">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" d="M13.75 6.75L19.25 12L13.75 17.25"></path>
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" d="M19 12H4.75"></path>
                            </svg>
                        </a>
                    </li>
                </ul>
            </nav> <!-- end pgn -->
        </div> <!-- end column -->
    </div> <!-- end pagination -->

</div> <!-- end bricks -->
