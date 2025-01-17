@include('panel.auth.header')

<link href="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/css/suneditor.min.css" rel="stylesheet">
<!-- <link href="https://cdn.jsdelivr.net/npm/suneditor@latest/assets/css/suneditor.css" rel="stylesheet"> -->
<!-- <link href="https://cdn.jsdelivr.net/npm/suneditor@latest/assets/css/suneditor-contents.css" rel="stylesheet"> -->
<script src="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/suneditor.min.js"></script>
<!-- languages (Basic Language: English/en) -->
<script src="https://cdn.jsdelivr.net/npm/suneditor@latest/src/lang/pl.js"></script>

<div class="container-xxl flex-grow-1 container-p-y">
    {{-- TOASTS --}}
    @include('panel.components.alert_toasts')
    <div class="card mb-4">
        <h5 class="card-header">Dodawanie posta</h5>

        {{-- ADD POST --}}
        <form action="{{ route('admin.posts.add.post') }}" method="POST" class="card-body m-1" id="postForm">
            @csrf
            {{-- <div class="card-body m-1"> --}}
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

            @if ($is_new_post == false)
                <input type="hidden" name="update_id" value="{{ $post_to_update->id }}">
            @endif


            <div class="row">
                    {{-- title --}}

                <div class="col-md-6">
                    <div class="card mb-4">
                        <h5 class="card-header">Tytuł wpisu</h5>
                        <div class="card-body">
                            <div>
                                {{-- <label for="defaultFormControlInput" class="form-label">Adres podstrony dopisywany do adresu URL strony</label> --}}
                                <input type="text" class="form-control" id="title" {{-- placeholder="John Doe"  --}}
                                    name="title" aria-describedby="titleOfPost" required {{-- autocomplete="off"  --}}
                                    value="{{ $is_new_post == false ? $post_to_update->title : '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- custom url --}}

                <div class="col-md-6">
                    <div class="card mb-4">
                        <h5 class="card-header">Adres podstrony</h5>
                        <div class="card-body">
                            <div>
                                {{-- <label for="defaultFormControlInput" class="form-label">Adres podstrony dopisywany do adresu URL strony</label> --}}
                                <input type="text" class="form-control" id="custom_url" name="custom_url"
                                    {{-- placeholder="John Doe"  --}} pattern="[a-z0-9\-]+" aria-describedby="customUrlOfPost"
                                    required {{-- autocomplete="off" --}}
                                    value="{{ $is_new_post == false ? $post_to_update->url : '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- typ --}}

                <div class="col-md-6">
                    <div class="card mb-4">
                        <h5 class="card-header">Rodzaj</h5>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="template_type" class="form-label">Typ wpisu</label>
                                <select class="form-select" id="template_type" aria-label="Template type"
                                    name="template_type">
                                    {{-- <option selected="">Open this select menu</option> --}}
                                    <option value="recipe"
                                        {{ $is_new_post == false && $post_to_update->template_type == 'recipe' ? 'selected=""' : '' }}>
                                        Przepis</option>
                                    <option value="default"
                                        {{ $is_new_post == false && $post_to_update->template_type == 'default' ? 'selected=""' : '' }}>
                                        Zwykły wpis</option>
                                    {{-- <option value="3">Three</option> --}}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- kategoria --}}

                <div class="col-md-6">
                    <div class="card mb-4">
                        <h5 class="card-header">Kategoria</h5>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="parent_category_id" class="form-label">Wybór kategorii nadrzędnej</label>
                                <select class="form-select" id="parent_category_id" aria-label="Category select"
                                    name="parent_category_id">
                                    <option value="0">Brak (post niewidoczny w kategoriach)</option>
                                    {{-- <option value="3">Three</option> --}}
                                    @foreach ($all_categories as $c)
                                        <option value="{{ $c['id'] }}"
                                            {{ $is_new_post == false && $post_to_update->parent_category_id == $c['id'] ? 'selected=""' : '' }}>
                                            {{ $c['parent_categories_str'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                {{-- Treść wpisu --}}

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Treść wpisu</h5>
                        <div class="card-body">
                            {{-- <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label> --}}
                            {{-- <textarea class="form-control" name="post_content" id="post_content" rows="3" style="height: 282px;"></textarea> --}}

                            <input type="hidden" name="post_content" id="postContent">
                            <textarea id="sunEditorTextArea" style="width:100%;"></textarea>
                        </div>
                    </div>
                </div>
            </div>

                {{-- Czas publikacji --}}

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h4 class="card-header">Czas publikacji</h4>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 d-flex align-items-center">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="use_hide_before_time" id="use_hide_before_time"
                                            {{ $is_new_post == false && $post_to_update->hide_before_time != null ? 'checked' : '' }}>
                                        <label class="form-check-label" for="use_hide_before_time">Opublikuj
                                            później</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" type="datetime-local" id="hide_before_time" name="hide_before_time"
                                        value="{{ $is_new_post == false ? $post_to_update->hide_before_time : '' }}"
                                        {{ $is_new_post == true ? 'disabled' : ($post_to_update->hide_before_time != null ? '' : 'disabled') }}>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                {{-- inne --}}

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h4 class="card-header">Inne</h4>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 d-flex align-items-center">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_hidden"
                                            {{ $is_new_post == false && $post_to_update->is_hidden == 1 ? 'checked' : '' }}
                                            id="is_hidden">
                                        <label class="form-check-label" for="is_hidden">Ukryj post na stałe</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h4 class="card-header">Galeria</h4>
                        <div class="card-body">
                            <!-- Dropdown to select new images -->
                            <div>
                                <label for="image-selector">Dodaj obraz:</label>
                                <select id="image-selector">
                                    <option value="" disabled selected>Wybierz obraz</option>
                                    @foreach($all_images as $image)
                                        <option value="{{ $image->id }}" data-src="{{ asset('storage/' . $image->path) }}">
                                            {{ $image->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
        
                            <!-- Dynamic list of selected images -->
                            <div>
                                <h5>Wybrane obrazy:</h5>
                                <ul id="selected-images-list" style="list-style-type: none; padding: 0;">
                                    @if(!empty($image->imagesByPriority) && $image->imagesByPriority->isNotEmpty())
                                        @foreach($image->imagesByPriority as $image)
                                            <li data-id="{{ $image->id }}">
                                                <img src="" alt="{{ $image->title }}" style="width: 100px; height: auto; margin-right: 10px;">
                                                {{ $image->title }}
                                                <button type="button" onclick="removeImage(this)">Usuń</button>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
        
                            <!-- Hidden input to store selected images -->
                            <input type="hidden" name="selected_images" id="selected-images" value="{{ !empty($image->imagesByPriority) ? implode(',', $image->imagesByPriority->pluck('id')->toArray()) : '' }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row text-center">
                <div class="col">
                    <button type="submit" class="btn btn-success mx-2" role="button">Zapisz</button>
                </div>
                <div class="col">
                    <a href="{{ $backPage }}" class="btn btn-secondary mx-2">Anuluj</a>
                </div>

            </div>

        </form>

    </div>

</div>

@include('panel.auth.footer')

{{-- script to handle hide before time fields --}}
<script>
    const useHideBeforeTimeCheckbox = document.getElementById('use_hide_before_time');
    const hideBeforeTimeInput = document.getElementById('hide_before_time');

    useHideBeforeTimeCheckbox.addEventListener('change', () => {
        if (hideBeforeTimeInput) {
            if (useHideBeforeTimeCheckbox.checked) {
                hideBeforeTimeInput.value = new Date().toISOString().slice(0, 16);
                hideBeforeTimeInput.disabled = false;
            } else {
                hideBeforeTimeInput.value = null;
                hideBeforeTimeInput.disabled = true;
            }
        } else {
            console.warn('hideBeforeTimeInput is null');
        }
    });
</script>

{{-- script to handle custom url field --}}
<script>
    const titleInput = document.getElementById('title');
    const customUrlInput = document.getElementById('custom_url');

    titleInput.addEventListener('input', () => {
        generateUrl();
    })

    function generateUrl() {
        // console.log('generateUrl()');
        const title = titleInput.value;
        // build url with param
        const url = `/api/generate_page_url?text=${encodeURIComponent(title)}`;

        fetch(url, {
                method: 'GET',
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                customUrlInput.value = data.page_url;
            })
            .catch(error => console.error('Error:', error));
    }
</script>

{{-- script for sun editor + form submit handler --}}
<script>
    // /**
    // * ID : 'suneditor_sample'
    // * ClassName : 'sun-eidtor'
    // */
    // // ID or DOM object
    const editor = SUNEDITOR.create((document.getElementById('sunEditorTextArea') || 'sunEditorTextArea'), {
        // All of the plugins are loaded in the "window.SUNEDITOR" object in dist/suneditor.min.js file
        // Insert options
        // Language global object (default: en)
        lang: SUNEDITOR_LANG['pl'],
        buttonList: [
            ['undo', 'redo'],
            ['font', 'fontSize', 'formatBlock'],
            ['paragraphStyle', 'blockquote'],
            ['bold', 'underline', 'italic', 'strike', 'subscript', 'superscript'],
            ['fontColor', 'hiliteColor', 'textStyle'],
            ['align', 'horizontalRule', 'list', 'lineHeight'],
            ['outdent', 'indent'],
            ['table', 'link', 'image', 'video', 'audio'],
            ['fullScreen', 'showBlocks', 'codeView'],
            ['preview', 'print'],
            ['removeFormat']
        ],
        imageFileInput: false,
        minHeight: '450px',
        maxCharCount: 10000,
    });


    // post update setting
    @if ($is_new_post == false)
        let existingContent = @json($post_to_update->content);
        editor.setContents(existingContent);
    @endif

    
    // form submit handling

    const form = document.getElementById('postForm');

    // Add submit handler
    form.addEventListener('submit', function(event) {
        const content = editor.getContents();
        // set hidden field content
        document.getElementById('postContent').value = content;
    });
</script>

{{-- script for gallery picker --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const imageSelector = document.getElementById('image-selector');
        const selectedImagesList = document.getElementById('selected-images-list');
        const selectedImagesInput = document.getElementById('selected-images');

        // Function to add a new image to the list
        imageSelector.addEventListener('change', function () {
            const selectedOption = imageSelector.options[imageSelector.selectedIndex];
            const imageId = selectedOption.value;
            const imageSrc = selectedOption.getAttribute('data-src');
            const imageTitle = selectedOption.text;

            // Check if the image is already in the list
            if (Array.from(selectedImagesList.children).some(li => li.getAttribute('data-id') === imageId)) {
                alert('Ten obraz już znajduje się na liście.');
                return;
            }

            // Create a new list item
            const listItem = document.createElement('li');
            listItem.setAttribute('data-id', imageId);
            listItem.innerHTML = `
                <img src="${imageSrc}" alt="${imageTitle}" style="width: 100px; height: auto; margin-right: 10px;">
                ${imageTitle}
                <button type="button" onclick="removeImage(this)">Usuń</button>
            `;

            // Add the list item to the list
            selectedImagesList.appendChild(listItem);

            // Update the hidden input value
            updateSelectedImages();
        });

        // Function to remove an image from the list
        window.removeImage = function (button) {
            const listItem = button.parentElement;
            listItem.remove();
            updateSelectedImages();
        };

        // Function to update the hidden input value
        function updateSelectedImages() {
            const selectedIds = Array.from(selectedImagesList.children).map(li => li.getAttribute('data-id'));
            selectedImagesInput.value = selectedIds.join(',');
        }
    });
</script>