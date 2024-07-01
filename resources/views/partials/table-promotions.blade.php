<!-- resources/views/admin/project/table.blade.php -->
@include('partials.modal-show')
<table id="mr-table" class="table table-dark table-hover shadow mb-2 mt-3">
    <thead>
        <tr>
            <!-- <th scope="col">#id Project</th> -->
            <th scope="col">Promotions id</th>
            <th scope="col" class="d-none d-xl-table-cell">Title</th>
            <th scope="col" class="d-none d-lg-table-cell">Duration</th>
            <th scope="col" class="d-none d-lg-table-cell">Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($elements as $element)
            <tr>
                <!-- <td>{{ $element->id }}</td> -->
                <td>{{ $element->id }}</td>
                <td class="d-none d-xl-table-cell">{{ $element->title }}</td>
                <td class="d-none d-xl-table-cell">{{ $element->duration }}</td>
                <td class="d-none d-xl-table-cell">{{ $element->price }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
