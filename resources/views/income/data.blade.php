<table class="table table-borderless table-hover">
    <thead>
        <tr class="p-1 border">
            <th scope="col">#</th>
            <th scope="col">Nama</strong></th>
            <th scope="col">Tanggal</strong></th>
            <th scope="col">Total</strong></th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $val)
        <tr class="p-1 border">
            <th>{{ $key + 1 }}</th>
            <td>{{ $val->name }}</td>
            <td>{{ $val->date }}</td>
            <td>{{ $val->total }}</td>
            <td>
                <div class="d-flex justify-content-start">
                    <a class="dropdown-item" href="{{ route('edit_expense', $val->id) }}"><i class="bi bi-pencil-square"></i></a>
                    <a class="dropdown-item" href="#" onclick="deleteData({{ $val->id }})"><i class="bi bi-trash"></i></a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $data->links('components.paginate') }}