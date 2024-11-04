@section('title', 'Sawit')
@section('breadcrumb')
<div class="pagetitle mt-4 d-md-block d-none" style="margin-left:30px">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('/staff') }}">Staff</a>
        </li>
        <li class="breadcrumb-item active">Add New</li>
    </ol>
</div>
@endsection
@extends('main')
@section('content')
<section class="section dashboard">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body mt-4 px-4">
                <form id="formData" method="POST" class="row g-3" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="work_type" value="1">

                    <div class="col-md">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control mb-2" id="name" required>
                    </div>

                    <div class="col-md">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" class="form-control mb-2" id="date" required>
                    </div>

                    <div class="col-md">
                        <label for="price_per_item" class="form-label">Price Per Item</label>
                        <input type="number" name="price_per_item" class="form-control mb-2" id="date" required>
                    </div>

                    <div class="col-md-12" id="staff-container">
                        <label class="col-md-12 mb-2" style="font-size:20pt;">Staff</label>
                        <button type="button" id="add-staff" class="btn btn-primary">Add Row</button>
                        <div class="row">
                            <table class="table" id="dynamic-table-feature">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <label for="staffs" class="form-label">Staff</label>
                                            <select name="staffs[]" class="form-control" required style="margin-bottom: 20px;">
                                                <option value="">Staff</option> <!-- Default option -->
                                                @foreach ($staffs as $key => $staff)
                                                <option value="{{ $staff->id}}">{{$staff->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <label for="total_item" class="form-label">Total Pekerjaan (Unit)</label>
                                            <input type="number" class="form-control" name="total_item[]" id="total_item">
                                            <input type="hidden" class="form-control" name="type[]" value="0">
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="mb-3" style="display: flex; justify-content: flex-end;">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border mt-2" role="status" style="display:none;margin-bottom:-90px; margin-right:15px">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn-submit px-4 btn btn-sm btn-dark rounded-pill float-right ml-3">
                                Submit</button>
                        </div>
                        <div class="mx-2">
                            <a href="{{ route('index_staff') }}" class="btn-cancel px-4 btn btn-sm rounded-pill float-right ml-3">
                                Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@push('css')
@endpush
@push('js')
<script>
    $(document).ready(function() {
        $('#formData').on('submit', function(e) {
            $('.spinner-border').show();
            $(".submit").prop('disabled', true);
            e.preventDefault();
            $('.is-invalid').each(function() {
                $('.is-invalid').removeClass('is-invalid');
            });

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('post_work_history') }}",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    $('.spinner-border').hide();
                    if (res.status) {
                        swal("Success", "Working Hour Berhasil Di Tambahkan!", "success", {
                            buttons: false,
                            timer: 2000,
                        }).then((value) => {
                            var redirect_url = "{{ route('index_work_history') }}"
                            window.location.href = redirect_url;
                        });
                    } else {
                        toastr['error'](res.error);
                    }
                },
                error: function(res) {
                    $('.spinner-border').hide();
                    $(".submit").prop('disabled', false);
                    if (res.status != 422)
                        toastr['error']("Something went wrong");
                    showError(res.responseJSON.errors, "#formData");
                }
            });
            return false;
        })
    });

    document.getElementById('add-staff').addEventListener('click', function() {
        var tableBody = document.querySelector('#dynamic-table-feature tbody');
        var newRow = tableBody.insertRow();

        var cell1 = newRow.insertCell();
        cell1.innerHTML = `<label for="staff" class="form-label">Staff</label>
                                <select name="staffs[]" class="form-control" required style="margin-bottom: 20px;">
                                    <option value="">Staff</option> <!-- Default option -->
                                    @foreach ($staffs as $key => $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" class="form-control" name="type[]" value="0">`;

        var cell2 = newRow.insertCell();
        cell2.innerHTML = `<label for="total_item" class="form-label">Total Pekerjaan (Unit)</label>                                            
                                                <input type="number" class="form-control" name="total_item[]" id="total_item">`;

        var cell3 = newRow.insertCell();
        cell3.innerHTML = `<button class="btn btn-danger col-md-12 delete-row mt-5" style="border-radius: 50%;width:50px;" type="button" onclick="removeRow(this);">X</button>`;
    });

    function removeRow(button) {
        var row = button.closest('tr'); // Find the closest <tr> element
        row.remove(); // Remove the row
    }
</script>
@endpush