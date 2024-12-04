{{-- DATATABLES - TEST ONLY --}}
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />

@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{--  --}}
    @include('panel.components.alert_toasts')

    <div class="card mb-4">
        <h5 class="card-header">Kategorie</h5>
        {{-- <div class="card-body mb-1">
        </div> --}}
        <div class="card-body m-1">
            
            <!-- Basic Breadcrumb -->
            <nav aria-label="breadcrumb">

                <ol class="breadcrumb">

                    @if (count($parent_categories) == 0)
                        <li class="breadcrumb-item active">Wszystko</li>
                    @else
                        <li class="breadcrumb-item active">
                            <a href="{{ route('admin.categories') }}">Wszystko</a>
                        </li>
                    @endif

                    @foreach (array_reverse($parent_categories) as $category)
                        {{-- <li>ID: {{ $category->id }} - Nazwa: {{ $category->name }}</li> --}}
                        <li class="breadcrumb-item">
                            <a
                                href="{{ route('admin.categories', ['param' => $category->id]) }}">{{ $category->name }}</a>
                        </li>
                    @endforeach


                    {{-- <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Library</a>
                    </li>
                    <li class="breadcrumb-item active">Data</li> --}}
                </ol>
            </nav>
            <!-- Basic Breadcrumb -->

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
                Dodaj kategorię w tym miejscu
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Dodaj nową kategorię</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.categories.add', ['param' => $current_category_id]) }}"
                                method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nazwa kategorii</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <input type="hidden" class="form-control" id="parent_category_id"
                                        name="parent_category_id" value="{{ $current_category_id }}">

                                </div>
                                <button type="submit" class="btn btn-primary">Zapisz</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->

        </div>
    </div>



    <!-- Borderless Table -->
    <div class="card mb-4">
        @if (count($categories) == 0)
            <div class="alert alert-info m-3 text-center" role="alert">
                Brak danych
            </div>
        @else
            {{-- <h5 class="card-header">Kategorie</h5> --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nazwa</th>
                            <th>Utworzono</th>
                            <th>Zmodyfikowano</th>
                            <th>Zmodyfikowano przez</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    <a href="{{ route('admin.categories', ['param' => $category->id]) }}"
                                        class="href">
                                        <strong>{{ $category->name }}</strong>
                                    </a>
                                </td>
                                <td>{{ $category->created_at }}</td>
                                <td>{{ $category->updated_at }}</td>
                                <td>Albert Cook</td>
                                <td>
                                    <div class="dropdown position-static">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="bx bx-trash me-1"></i>
                                                Delete</a>
                                        </div>
                                    </div>
                                </td>
                                {{-- <td>
                                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-xs pull-up" title="Lilian Fuller">
                                        <img src="{{ asset('panel/assets/img/avatars/5.png') }}" alt="Avatar"
                                            class="rounded-circle" />
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                                        <img src="{{ asset('panel/assets/img/avatars/6.png') }}" alt="Avatar"
                                            class="rounded-circle" />
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-xs pull-up" title="Christina Parker">
                                        <img src="{{ asset('panel/assets/img/avatars/7.png') }}" alt="Avatar"
                                            class="rounded-circle" />
                                    </li>
                                </ul>
                            </td>
                            <td><span class="badge bg-label-primary me-1">Active</span></td> --}}
                            </tr>
                        @endforeach

                        {{-- <tr>
                            <td><i class="fab fa-react fa-lg text-info me-3"></i> <strong>React Project</strong></td>
                            <td>Barry Hunter</td>
                            <td>
                                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-xs pull-up" title="Lilian Fuller">
                                        <img src="{{ asset('panel/assets/img/avatars/5.png') }}" alt="Avatar"
                                            class="rounded-circle" />
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                                        <img src="{{ asset('panel/assets/img/avatars/6.png') }}" alt="Avatar"
                                            class="rounded-circle" />
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-xs pull-up" title="Christina Parker">
                                        <img src="{{ asset('panel/assets/img/avatars/7.png') }}" alt="Avatar"
                                            class="rounded-circle" />
                                    </li>
                                </ul>
                            </td>
                            <td><span class="badge bg-label-success me-1">Completed</span></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                                            Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><i class="fab fa-vuejs fa-lg text-success me-3"></i> <strong>VueJs Project</strong></td>
                            <td>Trevor Baker</td>
                            <td>
                                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-xs pull-up" title="Lilian Fuller">
                                        <img src="{{ asset('panel/assets/img/avatars/5.png') }}" alt="Avatar"
                                            class="rounded-circle" />
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                                        <img src="{{ asset('panel/assets/img/avatars/6.png') }}" alt="Avatar"
                                            class="rounded-circle" />
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-xs pull-up" title="Christina Parker">
                                        <img src="{{ asset('panel/assets/img/avatars/7.png') }}" alt="Avatar"
                                            class="rounded-circle" />
                                    </li>
                                </ul>
                            </td>
                            <td><span class="badge bg-label-info me-1">Scheduled</span></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="bx bx-trash me-1"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fab fa-bootstrap fa-lg text-primary me-3"></i> <strong>Bootstrap Project</strong>
                            </td>
                            <td>Jerry Milton</td>
                            <td>
                                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-xs pull-up" title="Lilian Fuller">
                                        <img src="{{ asset('panel/assets/img/avatars/5.png') }}" alt="Avatar"
                                            class="rounded-circle" />
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                                        <img src="{{ asset('panel/assets/img/avatars/6.png') }}" alt="Avatar"
                                            class="rounded-circle" />
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        class="avatar avatar-xs pull-up" title="Christina Parker">
                                        <img src="{{ asset('panel/assets/img/avatars/7.png') }}" alt="Avatar"
                                            class="rounded-circle" />
                                    </li>
                                </ul>
                            </td>
                            <td><span class="badge bg-label-warning me-1">Pending</span></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="bx bx-trash me-1"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <!--/ Borderless Table -->

</div>



@include('panel.auth.footer')


{{-- DATATABLES TEST --}}
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "paging": false, // Włącz paginację
            "ordering": true, // Włącz sortowanie
            "searching": false, // Włącz wyszukiwanie
            "order": [
                [0, "asc"]
            ], // Domyślne sortowanie po ID
            "info": false // Wyłącza informacje o paginacji
        });
    });
</script>
