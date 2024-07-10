<!-- resources/views/admin/project/table.blade.php -->
@include('partials.modal-show')
@if($elements->isEmpty())
    <div class="alert alert-info">
        There are no apartments to display. Please add a new apartment.
    </div>
@else
<table id="mr-table" class="table  table-hover shadow mb-2 mt-3">
    <thead>
        <tr>
            <!-- <th scope="col">#id Project</th> -->
            <th class="text-white d-none fw-normal d-xl-table-cell" scope="col">Apartment cover</th>
            <th  class="text-white d-xl-table-cell  fw-normal" scope="col">Apartment name</th>
            <th scope="col" class="text-white fw-normal d-lg-table-cell">Visibility</th>
            <th scope="col" class=" text-white fw-normal d-lg-table-cell">Address</th>
            <th scope="col" class="text-white fw-normal {{ Route::currentRouteName() === 'admin.apartments.index' ? '' : 'd-none' }}">
                Administration Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($elements as $element)
            <tr>
                <!-- <td>{{ $element->id }}</td> pippo -->
                <td  id="td-image-cover" class="d-none d-xl-table-cell"><img class="img-fluid rounded" src="{{ asset('storage/' . $element->image_cover) }}" alt="{{ $element->name }}"></td>
                <td class=" d-xl-table-cell align-content-center">{{ $element->name }}</td>
                <td class=" d-xl-table-cell align-content-center">{{ $element->rooms }}</td>
                <td class=" d-lg-table-cell align-content-center">{{ $element->address }}</td>
                <td class="{{ Route::currentRouteName() === 'admin.apartments.index' ? '' : 'd-none' }} align-content-center d-lg-table-cell">
                        <!-- Amministration Actions -->
                            <a href="{{ route('admin.apartments.show', $element) }}" class="btn draw-border">
                                <div class="icon-container">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                            </a>
                            <a href="{{ route('admin.apartments.edit', $element) }}" class="btn draw-border">
                                <div class="icon-container">
                                    <i class="fas fa-pencil-alt"></i>
                                </div>
                            </a>
                            <form class="d-inline" id="delete-form-{{ $element->id }}" action="{{ route('admin.apartments.destroy', $element->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn draw-border" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $element->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form> 
                </td>
            </tr>
            @include('partials.modal-delete', ['element' => $element])
        @endforeach
    </tbody>
</table>
@endif