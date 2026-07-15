@extends('layout')

@section('content')
<div class="container my-4">
  <h3>Session Note — ID {{ $note->NoteID }}</h3>
  <div class="card mt-3">
    <div class="card-body">
      <div class="small text-muted">Session: {{ $note->SessionID }} • Created: {{ $note->CreatedAt }}</div>
      <hr>
      <pre class="mb-0" style="white-space:pre-wrap;">{{ $decrypted }}</pre>
    </div>
  </div>
</div>
@endsection
