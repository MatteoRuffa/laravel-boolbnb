<!-- resources/views/admin/project/table.blade.php -->
@include('partials.modal-show')
<table id="mr-table" class="table table-dark table-hover shadow mb-2 mt-3">
    <thead>
        <tr>
            <!-- <th scope="col">#id Project</th> -->
            <th scope="col">Apartment name</th>
            <th scope="col" class="d-none d-xl-table-cell">rooms</th>
            <th scope="col" class="d-none d-lg-table-cell">bathrooms</th>
            <th scope="col" class="d-none d-lg-table-cell">beds</th>
            <th scope="col" class="d-none d-lg-table-cell">square_meters</th>
            <th scope="col" class="d-none d-lg-table-cell">address</th>
            <th scope="col" class="{{ Route::currentRouteName() === 'admin.apartments.index' ? '' : 'd-none' }}">
                Amministration Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($elements as $element)
            <tr>
                <!-- <td>{{ $element->id }}</td> -->
                <td>{{ $element->name }}</td>
                <td class="d-none d-xl-table-cell">{{ $element->rooms }}</td>
                <td class="d-none d-lg-table-cell">{{ $element->bathrooms }}</td>
                <td class="d-none d-lg-table-cell">{{ $element->beds }}</td>
                <td class="d-none d-lg-table-cell">{{ $element->square_meters }} squaremeter</td>
                <td class="d-none d-lg-table-cell">{{ $element->address }}</td>
                <td class="{{ Route::currentRouteName() === 'admin.apartments.index' ? '' : 'd-none' }}">
                    <div class="d-flex justify-content-center align-items-center">
                        <!-- Amministration Actions -->
                        <a href="{{ route('admin.apartments.show', $element) }}" class="table-icon p-3 m-1 " >
                            <div class="icon-container">
                                <i class="fas fa-info-circle"></i>
                            </div>
                        </a>

                        <!-- <a href="{{ route('admin.apartments.edit', $element) }}" class="table-icon m-1 pe-2">
                            <div class="icon-container">
                                <i class="fas fa-pencil-alt"></i>
                            </div>
                        </a> -->
                        <form id="delete-form-{{ $element->id }}" action="{{ route('admin.apartments.destroy', $element->id) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-table table-icon" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form> 
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@include('partials.modal-delete')

