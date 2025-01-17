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

                {{-- galeria --}}

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h4 class="card-header">Galeria</h4>
                        <div class="card-body">
                            <!-- Dropdown to select new images -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label" for="image-selector">Dodaj obraz</label>
                                <select class="form-select" id="image-selector">
                                    <option value="" disabled selected>Wybierz obraz</option>
                                    @foreach($all_images as $image)
                                        <option value="{{ $image->id }}" data-src="{{ $image->file_location }}" data-label="{{ $image->label }}">
                                            {{ $image->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
        
                            <!-- Dynamic list of selected images -->
                            {{-- <div class="p-5">DEBUG: {{ $post_to_update->imagesByPriority }}</div> --}}
                        </div>
                        <h5 class="card-header pt-2">Wybrane obrazy</h5>
                        <div class="card-body">
                            <div class="row">

                                {{-- <div class="col-md">
                                    <div class="card mb-3">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <img class="card-img card-img-left" src="/uploaded_images/1736964410_220526171611-11-classic-french-dishes-ratatouille.jpg" alt="Card image">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h5 class="card-title">Card title</h5>
                                                    <p class="card-text">
                                                        This is a wider card with supporting text below as a natural lead-in to additional content.
                                                        This content is a little bit longer.
                                                    </p>
                                                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                
                                <ul class="row" id="selected-images-list" style="list-style-type: none;">
                                    @if ($post_to_update != null)
                                        @foreach($post_to_update->imagesByPriority as $image)

                                            <li class="col-md-6" data-id="{{ $image->id }}">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="card mb-3">
                                                            <div class="row g-0">
                                                                <div class="col-md-4 custom-img-cover">
                                                                    <img src="{{ $image->file_location }}" alt="{{ $image->title }}">
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="card-body">
                                                                        
                                                                        {{-- <div class="row">
                                                                            <div class="col">
                                                                                <h5 class="card-title my-0">{{ $image->title }}</h5>
                                                                            </div>
                                                                            <div class="col-sm-2 text-end">
                                                                                <button type="button" class="btn rounded-pill btn-icon btn-sm btn-danger" onclick="removeImage(this)">
                                                                                    <i class='bx bx-x'></i>
                                                                                </button>
                                                                            </div>
                                                                        </div> --}}
    
                                                                        <h5 class="card-title my-0">{{ $image->title }}</h5>
                                                                        
    
                                                                        <p class="card-text">
                                                                            <small>{{ $image->label }}</small>
                                                                        </p>
                                                                        {{-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> --}}
                                
                                                                        <!-- Priority selection -->
                                                                        {{-- <div class="mb-3 row">
                                                                            <label for="html5-number-input" class="col-md-2 col-form-label">Number</label>
                                                                            <div class="col-md-10">
                                                                                <input class="form-control" type="number" value="18" id="html5-number-input">
                                                                            </div>
                                                                        </div> --}}
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">Priorytet</span>
                                                                            <input class="form-control" type="number" name="priority[{{ $image->id }}]" id="priority-{{ $image->id }}"
                                                                                value="{{ $image->priority }}" min="1" max="100" step="1" />
                                                                        </div>
    
                                                                        {{-- <div class="row">
                                                                            <div class="col-md-6">
                                                                                <label class="form-label" for="priority-{{ $image->id }}">Priorytet:</label>
                                                                                <input class="form-control" type="number" name="priority[{{ $image->id }}]" id="priority-{{ $image->id }}"
                                                                                    value="{{ $image->priority }}" min="1" max="100" step="1" />
                                                                            </div>
                                                                            
                                                                            <div class="col-md-6">
                                                                                <button type="button" class="btn btn-sm btn-danger" onclick="removeImage(this)">
                                                                                    <i class='bx bx-x'></i>
                                                                                </button>
                                                                            </div>
                                                                        </div> --}}
                                                                    
    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-2 align-middle text-center">
                                                        <button type="button" class="btn rounded-pill btn-icon btn-sm btn-danger" onclick="removeImage(this)">
                                                            <i class='bx bx-x'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </li>

                                        @endforeach
                                    @endif
                                </ul>

                            </div>
                            
                            {{-- <div>
                                <ul id="selected-images-list" style="list-style-type: none;">
                                    @if ($post_to_update != null)
                                        @foreach($post_to_update->imagesByPriority as $image)
                                            <li data-id="{{ $image->id }}">
                                                <img src="{{ $image->file_location }}" alt="{{ $image->title }}" style="width: 100px; height: auto; margin-right: 10px;">
                                                {{ $image->title }}
                            
                                                <!-- Priority selection -->
                                                <label for="priority-{{ $image->id }}">Priorytet:</label>
                                                <input type="number" name="priority[{{ $image->id }}]" id="priority-{{ $image->id }}" class="image-priority" 
                                                    value="{{ $image->priority }}" min="1" max="100" step="1" />

                            
                                                <button type="button" onclick="removeImage(this)">Usuń</button>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div> --}}
        
                            <!-- Hidden input to store selected images -->
                            <input type="hidden" name="selected_images" id="selected-images" 
                                @if ($post_to_update != null)
                                    value="{{ implode(',', $post_to_update->imagesByPriority->pluck('id')->toArray()) }}"
                                @else value=""
                                @endif
                                >
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

         // Function to reset the image selector to the default option
        function resetImageSelector() {
            imageSelector.selectedIndex = 0;  // Sets the selected option to the first (default) one
        }

        // Function to add a new image to the list
        imageSelector.addEventListener('change', function () {
            const selectedOption = imageSelector.options[imageSelector.selectedIndex];
            const imageId = selectedOption.value;
            const imageSrc = selectedOption.getAttribute('data-src');
            const imageLabel = selectedOption.getAttribute('data-label');
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

                <label for="priority-${imageId}">Priorytet:</label>
                <input type="number" name="priority[${imageId}]" id="priority-${imageId}" class="image-priority" 
                    value="1" min="1" max="100" step="1" />

                <button type="button" onclick="removeImage(this)">Usuń</button>
            `;

            // Add the list item to the list
            selectedImagesList.appendChild(listItem);

            // Update the hidden input value
            updateSelectedImages();

            // Reset the image selector after adding an image
            resetImageSelector();
        });

        // Function to remove an image from the list
        window.removeImage = function (button) {
            // Find the list item by traversing up the DOM tree
            let listItem = button;
            while (listItem && listItem.tagName !== 'LI') {
                listItem = listItem.parentElement;
            }
            listItem.remove()
            updateSelectedImages();
        };

        // Function to update the hidden input value
        function updateSelectedImages() {
            const selectedIds = Array.from(selectedImagesList.children).map(li => li.getAttribute('data-id'));
            selectedImagesInput.value = selectedIds.join(',');
        }
            
        // Reset the image selector when the page is loaded
        resetImageSelector();
    });
</script>
