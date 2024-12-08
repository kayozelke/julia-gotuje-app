@include('front.header')

<!-- # site-content
        ================================================== -->
<div id="content" class="s-content">

    <div class="row entry-wrap">
        <div class="column lg-12">
            <article class="entry">

                <header class="entry__header entry__header--narrower">
                    <h1 class="entry__title">
                        Strona główna kategorii przepisów
                    </h1>
                </header>

                {{-- table with standard categories --}}
                <div class="row u-add-bottom">
                    <div class="column lg-12">
                        <h3>Wszystkie podkategorie tej kategorii przepisów</h3>
                        <div class="table-responsive">
                            <table>
                                {{-- <thead>
                                    <tr>
                                        <th>Nazwa</th>
                                    </tr>
                                </thead> --}}
                                <tbody>
                                    @forelse ($subcategories as $category)
                                        {{-- Iteracja po kategoriach --}}
                                        <tr>
                                            <td>
                                                {{-- Link do strony kategorii --}}
                                                <a href="{{ route('front.categories', ['id' => $category->id]) }}">
                                                    {{ $category->name }}
                                                </a>
                                            </td>
                                        </tr>
                                    @empty {{-- Obsługa przypadku, gdy brak kategorii --}}
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
