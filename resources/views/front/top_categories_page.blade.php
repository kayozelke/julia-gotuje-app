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

                {{-- table with highlited categories --}}
                <div class="row u-add-bottom">
                    <div class="column lg-12">
                        <h3>Wyróżnione kategorie</h3>
                        {{-- <p>Polecane, ulubione przez Was kategorie przepisów</p> --}}
                        <div class="table-responsive">
                            <table>
                                {{-- <thead>
                                    <tr>
                                        <th>Nazwa</th>
                                    </tr>
                                </thead> --}}
                                <tbody>
                                    <tr>
                                        <td>Desery zimowe</td>
                                    </tr>
                                    <tr>
                                        <td>Dania wegetariańskie</td>
                                    </tr>
                                    <tr>
                                        <td>Zupy krem</td>
                                    </tr>
                                    <tr>
                                        <td>Dania kuchni włoskiej</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end row -->

                {{-- table with standard categories --}}
                <div class="row u-add-bottom">
                    <div class="column lg-12">
                        <h3>Wszystkie kategorie</h3>
                        <div class="table-responsive">
                            <table>
                                {{-- <thead>
                                    <tr>
                                        <th>Nazwa</th>
                                    </tr>
                                </thead> --}}
                                <tbody>
                                    @forelse ($categories as $category)
                                        {{-- Iteracja po kategoriach --}}
                                        <tr>
                                            <td>
                                                {{-- Link do strony kategorii --}}
                                                <a href="{{ route('categories.show', ['id' => $category->id]) }}">
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

</div> <!-- end s-content -->

@include('front.footer')
