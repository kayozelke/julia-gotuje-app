@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{-- TOASTS --}}
    @include('panel.components.alert_toasts')
    <div class="card mb-4">
        <h5 class="card-header">Przesyłanie obrazów</h5>
        {{-- ADD POST --}}
        <form action="{{ route('admin.images.add.post') }}" method="POST" class="card-body m-1">
            @csrf
            {{-- ########################## --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- ########################## --}}

            <div class="mb-3">
                <label for="imageFilesMultiple" class="form-label">Przesyłanie jednego lub wielu obrazów</label>
                <input class="form-control" type="file" id="imageFilesMultiple" name="imageFilesMultiple[]" multiple="">
            </div>

            <div id="imageMetadataContainer">
                <p>Po dodaniu plików, wprowadź tytuły i opisy:</p>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-success" role="button">Zapisz</button>
            </div>

        </form>
    </div>
</div>

{{-- script for images metadata --}}
<script>
    const inputFile = document.getElementById('imageFilesMultiple');
    const metadataContainer = document.getElementById('imageMetadataContainer');

    inputFile.addEventListener('change', (event) => {
        metadataContainer.innerHTML = ''; // Reset formularza
        Array.from(event.target.files).forEach((file, index) => {
            const metadataBlock = document.createElement('div');
            metadataBlock.classList.add('mb-3');

            metadataBlock.innerHTML = `
                <label for="title_${index}" class="form-label">Tytuł dla "${file.name}"</label>
                <input type="text" class="form-control" id="title_${index}" name="titles[]" placeholder="Wprowadź tytuł">
                
                <label for="label_${index}" class="form-label mt-2">Opis dla "${file.name}"</label>
                <input type="text" class="form-control" id="label_${index}" name="labels[]" placeholder="Wprowadź opis">
            `;
            metadataContainer.appendChild(metadataBlock);
        });
    });
</script>


@include('panel.auth.footer')
