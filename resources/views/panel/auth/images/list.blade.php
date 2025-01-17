
@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    
    @include('panel.components.alert_toasts')

    <div class="card mb-4">
        <h5 class="card-header">Obrazy</h5>
        <div class="card-body py-2">
            <a type="button" class="btn btn-primary me-auto" href="{{ route('admin.images.add') }}">
                Prześlij obrazy
            </a>
        </div>
        <hr>
        <div class="card-body py-1">

            <form method="GET" action="{{ route('admin.images') }}" class="mb-1">
                <label for="per_page">Liczba elementów na stronę:</label>
                <select name="per_page" id="per_page" onchange="this.form.submit()">
                    <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Zdjęcie</th>
                            <th>Tytuł</th>
                            <th>Opis</th>
                            <th>Dodano</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($images as $image)
                            <tr>
                                <td>{{ $image->id }}</td>
                                <td class="d-flex justify-content-center">
                                    <a href="{{ route('admin.images.show', ['id' => $image->id]) }}">
                                        <img src="{{ $image->file_location }}" alt="{{ $image->title }}" style="min-width: 100px; max-width: 150px; height: auto;">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.images.show', ['id' => $image->id]) }}">
                                        <strong>{{ $image->title }}</strong>
                                    </a>
                                </td>
                                <td>{{ $image->label }}</td>
                                <td>{{ $image->created_at }} <br>przez {{ $image->createdByUser->first_name ?? 'N/A' }} {{ $image->createdByUser->last_name ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            
                {{ $images->links() }}
            </div>

        </div>
    </div>


</div>

@include('panel.auth.footer')

