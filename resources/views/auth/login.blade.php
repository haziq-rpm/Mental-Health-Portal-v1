@extends('layout')

@section('content')
<h1 class="text-xl font-bold mb-4">Login</h1>

<form method="POST" action="{{ route('login.attempt') }}">
    @csrf
    <div class="mb-4">
        <label>Email</label>
        <input type="email" name="email" class="border p-2 w-full" required>
    </div>
    <div class="mb-4">
        <label>Password</label>
        <input type="password" name="password" class="border p-2 w-full" required>
    </div>
    <div class="mb-4">
        <label>Role</label>
        <select name="role" class="border p-2 w-full">
            <option value="patient">Patient</option>
            <option value="therapist">Therapist</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2">Login</button>
</form>
<!-- resources/views/auth/login.blade.php -->
@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@endsection
