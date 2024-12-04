
{{-- if isset $toastSuccessTitle or $toastSuccessDescription and one of them is not empty, then display the block below. --}}
@if (isset($toastSuccessTitle) || isset($toastSuccessDescription))
    @if (!empty($toastSuccessTitle) || !empty($toastSuccessDescription))
        <div class="bs-toast toast toast-placement-ex m-2 fade bg-success top-0 start-50 translate-middle-x show"
            role="alert" aria-live="assertive" aria-atomic="true" id="success-toast" style="display: block;">
            <div class="toast-header">
                <i class="bx bx-check-circle me-2"></i>
                <div class="me-auto fw-semibold">{{ $toastSuccessTitle ?? '' }}</div>
                {{-- <!-- <small>11 mins ago</small> --> --}}
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">{{ $toastSuccessDescription ?? '' }}</div>
        </div>
        @if(isset($toastSuccessHideTime) && $toastSuccessHideTime > 0)
            <script>
                setTimeout(() => {
                    let toast = document.getElementById('success-toast');
                    if(toast) toast.classList.replace('show', 'hide');
                }, {{ $toastSuccessHideTime * 1000 }});
            </script>
        @endif
    @endif
@endif

{{-- if isset $toastErrorTitle or $toastErrorDescription and one of them is not empty, then display the block below. --}}
@if (isset($toastErrorTitle) || isset($toastErrorDescription))
    @if (!empty($toastErrorTitle) || !empty($toastErrorDescription))
        <div class="bs-toast toast toast-placement-ex m-2 fade bg-danger top-0 start-50 translate-middle-x show"
            role="alert" aria-live="assertive" aria-atomic="true" id="error-toast" style="display: block;">
            <div class="toast-header">
                <i class="bx bx-error-circle me-2"></i>
                <div class="me-auto fw-semibold">{{ $toastErrorTitle ?? '' }}</div>
                {{-- <!-- <small>11 mins ago</small> --> --}}
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">{{ $toastErrorDescription ?? '' }}</div>
        </div>
        @if(isset($toastErrorHideTime) && $toastErrorHideTime > 0)
            <script>
                setTimeout(() => {
                    let toast = document.getElementById('error-toast');
                    if(toast) toast.classList.replace('show', 'hide');
                }, {{ $toastErrorHideTime * 1000 }});
            </script>
        @endif
    @endif
@endif
