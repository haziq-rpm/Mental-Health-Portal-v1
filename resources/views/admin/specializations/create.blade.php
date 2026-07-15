@extends('layout')

@section('content')

<div class="container mt-4">

<h2>Add Specialization</h2>

<form method="POST"
      action="{{ route('specializations.store') }}">

@csrf

<div class="mb-3">

<label>Name</label>

<input type="text"
       name="SpecializationName"
       class="form-control"
       required>

</div>

<div class="mb-3">

<label>Description</label>

<textarea
name="Description"
class="form-control"
rows="4"></textarea>

</div>

<button class="btn btn-success">

Save

</button>

<a href="{{ route('specializations.index') }}"
class="btn btn-secondary">

Back

</a>

</form>

</div>

@endsection