@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{-- TOASTS --}}
    @include('panel.components.alert_toasts')
    <div class="card mb-4">
        <h5 class="card-header">Przesyłanie obrazów</h5>
        {{-- ADD POST --}}
        <form action="{{ route('admin.posts.add.post') }}" method="POST" class="card-body m-1">
            @csrf

            <div class="mb-3">
                <label for="imageFilesMultiple" class="form-label">Przesyłanie jednego lub wielu obrazów</label>
                <input class="form-control" type="file" id="imageFilesMultiple" name="imageFilesMultiple" multiple="">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-success mx-2" role="button">Dodaj</button>
            </div>

        </form>
    </div>
</div>

@include('panel.auth.footer')
