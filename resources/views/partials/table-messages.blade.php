<!-- resources/views/admin/project/table.blade.php -->
@include('partials.modal-show')
<table id="mr-table" class="table table-hover shadow mb-2 mt-3">
    <thead>
        <tr class="text-white">
            <!-- <th scope="col">#id Project</th> -->
            <th scope="col" class="align-content-center text-white d-xl-table-cell fw-normal">Apt. Name</th>
            <th scope="col" class="align-content-center text-white d-xl-table-cell fw-normal">Received at</th>
            <th scope="col" class="align-content-center text-white d-xl-table-cell fw-normal">Sender Name</th>
            <th scope="col" class="align-content-center text-white d-lg-table-cell fw-normal">Sender Email</th>
            <th scope="col" class="text-white fw-normal align-content-center d-lg-table-cell">Message</th>
            <th scope="col" class="text-white fw-normal align-content-center d-lg-table-cell">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($elements as $element)
            <tr>
                <!-- <td>{{ $element->id }}</td> -->
                <td class="align-content-center d-xl-table-cell">nome apartment</td>
                <td class="align-content-center d-xl-table-cell">{{ $element->created_at }}</td>
                <td class="align-content-center d-xl-table-cell">{{ $element->name }}</td>
                <td class="align-content-center d-lg-table-cell">{{ $element->email }}</td>
                <td class="align-content-center d-lg-table-cell">{{ $element->message }}</td>
                <td class="align-content-center d-lg-table-cell">actions</td>
            </tr>
        @endforeach
    </tbody>
</table>

