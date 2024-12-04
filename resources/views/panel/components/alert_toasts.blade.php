<div class="bs-toast toast toast-placement-ex m-2 fade bg-danger top-0 start-50 translate-middle-x show" role="alert"
    aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <i class="bx bx-error-circle me-2"></i>
        <div class="me-auto fw-semibold">Uwaga!</div>
        <!-- <small>11 mins ago</small> -->
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">Fruitcake chocolate bar tootsie roll gummies gummies jelly beans cake.</div>
</div>

{{-- if isset $toastSuccessTitle or $toastSuccessDescription and one of them is not empty, then display the block below. --}}
@if (isset($toastSuccessTitle) || isset($toastSuccessDescription))
    @if (!empty($toastSuccessTitle) || !empty($toastSuccessDescription))
        <div class="bs-toast toast toast-placement-ex m-2 fade bg-success top-0 start-50 translate-middle-x show"
            role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
            <div class="toast-header">
                <i class="bx bx-check-circle me-2"></i>
                <div class="me-auto fw-semibold">{{ $toastSuccessTitle ?? '' }}</div>
                {{-- <!-- <small>11 mins ago</small> --> --}}
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">{{ $toastSuccessDescription ?? '' }}</div>
        </div>
    @endif
@endif
