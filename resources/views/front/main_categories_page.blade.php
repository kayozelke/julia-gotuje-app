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
                {{-- <div class="row u-add-bottom">
                    <div class="column lg-12">
                        <h3>Wyróżnione kategorie</h3>
                        <p>Polecane, ulubione przez Was kategorie przepisów</p>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nazwa</th>
                                    </tr>
                                </thead>
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
                </div> <!-- end row --> --}}

                {{-- table with standard categories --}}
                <div class="row u-add-bottom">
                    <div class="column lg-12">
                        <h3>Wszystkie kategorie przepisów</h3>
                        <div class="table-responsive">
                            <table>
                                {{-- <thead>
                                    <tr>
                                        <th>Nazwa</th>
                                    </tr>
                                </thead> --}}
                                <tbody>
                                    @forelse ($subcategories as $category)
                                        <tr>
                                            <td>
                                                {{-- Link to the category page --}}
                                                <a href="{{ route('categories', ['id' => $category->id]) }}"
                                                    style="text-decoration: none; color: inherit;">
                                                    {{ $category->name }}
                                                </a>

                                                {{-- Badge with sub posts counter --}}
                                                <span class="badge rounded-pill bg-light text-dark">
                                                    {{ $category->post_count ?? 0 }}
                                                </span>
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
