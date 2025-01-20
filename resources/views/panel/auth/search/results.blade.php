@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{-- TOASTS --}}
    @include('panel.components.alert_toasts')

    <!-- Hoverable Table rows -->
    <div class="card">
        <h5 class="card-header">Wyniki dla <em>{{ $search_query }}</em></h5>
        <div class="table-responsive text-nowrap mx-3 my-2">
            <table class="table table-hover" id="dataTableElement">
                <thead>
                    <tr>
                        <th>Typ</th>
                        {{-- Value --}}
                        <th>Tytuł</th>
                        {{-- Description --}}
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($search_results as $result)
                        <tr>
                            <td><strong>{{ $result->'type' }}</strong></td>
                            <td class="long-text-cell">
                                <a href="{{ $result->url }}">{{ $result->title }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!--/ Hoverable Table rows -->
</div>

@include('panel.auth.footer')

@include('panel.components.datatable_handler')
