@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{-- TOASTS --}}
    @include('panel.components.alert_toasts')

    <div class="card mb-4">
        <h4 class="card-header">{{ $image->title }}</h4>
        <div class="card-body py-2">
			<div class="row text-center">
				<div class="col">
					<a type="button" class="btn btn-secondary me-auto" href="{{ route('admin.images.update', ['id' => $image->id]) }}">
						Edytuj dane
					</a>
				</div>
				<div class="col">
					<a type="button" class="btn btn-danger me-auto" href="{{ route('admin.images.delete', ['id' => $image->id]) }}">
						Usuń obraz
					</a>
				</div>
			</div>
        </div>
        <hr>
        <div class="card-body col-md-10 py-2">
            <table class="table table-borderless">
				<tbody>
					<tr>
						<td class="align-middle"><small class="text-light fw-semibold">Opis</small></td>
						<td class="py-3">
							<p class="mb-0">{{ $image->label }}</p>
						</td>
					</tr>
					<tr>
						<td class="align-middle"><small class="text-light fw-semibold">Dodano</small></td>
						<td class="py-3">
							<p class="mb-0">{{ $image->created_at }} przez {{ $image->createdByUser->first_name ?? 'N/A' }} {{ $image->createdByUser->last_name ?? '' }}</p>
						</td>
					</tr>
					<tr>
						<td class="align-middle"><small class="text-light fw-semibold">Zmodyfikowano</small></td>
						<td class="py-3">
							<p class="mb-0">{{ $image->updated_at }} przez {{ $image->updatedByUser->first_name ?? 'N/A' }} {{ $image->updatedByUser->last_name ?? '' }}</p>
						</td>
					</tr>
					<tr>
						<td class="align-middle"><small class="text-light fw-semibold">ID</small></td>
						<td class="py-3">
							<p class="mb-0">{{ $image->id }}</p>
						</td>
					</tr>
					<tr>
						<td class="align-middle"><small class="text-light fw-semibold">Adres URL</small></td>
						<td class="py-3">
							{{-- <p class="mb-0"><em>{{ url() }}{{ $image->file_location }}</em></p> --}}
							<p class="mb-0"><em><input type="text" value="{{ url() }}{{ $image->file_location }}" id="urlToCopy" disabled></em></p>
							
							<button class="btn btn-secondary" onclick="copyUrlToClipboard()">Kopiuj do schowka</button>
						</td>
					</tr>
				</tbody>
            </table>
        </div>

        <div class="card-body text-center">
            <a href="{{ $image->file_location }}"><img src="{{ $image->file_location }}" alt="{{ $image->title }}" style="min-width: 40%; max-height: 100%; max-width: 100%; object-fit: contain;"></a>
        </div>


    </div>


</div>

@include('panel.auth.footer')


<script>
	function copyUrlToClipboard() {
	// Get the text field
	var copyText = document.getElementById("urlToCopy");

	// Select the text field
	copyText.select();
	copyText.setSelectionRange(0, 99999); // For mobile devices

	// Copy the text inside the text field
	navigator.clipboard.writeText(copyText.value);

	// Alert the copied text
	alert("Copied the text: " + copyText.value);
	}
</script>
