@extends('layout')

@section('content')

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-8">

<div class="card shadow">

<div class="card-header bg-warning">

<h4>Edit Mood Log</h4>

</div>

<div class="card-body">

<form method="POST" action="{{ route('moodlog.update',$log->MoodLogID) }}">

@csrf

<div class="mb-3">
<label>Date</label>
<input type="date"
name="LogDate"
class="form-control"
value="{{ $log->LogDate }}">
</div>

<div class="mb-3">
<label>Mood</label>

<select name="MoodType" class="form-select">

<option {{ $log->MoodType=="Happy"?"selected":"" }}>Happy</option>

<option {{ $log->MoodType=="Sad"?"selected":"" }}>Sad</option>

<option {{ $log->MoodType=="Neutral"?"selected":"" }}>Neutral</option>

<option {{ $log->MoodType=="Anxious"?"selected":"" }}>Anxious</option>

<option {{ $log->MoodType=="Angry"?"selected":"" }}>Angry</option>

</select>

</div>

<div class="mb-3">

<label>Description</label>

<textarea
name="MoodDescription"
class="form-control"
rows="4">{{ $log->MoodDescription }}</textarea>

</div>

<button class="btn btn-primary">

Update

</button>

<a href="{{ route('patient.dashboard') }}"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

</div>

</div>

@endsection