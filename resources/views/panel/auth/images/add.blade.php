@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{-- TOASTS --}}
    @include('panel.components.alert_toasts')
    <div class="card mb-4">
        <h5 class="card-header">Przesyłanie obrazów</h5>
        {{-- ADD POST --}}
        <form action="{{ route('admin.images.add.post') }}" method="POST" class="card-body m-1" enctype="multipart/form-data">
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
                <input class="form-control" type="file" id="imageFilesMultiple" name="imageFilesMultiple[]" multiple>
            </div>

            <div id="imageMetadataContainer">
                {{-- <p>Po dodaniu plików, wprowadź tytuły i opisy:</p> --}}
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

    let filesList = []; // Keep files to send

    inputFile.addEventListener('change', (event) => {
        metadataContainer.innerHTML = ''; // reset form
        filesList = Array.from(event.target.files); // Keep files at local array

        filesList.forEach((file, index) => {
            const reader = new FileReader();

            // Show preview
            reader.onload = (e) => {
                const metadataBlock = document.createElement('div');
                metadataBlock.classList.add('mb-3', 'border', 'p-3', 'rounded', 'shadow-sm');
                metadataBlock.setAttribute('data-file-index', index);

                metadataBlock.innerHTML = `
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <img src="${e.target.result}" alt="Podgląd obrazu ${file.name}" class="img-thumbnail" style="min-width: 100px; max-width: 200px; height: auto;">
                        </div>
                        <div class="col-md-7">
                            <label for="title_${index}" class="form-label">Tytuł dla "${file.name}"</label>
                            <input type="text" class="form-control" id="title_${index}" name="titles[]" placeholder="Wprowadź tytuł" required>
                            <label for="label_${index}" class="form-label mt-2">Opis dla "${file.name}"</label>
                            <textarea class="form-control" name="labels[]" id="label_${index}" rows="3"></textarea>
                        </div>
                        <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-danger btn-sm remove-file-btn" data-file-index="${index}">
                                Usuń
                            </button>
                        </div>
                    </div>
                `;
                metadataContainer.appendChild(metadataBlock);
            };

            // Read file as data URL
            reader.readAsDataURL(file);
        });
    });

    // Handle deleting file from preview
    metadataContainer.addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-file-btn')) {
            const fileIndex = parseInt(event.target.getAttribute('data-file-index'));
            filesList = filesList.filter((_, index) => index !== fileIndex); // remove file from list
            const blockToRemove = metadataContainer.querySelector(`[data-file-index="${fileIndex}"]`);
            blockToRemove.remove(); // remove row from view
        }
    });
</script>


@include('panel.auth.footer')
