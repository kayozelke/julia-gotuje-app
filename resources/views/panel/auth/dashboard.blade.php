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
                                Aby rozpocząć pracę z systemem, wybierz interesującą Cię funkcję z menu po lewej. Możesz też dodać nowy wpis poniżej. Miłego dnia! 
                            </p>

                            <a href="#" class="btn btn-sm btn-outline-primary">Nowy wpis</a>
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
    </div>
</div>

@include('panel.auth.footer')
