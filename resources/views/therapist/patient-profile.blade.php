@extends('layout')

@section('content')

@php
use Carbon\Carbon;
@endphp

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Patient Profile</h2>

        <a href="{{ route('therapist.dashboard') }}" class="btn btn-secondary">
            Back to Dashboard
        </a>

    </div>

    {{-- Patient Details --}}
    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">
            Patient Information
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <p>
                        <strong>Full Name:</strong>
                        {{ $patient->FullName }}
                    </p>

                    <p>
                        <strong>Email:</strong>
                        {{ $patient->Email }}
                    </p>

                    <p>
                        <strong>Phone:</strong>
                        {{ $patient->Phone }}
                    </p>

                </div>

                <div class="col-md-6">

                    <p>
                        <strong>Gender:</strong>
                        {{ $patient->Gender }}
                    </p>

                    <p>
                        <strong>Date of Birth:</strong>

                        {{ Carbon::parse($patient->DOB)->format('d M Y') }}

                    </p>

                    <p>
                        <strong>Registration Date:</strong>

                        {{ Carbon::parse($patient->RegistrationDate)->format('d M Y') }}

                    </p>

                </div>

            </div>

        </div>

    </div>



    {{-- Appointment History --}}
    <div class="card shadow mb-4">

        <div class="card-header bg-success text-white">
            Session History
        </div>

        <div class="card-body">

            @if($appointments->count())

            <table class="table table-bordered">

                <thead>

                <tr>

                    <th>Date</th>

                    <th>Start</th>

                    <th>End</th>

                    <th>Status</th>

                </tr>

                </thead>

                <tbody>

                @foreach($appointments as $appointment)

                <tr>

                    <td>

                        {{ Carbon::parse($appointment->SessionDate)->format('d M Y') }}

                    </td>

                    <td>

                        {{ substr($appointment->StartTime,0,5) }}

                    </td>

                    <td>

                        {{ substr($appointment->EndTime,0,5) }}

                    </td>

                    <td>

                        {{ $appointment->Status }}

                    </td>

                </tr>

                @endforeach

                </tbody>

            </table>

            @else

            <div class="alert alert-warning">

                No appointments found.

            </div>

            @endif

        </div>

    </div>



    {{-- Mood Logs --}}
    <div class="card shadow">

        <div class="card-header bg-info text-white">

            Mood Logs

        </div>

        <div class="card-body">

            @if($moodLogs->count())

            <table class="table table-striped">

                <thead>

                <tr>

                    <th>Date</th>

                    <th>Mood</th>

                    <th>Description</th>

                </tr>

                </thead>

                <tbody>

                @foreach($moodLogs as $log)

                <tr>

                    <td>

                        {{ Carbon::parse($log->LogDate)->format('d M Y') }}

                    </td>

                    <td>

                        {{ $log->MoodType }}

                    </td>

                    <td>

                        {{ $log->MoodDescription }}

                    </td>

                </tr>

                @endforeach

                </tbody>

            </table>

            @else

            <div class="alert alert-warning">

                No mood logs available.

            </div>

            @endif

        </div>

    </div>

</div>

@endsection