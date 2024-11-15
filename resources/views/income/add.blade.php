@section('title', 'Sawit')
@section('breadcrumb')
<div class="pagetitle mt-4 d-md-block d-none" style="margin-left:30px">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ url('/staff') }}">Income</a>
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

                    <div class="col-md-12">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" class="form-control mb-2" id="date" required>
                    </div>

                    <div class="col-md-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control mb-2" id="description" rows="4"> </textarea>
                    </div>

                    <div class="col-md">
                        <label for="total_weight" class="form-label">Total Weight</label>
                        <input type="number" name="total_weight" class="form-control mb-2" id="total_weight" required>
                    </div>

                    <div class="col-md">
                        <label for="name" class="form-label">Price Per Kg</label>
                        <input type="number" name="price_per_kg" class="form-control mb-2" id="price_per_kg" required>
                    </div>

                    <div class="col-md">
                        <label for="name" class="form-label">Total</label>
                        <input type="number" name="total" class="form-control mb-2" id="total" readonly required>
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
                            <a href="{{ route('index_expense') }}" class="btn-cancel px-4 btn btn-sm rounded-pill float-right ml-3">
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
    document.getElementById('total_weight').addEventListener('input', calculateTotal);
    document.getElementById('price_per_kg').addEventListener('input', calculateTotal);

    function calculateTotal() {
        const totalWeight = parseFloat(document.getElementById('total_weight').value) || 0;
        const pricePerKg = parseFloat(document.getElementById('price_per_kg').value) || 0;
        const total = totalWeight * pricePerKg;
        document.getElementById('total').value = total.toFixed(2);
    }

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
                url: "{{ route('insert_income') }}",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    $('.spinner-border').hide();
                    if (res.status) {
                        swal("Success", "Income Berhasil Di Tambahkan!", "success", {
                            buttons: false,
                            timer: 2000,
                        }).then((value) => {
                            var redirect_url = "{{ route('index_income') }}"
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
</script>
@endpush