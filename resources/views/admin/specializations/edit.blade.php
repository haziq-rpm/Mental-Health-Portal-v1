@extends('layout')

@section('content')

<div class="container mt-4">

<h2>Edit Specialization</h2>

<form method="POST"
      action="{{ route('specializations.update',$specialization->SpecializationID) }}">

@csrf
@method('PUT')

<div class="mb-3">

<label>Name</label>

<input
type="text"
name="SpecializationName"
class="form-control"
value="{{ $specialization->SpecializationName }}"
required>

</div>

<div class="mb-3">

<label>Description</label>

<textarea
name="Description"
class="form-control"
rows="4">{{ $specialization->Description }}</textarea>

</div>

<button class="btn btn-primary">

Update

</button>

<a href="{{ route('specializations.index') }}"
class="btn btn-secondary">

Back

</a>

</form>

</div>

@endsection