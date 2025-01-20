{{-- custom navbar --}}
<nav class="container-xxl pt-2">
    <div class="bg-navbar-theme shadow-sm rounded px-4 py-1">
        <div class="row d-flex justify-content-center">
            <div class="navbar-nav-right d-flex align-items-center justify-content-between" id="navbar-collapse">
                {{-- toggle for less wide screens --}}
                <div class="navbar-menu-toggle d-xl-none me-3">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="bx bx-menu bx-sm"></i>
                    </a>
                </div>
                <!-- Search -->
                <div class="navbar-nav align-items-center w-100">
                    <div class="nav-item d-flex align-items-center w-100">
                        <i class="bx bx-search fs-4 lh-0 me-1"></i>
                        <input {{-- type="search" --}} type="input"
                            class="form-control border-0 shadow-none bg-transparent me-1 px-2 w-100"
                            placeholder="Szukaj..." aria-label="Search..." name="searchInput" id="searchInput" />
                        <button class="btn btn-sm me-1" type="button" id="searchInputClear" hidden>
                            <i class="bx bx-x fs-4 lh-0"></i>
                        </button>
                        <a class="btn btn-primary me-1 collapsed" data-bs-toggle="collapse" href="#collapseSearch"
                            role="button" aria-expanded="false" aria-controls="collapseSearch">
                            <i class="bx bx-search fs-4 lh-0"></i>
                        </a>
                    </div>
                </div>
                <!-- /Search -->

                <ul class="navbar-nav flex-row align-items-center ms-auto" id="navUserElement">

                    <!-- User -->
                    <li class="nav-item navbar-dropdown dropdown-user dropdown">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                            data-bs-toggle="dropdown">
                            <div class="avatar avatar-online">
                                <img src="{{ asset('panel/assets/img/avatars/user_1.png') }}" alt
                                    class="w-px-40 h-auto rounded-circle" />
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar avatar-online">
                                                <img src="{{ asset('panel/assets/img/avatars/user_1.png') }}" alt
                                                    class="w-px-40 h-auto rounded-circle" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span class="fw-semibold d-block">{{ Auth::user()->first_name }}
                                                {{ Auth::user()->last_name }}</span>
                                            <small class="text-muted">{{ Auth::user()->email }}</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                            <a class="dropdown-item" href="/logout">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Wyloguj</span>
                            </a>
                    </li>
                </ul>
                </li>
                <!--/ User -->
                </ul>
            </div>
        </div>
        <div class="collapse row" id="collapseSearch">
            <hr class="my-2">
            <div class="d-flex align-content-center justify-content-center">
                <div class="spinner-border text-secondary my-3" role="status" id="searchSpinner">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="py-1" id="searchResults" hidden>
                <div>
                    Result 1
                </div>
                <div>
                    Result 2
                </div>
            </div>
        </div>
    </div>
</nav>
