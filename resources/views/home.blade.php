@extends('layouts.app')

@section('title','Mental Health Portal')

@section('content')

<section class="hero">

<div class="container">

<div class="row align-items-center">

<div class="col-lg-6">

<h1 class="display-4 fw-bold">

Your Mental Health Matters

</h1>

<p class="lead mt-4">

Connect with licensed therapists, schedule appointments, track your daily mood, and receive professional support—all in one secure platform.

</p>

<div class="mt-5">

<a href="/register" class="btn btn-primary btn-lg me-3">

Get Started

</a>

<a href="/login" class="btn btn-outline-primary btn-lg">

Login

</a>

</div>

</div>

<div class="col-lg-6 text-center">

<img src="https://images.unsplash.com/photo-1516302752625-fcc3c50ae61f?w=700"
class="img-fluid rounded shadow">

</div>

</div>

</div>

</section>

<div class="container">

<div class="row g-4">

<div class="col-md-4">

<div class="card feature-card p-4 text-center">

<i class="bi bi-calendar-check display-3 text-primary"></i>

<h3 class="mt-3">

Book Appointments

</h3>

<p>

Schedule therapy sessions quickly and easily.

</p>

</div>

</div>

<div class="col-md-4">

<div class="card feature-card p-4 text-center">

<i class="bi bi-emoji-smile display-3 text-success"></i>

<h3 class="mt-3">

Mood Tracker

</h3>

<p>

Keep track of your emotional well-being every day.

</p>

</div>

</div>

<div class="col-md-4">

<div class="card feature-card p-4 text-center">

<i class="bi bi-shield-lock display-3 text-danger"></i>

<h3 class="mt-3">

Secure Records

</h3>

<p>

Your information remains private and protected.

</p>

</div>

</div>

</div>

</div>

@endsection