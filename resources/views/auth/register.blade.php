
@extends('layouts.app')

@section('title','Register')

@section('content')

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-md-7">

<div class="card shadow">

<div class="card-header bg-primary text-white">

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h3>Patient Registration</h3>

</div>

<div class="card-body">

<form method="POST" action="/register">

@csrf

<div class="mb-3">
<label>Full Name</label>
<input type="text" name="FullName" class="form-control" value="{{ old('FullName') }}">
@error('FullName')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="Email" class="form-control" value="{{ old('Email') }}">
@error('Email')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="Password" class="form-control" placeholder="Enter your password (8 characters minimum)">
</div>

<div class="mb-3">
<label>Confirm Password</label>
<input type="password" name="Password_confirmation" class="form-control placeholder="Confirm your password">
</div>

<div class="mb-3">
<label>Gender</label>

<select name="Gender" class="form-select">
<option value="">Select Gender</option>
<option>Male</option>
<option>Female</option>
<option>Other</option>
</select>

</div>

<div class="mb-3">
<label>Date of Birth</label>
<input type="date" name="DOB" class="form-control">
</div>

<div class="mb-3">
<label>Phone</label>
<input type="text" name="Phone" class="form-control">
</div>

<button class="btn btn-primary w-100">

Register

</button>

</form>

</div>

</div>

</div>

</div>

</div>

@endsection