<!-- resources/views/admin/project/table.blade.php -->
@include('partials.modal-show')
<table id="mr-table" class="table table-dark table-hover shadow mb-2 mt-3">
    <thead>
        <tr>
            <!-- <th scope="col">#id Project</th> -->
            <th scope="col">Service id</th>
            <th scope="col" class="d-none d-xl-table-cell">Name</th>
            <th scope="col" class="d-none d-lg-table-cell">Icon</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($elements as $element)
            <tr>
                <!-- <td>{{ $element->id }}</td> -->
                <td>{{ $element->id }}</td>
                <td class="d-none d-xl-table-cell">{{ $element->name }}</td>
                <td class="d-none d-lg-table-cell">
                    <div class="img-icon rounded-circle bg-white p-2">   
                        <img class="img-fluid" src="{{ asset('storage/' . $element->icon) }}" alt="{{ $element->name }}">
                    </div>
                   
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
