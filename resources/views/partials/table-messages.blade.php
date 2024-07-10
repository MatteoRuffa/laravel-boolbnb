<!-- resources/views/admin/project/table.blade.php -->
@include('partials.modal-show')
<table id="mr-table" class="table table-hover shadow mb-2 mt-3">
    <thead>
        <tr class="text-white">
            <!-- <th scope="col">#id Project</th> -->
            <th scope="col" class="align-content-center text-white d-xl-table-cell fw-normal">Name</th>
            <th scope="col" class="align-content-center text-white d-lg-table-cell fw-normal">Email</th>
            <th scope="col" class="text-white fw-normal align-content-center d-lg-table-cell">Message</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($elements as $element)
            <tr>
                <!-- <td>{{ $element->id }}</td> -->
                <td>{{ $element->name }}</td>
                <td class="align-content-center d-xl-table-cell">{{ $element->email }}</td>
                <td class="align-content-center d-lg-table-cell"> {{ $element->message }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

