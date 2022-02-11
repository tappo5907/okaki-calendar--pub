@extends('layouts.app')

@section('content')

<div class="d-flex flex-sm-row my-5">
    <div class="col-sm-6">
        <h4>おかきの記録 - ご飯の量</h4>
    </div>
</div>

<div class="d-flex flex-sm-row my-3">
    <div class="col-sm-3 text-left mt-4"><a href="/food_weight/{{ $prev_date->year }}/{{ $prev_date->month }}/{{ $prev_date->day }}"><i class="fas fa-chevron-left fa-2x"></i></a></div>
    <div class="col-sm-6 text-center py-2">{{ $date->year }}年<br>{{ $date->month }}月{{ $date->day }}日</div>
    <div class="col-sm-3 text-right mt-4"><a href="/food_weight/{{ $next_date->year }}/{{ $next_date->month }}/{{ $next_date->day }}"><i class="fas fa-chevron-right fa-2x"></i></a></a></div>
</div>

<div id="foodWeights" data-json="{{ $foodWeightsJson }}"></div>

<div class="chart-container" style="position: relative; width:80vw; height:50vh">
    <canvas id="foodWeightChart"></canvas>
</div>

@endsection