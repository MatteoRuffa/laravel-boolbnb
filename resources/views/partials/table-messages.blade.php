@include('partials.modal-show')

<table id="mr-table" class="table table-hover shadow mb-2 mt-3">
    <thead>
        <tr class="text-white">
            <th scope="col" class="align-content-center text-white d-xl-table-cell fw-normal">Apartment Name</th>
            <th scope="col" class="align-content-center text-white d-xl-table-cell fw-normal">Received On</th>
            <th scope="col" class="align-content-center text-white d-xl-table-cell fw-normal">Sender Name</th>
            <th scope="col" class="align-content-center text-white d-lg-table-cell fw-normal">Sender Email</th>
            <th scope="col" class="text-white fw-normal align-content-center d-lg-table-cell">Message</th>
            <th scope="col" class="text-white fw-normal align-content-center d-lg-table-cell">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($messages as $message)
            <tr>
                <td class="align-content-center d-xl-table-cell">
                    {{ $message->apartment ? $message->apartment->name : 'N/A' }}
                </td>
                <td class="align-content-center d-xl-table-cell">{{ $message->created_at }}</td>
                <td class="align-content-center d-xl-table-cell">{{ $message->name }}</td>
                <td class="align-content-center d-lg-table-cell">{{ $message->email }}</td>
                <td class="align-content-center d-lg-table-cell">{{ $message->message }}</td>
                <td class="align-content-center d-lg-table-cell">actions</td>
            </tr>
        @endforeach
    </tbody>
</table>
