@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{-- TOASTS --}}
    @include('panel.components.alert_toasts')

    <div class="card mb-4">
        <h4 class="card-header">Edycja danych obrazu '{{ $image->title }}'</h4>
        <div class="card-body col-md-10 py-2">
            <form action="{{ route('admin.images.update.post') }}" method="POST">
                @csrf
                
                <input type="hidden" class="form-control" id="update_id" name="update_id"
                value="{{ $image->id }}">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="align-middle"><small class="text-light fw-semibold">Tytuł</small></td>
                            <td class="py-3">
                                {{-- <p class="mb-0">{{ $image->label }}</p> --}}
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Wprowadź tytuł" required value="{{ $image->title }}">
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle"><small class="text-light fw-semibold">Opis</small></td>
                            <td class="py-3">
                                {{-- <p class="mb-0">{{ $image->label }}</p> --}}
                                <textarea class="form-control" name="label" id="label" rows="3" placeholder="Wprowadź opis">{{ $image->label }}</textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row text-center">
                    <div class="col">
                        <button type="submit" class="btn btn-success" role="button">Zapisz</button>
                    </div>
                    <div class="col">
                        <a href="{{ route('admin.images.show', ['id' => $image->id]) }}"
                            class="btn btn-secondary">Anuluj</a>
                    </div>
                </div>
            </form>
        </div>

        {{-- <div class="card-body text-center">
            <a href="{{ $image->file_location }}"><img src="{{ $image->file_location }}" alt="{{ $image->title }}" style="min-width: 30%; max-height: 60%; max-width: 60%; object-fit: contain;"></a>
        </div> --}}


    </div>

    <div class="card mb-4">
        <h6 class="card-header text-center">Podgląd obrazu</h6>
        <div class="card-body text-center">
            <a href="{{ $image->file_location }}"><img src="{{ $image->file_location }}" alt="{{ $image->title }}"
                    style="min-width: 30%; max-height: 60%; max-width: 60%; object-fit: contain;"></a>
        </div>
    </div>


</div>

@include('panel.auth.footer')
