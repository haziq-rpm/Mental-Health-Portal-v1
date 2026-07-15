@extends('layout')

@section('content')
@php
    // Ensure $therapists is defined so the booking form won't error.
    $therapists = $therapists ?? \App\Models\Therapist::all();
@endphp

<div class="container my-4">


<div class="mb-3 text-end">
    <a href="{{ route('patient.profile.edit') }}" class="btn btn-warning">
        Edit Profile
    </a>
</div>
  <div class="row">
    {{-- Left column: Appointments and Past Sessions --}}
    <div class="col-md-7">
      {{-- Upcoming Appointments --}}
      <section class="mb-4">
        <h3 class="h5 mb-3">Upcoming Appointments</h3>

        @if($upcoming->isEmpty())
          <div class="alert alert-info">No upcoming appointments.</div>
        @else
          @foreach($upcoming as $a)
            <div class="card mb-2">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                  <div>
                    <strong class="d-block">{{ \Carbon\Carbon::parse($a->SessionDate)->format('d M Y') }}
                      <span class="text-muted">• {{ \Carbon\Carbon::createFromFormat('H:i:s', $a->StartTime ?? $a->StartTime)->format('H:i') ?? $a->StartTime }}</span>
                      <span class="text-muted">- {{ \Carbon\Carbon::createFromFormat('H:i:s', $a->EndTime ?? $a->EndTime)->format('H:i') ?? $a->EndTime }}</span>
                    </strong>
                    <div class="small text-muted">Therapist: {{ optional($a->therapist)->FullName }}</div>
                  </div>

                  <div class="text-end">
                    <div class="badge bg-secondary">{{ $a->Status ?? 'Scheduled' }}</div>
                    @if($a->cancellation)
                      <div class="text-danger small mt-1">Cancelled at {{ $a->cancellation->CancellationTimestamp }}</div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </section>

      {{-- Past Sessions --}}
      <section class="mb-4">
        <h3 class="h5 mb-3">Past Sessions</h3>

        @if($past->isEmpty())
          <div class="alert alert-info">No past sessions.</div>
        @else
          @foreach($past as $p)
            <div class="card mb-2">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <strong>{{ \Carbon\Carbon::parse($p->SessionDate)->format('d M Y') }}</strong>
                    <div class="small text-muted">Therapist: {{ optional($p->therapist)->FullName }}</div>
                  </div>
                  <div class="text-end small text-muted">
                    Status: {{ $p->Status ?? 'Completed' }}
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </section>

      {{-- Mood Logs --}}
      <section class="mb-4">
        <h3 class="h5 mb-3">Mood Logs</h3>

        @if($moodLogs->isEmpty())
          <div class="alert alert-info">No mood logs yet.</div>
        @else
          @foreach($moodLogs as $m)
            <div class="card mb-2">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <div>
                    <strong class="d-block">{{ \Carbon\Carbon::parse($m->LogDate)->format('d M Y') }} — {{ $m->MoodType }}</strong>
                    <div class="small text-muted mb-2">
    {{ $m->MoodDescription }}
</div>

<div>

<a href="{{ route('moodlog.edit',$m->MoodLogID) }}"
class="btn btn-sm btn-warning">

Edit

</a>

<form
action="{{ route('moodlog.delete',$m->MoodLogID) }}"
method="POST"
class="d-inline">

@csrf

<button
class="btn btn-sm btn-danger"
onclick="return confirm('Delete this mood log?')">

Delete

</button>

</form>

</div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </section>
      <form method="POST" action="{{ route('moodlog.store') }}">
  @csrf
  <div class="mb-2">
    <label>Date</label>
    <input type="date" name="LogDate" class="form-control" value="{{ date('Y-m-d') }}" required>
  </div>
  <div class="mb-2">
    <label>Mood</label>
    <select name="MoodType" class="form-control" required>
      <option value="Happy">Happy</option>
      <option value="Sad">Sad</option>
      <option value="Anxious">Anxious</option>
      <option value="Neutral">Neutral</option>
      <option value="Angry">Angry</option>
    </select>
  </div>
  <div class="mb-2">
    <label>Notes (optional)</label>
    <textarea name="MoodDescription" class="form-control" rows="3"></textarea>
  </div>
  <button class="btn btn-primary">Save Mood</button>
