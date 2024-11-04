<table class="table table-borderless table-hover">
    <thead>
        <tr class="p-1 border">
            <th scope="col">#</th>
            <th scope="col">Nama</strong></th>
            <th scope="col">Hari</strong></th>
            <th scope="col">Jumlah Pekerja</strong></th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $key => $data)
        <tr class="p-1 border">
            <th>{{ $key + 1 }}</th>
            <td>{{ $data->name }}</td>
            <td>{{ $data->date }}</td>
            <td>{{ $data->detail_count }} Orang</td>
            <td>
                <div class="d-flex justify-content-start">
                    <a class="dropdown-item" href="{{ route('edit_work_history', $data->id) }}" ><i class="bi bi-pencil-square"></i></a>
                    <a class="dropdown-item" href="#" onclick="deleteData({{ $data->id }})"><i class="bi bi-trash"></i></a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $datas->links('components.paginate') }}