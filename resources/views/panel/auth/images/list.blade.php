
@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{--  --}}
    @include('panel.components.alert_toasts')

    <div class="card mb-4">
        <h5 class="card-header">Obrazy</h5>
        <div class="card-body py-2">
            <a type="button" class="btn btn-primary me-auto" href="{{ route('admin.images.add') }}">
                Prześlij obrazy
            </a>
        </div>
        <hr>
        <div class="card-body m-1">

            <form method="GET" action="{{ route('admin.images.index') }}" class="mb-3">
                <label for="per_page">Liczba elementów na stronę:</label>
                <select name="per_page" id="per_page" onchange="this.form.submit()">
                    <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
            </form>

            @include('panel.auth.images.components.paginated-table')

            {{-- <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Zdjęcie</th>
                            <th>Tytuł</th>
                            <th>Opis</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($images as $image)
                            <tr>
                                <td class="d-flex justify-content-center">
                                    <a href="{{ route('admin.images.show', ['id' => $image->id]) }}"><img src="{{ $image->file_location }}" alt="{{ $image->title }}" style="min-width: 100px; max-width: 150px; height: auto;"></a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.images.show', ['id' => $image->id]) }}">
                                        <strong>{{ $image->title }}</strong>
                                    </a>
                                </td>
                                <td>{{ $image->label }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> --}}

        </div>
    </div>


</div>

@include('panel.auth.footer')

