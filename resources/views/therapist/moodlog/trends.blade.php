@extends('layout')

@section('content')
<div class="container my-4">
  <h3>Mood Trends for Patient {{ $patientId }}</h3>

  <div class="card mb-3">
    <div class="card-body">
      <h5 class="h6">Summary (last 90 days)</h5>
      @if($trend->isEmpty())
        <div class="text-muted small">No mood data available.</div>
      @else
        <ul class="list-group list-group-flush">
          @foreach($trend as $t)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>{{ $t->MoodType }}</div>
              <span class="badge bg-secondary">{{ $t->count }}</span>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h5 class="h6">Recent Logs</h5>
      @if($recent->isEmpty())
        <div class="text-muted small">No recent logs.</div>
      @else
        <ul class="list-group list-group-flush">
          @foreach($recent as $r)
            <li class="list-group-item">
              <div class="small">{{ \Carbon\Carbon::parse($r->LogDate)->format('d M Y') }} — {{ $r->MoodType }}</div>
              <div class="small text-muted">{{ $r->MoodDescription }}</div>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>
</div>
@endsection
