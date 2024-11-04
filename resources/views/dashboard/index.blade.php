@section('title', 'Sawit')

@section('breadcrumb')
<div class="pagetitle mt-4 d-md-block d-none">
    <h1 style="margin-left:20px !important;font-size:20px;margin-bottom:14px">Dashboard</h1>
</div>
@endsection

@extends('main')

@section('content')
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="calender">
                @php
                use Carbon\Carbon;
                $date = Carbon::now()->toDateString();
                @endphp
                <input type="date" name="date" class="form-control" value="{{$date}}" onchange="getData(this.value)">
            </div>


            <div class="data" id="data">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('js')
<script>
    var today = "{{ $date }}";
    $(document).ready(function() {
        getData(today);
    })
function getData(date) {
        $.ajax({
            url: `/work-history/data?date=` + date,
            method: 'GET',
            beforeSend: function(e) {
                $('#overlay').css("display", "block");
            },
            success: function(data) {
                $('#overlay').css("display", "none");
                console.log(data);
                $('#data').html(data);
            },
            error: function(error) {
                $('#overlay').css("display", "none");
                toastr['error']('Something Error');
            }
        })
    }
</script>
    
@endpush