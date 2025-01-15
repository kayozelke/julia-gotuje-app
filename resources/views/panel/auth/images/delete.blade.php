@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{-- TOASTS --}}
    @include('panel.components.alert_toasts')

    <div class="card mb-4">
        <h5 class="card-header">Czy na pewno chcesz usunąć obraz '{{ $image->title }}'?</h5>

        <div class="card mx-3 p-2 text-center">
            <a href="{{ $image->file_location }}"><img src="{{ $image->file_location }}" alt="{{ $image->title }}"
                    style="min-width: 40%; max-height: 60%; max-width: 60%; object-fit: contain;"></a>
        </div>

        <div class="card-body text-center">
            <form action="{{ route('admin.images.delete.post') }}" method="POST">
                @csrf
                <input type="hidden" name="delete_id" value="{{ $image->id }}" id="delete_id">
                <button type="submit" class="btn btn-danger mx-2" role="button">Usuń</button>
            </form>
        </div>


    </div>


</div>

@include('panel.auth.footer')
