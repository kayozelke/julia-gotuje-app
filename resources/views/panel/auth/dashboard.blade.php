@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    @include('panel.components.alert_toasts')

    <div class="row">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Witaj, {{ Auth::user()->first_name }}!</h5>
                            <p class="mb-4">
                                Aby rozpocząć pracę z systemem, wybierz interesującą Cię funkcję z menu po lewej. Możesz
                                też dodać nowy wpis poniżej. Miłego dnia!
                            </p>

                            <a href="{{ route('admin.posts.add') }}" class="btn btn-sm btn-outline-primary">Nowy wpis</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('panel/assets/img/illustrations/man-with-laptop-light.png') }}"
                                height="140" alt="View Badge User"
                                data-app-dark-img="{{ asset('illustrations/man-with-laptop-dark.png') }}"
                                data-app-light-img="{{ asset('illustrations/man-with-laptop-light.png') }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 order-1">
            <div class="row h-100">
                {{-- posts --}}
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    {{-- <img src="{{ asset('panel/assets/img/icons/unicons/chart-success.png') }}"
                                        alt="chart success" class="rounded" /> --}}
                                    {{-- <i class='bx bx-detail'></i> --}}
                                    <div class="rounded">
                                        <i class='bx bx-detail'></i>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Opublikowane posty</span>
                            <h3 class="card-title mb-2">{{ $publicated_posts_count }}</h3>
                            {{-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +72.80%</small> --}}
                        </div>
                    </div>
                </div>
                {{-- images --}}
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('panel/assets/img/icons/unicons/chart-success.png') }}"
                                        alt="chart success" class="rounded" />
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Obrazy w systemie</span>
                            <h3 class="card-title mb-2">{{ $images_count }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('panel.auth.footer')
