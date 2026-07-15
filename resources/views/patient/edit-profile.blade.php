@extends('layout')

@section('content')

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-8">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4>Edit Profile</h4>

</div>

<div class="card-body">

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('patient.profile.update') }}">

@csrf

<div class="mb-3">
<label>Full Name</label>
<input type="text" name="FullName" class="form-control" value="{{ old('FullName',$patient->FullName) }}">
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="Email" class="form-control" value="{{ old('Email',$patient->Email) }}">
</div>

<div class="mb-3">
<label>Phone</label>
<input type="text" name="Phone" class="form-control" value="{{ old('Phone',$patient->Phone) }}">
</div>

<div class="mb-3">
<label>Gender</label>

<select name="Gender" class="form-select">

<option {{ $patient->Gender=="Male"?"selected":"" }}>Male</option>

<option {{ $patient->Gender=="Female"?"selected":"" }}>Female</option>

<option {{ $patient->Gender=="Other"?"selected":"" }}>Other</option>

</select>

</div>

<div class="mb-3">
<label>Date of Birth</label>
<input type="date" name="DOB" class="form-control" value="{{ $patient->DOB }}">
</div>

<hr>

<h5>Change Password (Optional)</h5>

<div class="mb-3">
<label>New Password</label>
<input type="password" name="Password" class="form-control">
</div>

<div class="mb-3">
<label>Confirm Password</label>
<input type="password" name="Password_confirmation" class="form-control">
</div>

<button class="btn btn-primary">

Update Profile

</button>

<a href="{{ route('patient.dashboard') }}" class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

</div>

</div>

@endsection