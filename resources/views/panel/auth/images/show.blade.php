@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{-- TOASTS --}}
    @include('panel.components.alert_toasts')

    <div class="card mb-4">
        <h5 class="card-header">{{ $image->title }}</h5>
        <div class="card-body py-2">
			<div class="row">
				<div class="col">
					<a type="button" class="btn btn-secondary me-auto" href="#">
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
						<td class="align-middle"><small class="text-light fw-semibold">Opis</small></td>
						<td class="py-3">
							<p class="mb-0">{{ $image->label }}</p>
						</td>
					</tr>
				</tbody>
            </table>
        </div>

        <div class="card-body" style="text-align: center;">
            <a href="{{ $image->file_location }}"><img src="{{ $image->file_location }}" alt="{{ $image->title }}" style="min-width: 40%; max-height: 100%; max-width: 100%; object-fit: contain;"></a>
        </div>


    </div>


</div>

@include('panel.auth.footer')
