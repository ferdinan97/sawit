<div class="mt-2 d-flex flex-column" style="align-items: stretch;">
    <div class="d-flex flex-md-row gap-4 mb-md-6" style="height: 100%;">
        <div class="w-100">
            <div class="card bg-white shadow" style="border-top: 5px solid #4c3d3d; height:100%">
                <div class="card-body">
                    <h5 class="card-title" style="white-space: nowrap;color: #bdbdbd">Jumlah Gaji Pegawai Yang Telah Di Bayar</h5>
                    <h5 class="text-black" style="font-weight: 900"> Rp. {{$data['total_paid']}} </h2>
                </div>
            </div>
        </div>
        <div class="w-100">
            <div class="card bg-white shadow" style="border-top: 5px solid #4c3d3d; height:100%">
                <div class="card-body">
                    <h5 class="card-title" style="white-space: nowrap;color: #bdbdbd">Jumlah Gaji Pegawai Yang Belum Di Bayar</h5>
                    <h5 class="text-black" style="font-weight: 900"> Rp. {{$data['total_not_paid']}}</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-2 d-flex flex-column" style="align-items: stretch;">
    <div class="d-flex flex-md-row gap-4 mb-md-6" style="height: 100%;">
        <div class="w-100">
            <div class="card bg-white shadow" style="border-top: 5px solid #4c3d3d; height:100%">
                <div class="card-body">
                    <h5 class="card-title" style="white-space: nowrap;color: #bdbdbd">Total Expense</h5>
                    <h5 class="text-black" style="font-weight: 900"> Rp. {{$data['expense']}}</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<table class="table table-borderless table-hover mt-3">
    <thead>
        <tr class="p-1 border">
            <th scope="col">#</th>
            <th scope="col">Nama</strong></th>
            <th scope="col">Total Hari Kerja</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data['report'] as $key => $val)
        <tr class="p-1 border">
            <th>{{ $key + 1 }}</th>
            <td>{{ $val->Staff->name }}</td>
            <td>{{ $val->count }} Days</td>
        </tr>
        @endforeach
    </tbody>
</table>