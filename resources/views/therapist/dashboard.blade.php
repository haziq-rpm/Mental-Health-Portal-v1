@extends('layout')

@section('content')

@php
use Carbon\Carbon;
@endphp

<div class="container mt-4">

    <h2 class="mb-4">Therapist Dashboard</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">

        <!-- LEFT SIDE -->
        <div class="col-lg-8">
<div class="card shadow mb-4">

    <div class="card-header bg-dark text-white">

        Availability

    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('therapist.availability') }}">

            @csrf

            <div class="row">

                <div class="col-md-8">

                    <select
                        name="AvailabilityStatus"
                        class="form-select">

                        <option
                            value="Available"
                            {{ Auth::user()->AvailabilityStatus=='Available' ? 'selected':'' }}>
                            Available
                        </option>

                        <option
                            value="Unavailable"
                            {{ Auth::user()->AvailabilityStatus=='Unavailable' ? 'selected':'' }}>
                            Unavailable
                        </option>

                    </select>

                </div>

                <div class="col-md-4">

                    <button class="btn btn-success w-100">

                        Save

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    Upcoming Sessions
                </div>

                <div class="card-body">

                    @forelse($upcoming as $s)

                    <div class="border rounded p-3 mb-4">

                        <div class="row">

                            <div class="col-md-8">

                                <h5>
                                    {{ optional($s->patient)->FullName }}
                                </h5>

                                <p class="mb-1">
                                    <strong>Date:</strong>
                                    {{ Carbon::parse($s->SessionDate)->format('d M Y') }}
                                </p>

                                <p class="mb-1">
                                    <strong>Time:</strong>

                                    {{ substr($s->StartTime,0,5) }}

                                    -

                                    {{ substr($s->EndTime,0,5) }}
                                </p>

                                <p class="mb-0">
                                    <strong>Status:</strong>

                                    {{ $s->Status }}
                                </p>

                            </div>

                            <div class="col-md-4 text-end">

                                <a href="{{ route('therapist.patient.view',$s->patient->PatientID) }}"
                                   class="btn btn-primary btn-sm mb-2">

                                    View Patient

                                </a>

                                <br>

                                <a href="{{ route('moodlog.trends',$s->patient->PatientID) }}"
                                   class="btn btn-info btn-sm">

                                    Mood Logs

                                </a>

                            </div>

                        </div>

                        <hr>

                        <!-- SESSION NOTE -->

                        <form action="{{ route('sessionnote.store') }}" method="POST">

                            @csrf

                            <input
                                type="hidden"
                                name="SessionID"
                                value="{{ $s->SessionID }}"
                            >

                            <label class="form-label">

                                Session Note

                            </label>

                            <textarea
                                class="form-control"
                                name="EncryptedNote"
                                rows="3"
                            ></textarea>

                            <button
                                class="btn btn-success mt-2">

                                Save Note

                            </button>

                        </form>

                        <hr>

                        <!-- CANCEL SESSION -->

                        <form action="{{ route('therapist.session.cancel',$s->SessionID) }}"
                              method="POST">

                            @csrf

                            <label>

                                Cancellation Reason

                            </label>

                            <textarea
                                name="CancellationReason"
                                class="form-control"
                                rows="2"
                            ></textarea>

                            <button
                                class="btn btn-danger mt-2">

                                Cancel Session

                            </button>

                        </form>
                        <hr>

<h6>Reschedule Session</h6>

<form method="POST"
      action="{{ route('therapist.session.reschedule',$s->SessionID) }}">

    @csrf

    <div class="row">

        <div class="col-md-4">

            <label>Date</label>

            <input
                type="date"
                class="form-control"
                name="SessionDate"
                value="{{ $s->SessionDate }}"
                required>

        </div>

        <div class="col-md-4">

            <label>Start Time</label>

            <input
                type="time"
                class="form-control"
                name="StartTime"
                value="{{ substr($s->StartTime,0,5) }}"
                required>

        </div>

        <div class="col-md-4">

            <label>End Time</label>

            <input
                type="time"
                class="form-control"
                name="EndTime"
                value="{{ substr($s->EndTime,0,5) }}"
                required>

        </div>

    </div>

    <button class="btn btn-warning mt-3">

        Update Session

    </button>

</form>

                        <hr>

                        <!-- FOLLOWUP -->

                        <form action="{{ route('followup.store') }}"
                              method="POST">

                            @csrf

                            <input
                                type="hidden"
                                name="SessionID"
                                value="{{ $s->SessionID }}"
                            >

                            <div class="row">

                                <div class="col-md-4">

                                    <label>

                                        Follow-up Date

                                    </label>

                                    <input
                                        type="date"
                                        class="form-control"
                                        name="FollowUpDate"
                                        required
                                    >

                                </div>

                                <div class="col-md-8">

                                    <label>

                                        Reminder

                                    </label>

                                    <input
                                        class="form-control"
                                        name="ReminderMessage"
                                    >

                                </div>

                            </div>

                            <button
                                class="btn btn-secondary mt-3">

                                Create Follow-up

                            </button>

                        </form>

                    </div>

                    @empty

                    <div class="alert alert-info">

                        No upcoming sessions.

                    </div>

                    @endforelse

                </div>

            </div>

        </div>

        <!-- RIGHT SIDE -->

        <div class="col-lg-4">

            <div class="card shadow">

                <div class="card-header bg-success text-white">

                    Assigned Patients

                </div>

                <div class="card-body">

                    @forelse($patients as $p)

                    <div class="border rounded p-2 mb-3">

                        <strong>

                            {{ $p->FullName }}

                        </strong>

                        <br>

                        <small>

                            {{ $p->Email }}

                        </small>

                        <br><br>

                        <a
                            href="{{ route('therapist.patient.view',$p->PatientID) }}"
                            class="btn btn-primary btn-sm">

                            Profile

                        </a>

                        <a
                            href="{{ route('moodlog.trends',$p->PatientID) }}"
                            class="btn btn-info btn-sm">

                            Mood Logs

                        </a>

                    </div>

                    @empty

                    <div class="alert alert-warning">

                        No patients assigned.

                    </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

@endsection