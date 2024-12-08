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
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item active" aria-current="page">Home</li>
                                            </ol>
                                        </nav>

                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Library</li>
                                            </ol>
                                        </nav>

                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                                <li class="breadcrumb-item"><a href="#">Library</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Data</li>
                                            </ol>
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
