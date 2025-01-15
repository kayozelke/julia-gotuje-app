
@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{--  --}}
    @include('panel.components.alert_toasts')

    <div class="card mb-4">
        <h5 class="card-header">Obrazy</h5>
        <div class="card-body m-1">
            <div class="d-flex justify-content-between">
                <a type="button" class="btn btn-primary me-auto mx-1" href="{{ route('admin.images.add') }}">
                    Prześlij obrazy
                </a>
            </div>
        </div>
        <hr>
        <div class="card-body m-1">
            <div class="table-responsive">
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
                                {{-- <td><a href="{{ $image->file_location }}"><img src="{{ $image->file_location }}" alt="{{ $image->title }}" width="100"></a></td> --}}
                                <td class="d-flex justify-content-center">
                                    <a href="{{ route('admin.images.show', ['id' => $image->id]) }}"><img src="{{ $image->file_location }}" alt="{{ $image->title }}" style="min-width: 100px; max-width: 150px; height: auto;"></a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.images.show', ['id' => $image->id]) }}">{{ $image->title }}</a>
                                </td>
                                <td>{{ $image->label }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>


</div>

@include('panel.auth.footer')

