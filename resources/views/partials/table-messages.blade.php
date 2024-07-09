<!-- resources/views/admin/project/table.blade.php -->
@include('partials.modal-show')
<table id="mr-table" class="table table-hover shadow mb-2 mt-3">
    <thead>
        <tr>
            <!-- <th scope="col">#id Project</th> -->
            <th scope="col" class="d-none d-xl-table-cell">Name</th>
            <th scope="col" class="d-none d-lg-table-cell">Email</th>
            <th scope="col">Message</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($elements as $element)
            <tr>
                <!-- <td>{{ $element->id }}</td> -->
                <td>{{ $element->name }}</td>
                <td class="d-none d-xl-table-cell">{{ $element->email }}</td>
                <td class="d-none d-lg-table-cell"> {{ $element->message }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