</form>

      {{-- Follow Ups --}}
      <section class="mb-4">
        <h3 class="h5 mb-3">Follow Ups</h3>

        @if($followUps->isEmpty())
          <div class="alert alert-info">No follow-ups.</div>
        @else
          @foreach($followUps as $f)
            <div class="card mb-2">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                  <div>
                    <div class="fw-bold">Follow-up Date: {{ \Carbon\Carbon::parse($f->FollowUpDate)->format('d M Y') }}</div>
                    <div class="small text-muted">From session: {{ $f->SessionID }}</div>
                    <div class="small mt-1">Message: {{ $f->ReminderMessage ?? '-' }}</div>
                  </div>

                  <div class="text-end">
                    <div class="small mb-2">Status: {{ $f->Status }}</div>

                    @if($f->Status === 'Pending')
                      <button class="btn btn-sm btn-outline-success" type="button" data-bs-toggle="collapse" data-bs-target="#confirm-followup-{{ $f->FollowUpID }}">Confirm</button>
                    @endif
                  </div>
                </div>

                {{-- Confirm collapse --}}
                @if($f->Status === 'Pending')
                  <div class="collapse mt-3" id="confirm-followup-{{ $f->FollowUpID }}">
                    <form method="POST" action="{{ route('followup.confirm', $f->FollowUpID) }}">
                      @csrf
                      <div class="row g-2">
                        <div class="col">
                          <input type="time" name="StartTime" class="form-control" required>
                        </div>
                        <div class="col">
                          <input type="time" name="EndTime" class="form-control" required>
                        </div>
                        <div class="col-auto">
                          <button class="btn btn-success">Confirm & Book</button>
                        </div>
                      </div>
                    </form>
                  </div>
                @endif
              </div>
            </div>
          @endforeach
        @endif
      </section>
    </div>

    {{-- Right column: Booking form and quick actions --}}
    <div class="col-md-5">
      <aside class="sticky-top" style="top:20px;">
        <div class="card mb-4">
          <div class="card-body">
            <h4 class="h6 mb-3">Book a Session</h4>

            <form method="POST" action="{{ route('appointment.book') }}">
              @csrf

              <div class="mb-3">
                <label class="form-label">Therapist</label>
                <select name="TherapistID" class="form-select" required>
                  @foreach($therapists as $t)
                    <option value="{{ $t->TherapistID }}">{{ $t->FullName }}{{ $t->SpecializationID ? ' — ' . ($t->specialization->SpecializationName ?? '') : '' }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Session Date</label>
                <input type="date" name="SessionDate" class="form-control" required min="{{ date('Y-m-d') }}">
              </div>

              <div class="row g-2 mb-3">
                <div class="col">
                  <label class="form-label">Start Time</label>
                  <input type="time" name="StartTime" class="form-control" required>
                </div>
                <div class="col">
                  <label class="form-label">End Time</label>
                  <input type="time" name="EndTime" class="form-control" required>
                </div>
              </div>

              <button class="btn btn-primary w-100">Book Session</button>
            </form>
          </div>
        </div>

        {{-- Quick cancel (only shown when $session is provided) --}}
        @isset($session)
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="h6 mb-3">Cancel Selected Session</h5>
              <form method="POST" action="{{ route('patient.session.cancel', $session->SessionID) }}">
                @csrf
                <div class="mb-2">
                  <input type="text" name="CancellationReason" class="form-control" placeholder="Reason (optional)">
                </div>
                <button class="btn btn-danger w-100">Cancel Session</button>
              </form>
            </div>
          </div>
        @endisset

        {{-- Small help / tips --}}
        <div class="card">
          <div class="card-body small text-muted">
            <strong>Tip:</strong> Choose a therapist and pick a time that doesn't overlap with your existing appointments.
          </div>
        </div>
      </aside>
    </div>
  </div>
</div>
@endsection
