@if($working_hour != null)
<div class="data">
    <h2 style="margin-top: 10px;">{{$working_hour['name']}}</h2>
    <div class="card">
        <div class="card">
            <ul class="list-group list-group-flush">
                @foreach($working_hour->Detail as $data)
                <li class="list-group-item">{{$data->Staff->name}}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif