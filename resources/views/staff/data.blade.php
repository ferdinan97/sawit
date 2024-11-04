<table class="table table-borderless table-hover">
    <thead>
        <tr class="p-1 border">
            <th scope="col">#</th>
            <th scope="col">Nama</strong></th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($staffs as $key => $staff)
        <tr class="p-1 border">
            <th>{{ $key + 1 }}</th>
            <td>{{ $staff->name }}</td>
            <td>
                <div class="d-flex justify-content-start">
                    <!-- <a class="dropdown-item" href="{{ route("edit_staff", $staff->id) }}"><i class="bi bi-pencil-square"></i></a> -->
                    <a class="dropdown-item" href="{{ route('edit_staff', $staff->id) }}" ><i class="bi bi-pencil-square"></i></a>
                    <a class="dropdown-item" href="#" onclick="deleteData({{ $staff->id }})"><i class="bi bi-trash"></i></a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $staffs->links('components.paginate') }}