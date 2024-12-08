@include('front.header')

<!-- # site-content
        ================================================== -->
<div id="content" class="s-content">

    <div class="row entry-wrap">
        <div class="column lg-12">
            <article class="entry">

                <header class="entry__header entry__header--narrower">
                    <h1 class="entry__title">
                        {{-- Strona podkategorii przepisów --}}
                        @if ($parent_category)
                            {{ $parent_category->name }}
                        @else
                            Strona podkategorii przepisów
                        @endif
                    </h1>
                </header>

                {{-- table with standard categories --}}
                <div class="row u-add-bottom">
                    <div class="column lg-12">
                        <h3>
                            {{-- Wszystkie podkategorie
                            @if ($parent_category)
                                z kategorii: {{ $parent_category->name }}
                            @else
                                tej kategorii przepisów
                            @endif --}}

                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb"
                                    style="list-style: none; padding: 0; margin: 0; display: inline;">
                                    @if (count($recurrent_parent_categories) == 0)
                                        <li class="breadcrumb-item active" style="display: inline;">Wszystko
                                        </li>
                                    @else
                                        <li class="breadcrumb-item" style="display: inline;">
                                            <a href="{{ route('top_categories') }}"
                                                style="text-decoration: none; color: inherit;">
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
                                    @endif
                                </ol>
                            </nav>
                        </h3>
                        <div class="table-responsive">
                            <table>
                                {{-- <thead>
                                    <tr>
                                    </tr>
                                </thead> --}}
                                <tbody>
                                    @forelse ($subcategories as $category)
                                        {{-- Iterate over subcategories --}}
                                        <tr>
                                            <td>
                                                {{-- Link to the category page --}}
                                                <a href="{{ route('categories', ['id' => $category->id]) }}"
                                                    style="text-decoration: none; color: inherit;">
                                                    {{ $category->name }}
                                                </a>
                                            </td>
                                        </tr>
                                    @empty {{-- Handle the case when there are no categories --}}
                                        <tr>
                                            <td colspan="1">Brak podrzędnych kategorii do wyświetlenia.</td>
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
