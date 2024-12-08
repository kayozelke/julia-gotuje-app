@include('front.header')

<!-- # site-content
        ================================================== -->
<div id="content" class="s-content">

    <div class="row entry-wrap">
        <div class="column lg-12">
            <article class="entry">

                <header class="entry__header entry__header--narrower">
                    <h1 class="entry__title">
                        Strona podkategorii przepisów
                    </h1>
                </header>

                {{-- table with standard categories --}}
                <div class="row u-add-bottom">
                    <div class="column lg-12">
                        <h3>
                            Wszystkie podkategorie
                            @if ($parent_category)
                                z kategorii: {{ $parent_category->name }}
                            @else
                                tej kategorii przepisów
                            @endif
                        </h3>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <!-- Breadcrumb with slashes -->
                                        <nav aria-label="breadcrumb">
                                            <ul class="breadcrumb">
                                                @if (count($recurrent_parent_categories) == 0)
                                                    <li class="breadcrumb-item active">Wszystko</li>
                                                @else
                                                    <li class="breadcrumb-item">
                                                        <a href="{{ route('top_categories') }}">Wszystko</a>
                                                    </li>

                                                    {{-- Iterate through parent categories and add '/' as separator --}}
                                                    @foreach (array_reverse($recurrent_parent_categories) as $par_category)
                                                        <li
                                                            class="breadcrumb-item @if ($par_category->id == $current_category_id) active @endif">
                                                            <a
                                                                href="{{ route('categories', ['id' => $par_category->id]) }}">
                                                                {{ $par_category->name }}
                                                            </a>
                                                        </li>
                                                        {{-- Add a separator after each category except the last one --}}
                                                        @if (!$loop->last)
                                                            <span>/</span>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </nav>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($subcategories as $category)
                                        {{-- Iterate over subcategories --}}
                                        <tr>
                                            <td>
                                                {{-- Link to the category page --}}
                                                <a href="{{ route('categories', ['id' => $category->id]) }}">
                                                    {{ $category->name }}
                                                </a>
                                            </td>
                                        </tr>
                                    @empty {{-- Handle the case when there are no categories --}}
                                        <tr>
                                            <td colspan="1">Brak kategorii do wyświetlenia.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end row -->


            </article> <!-- end entry -->
        </div>

    </div> <!-- end entry-wrap -->

    {{-- category posts --}}
    @include('front.posts_bricks_section')

</div> <!-- end s-content -->

@include('front.footer')
