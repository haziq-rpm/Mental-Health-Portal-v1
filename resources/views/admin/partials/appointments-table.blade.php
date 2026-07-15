{{-- resources/views/admin/partials/appointments-table.blade.php --}}
<table class="table table-striped">
  <thead>
    <tr>
      <th>SessionID</th>
      <th>Patient</th>
      <th>Therapist</th>
      <th>Date</th>
      <th>Time</th>
      <th>Status</th>
      <th>Cancellation</th>
      <th>FollowUps</th>
    </tr>
  </thead>
  <tbody>
    @foreach($appointments as $a)
      <tr>
        <td>{{ $a->SessionID }}</td>
        <td>{{ optional($a->patient)->FullName }}</td>
        <td>{{ optional($a->therapist)->FullName }}</td>
        <td>{{ $a->SessionDate }}</td>
        <td>{{ $a->StartTime }} - {{ $a->EndTime }}</td>
        <td>{{ $a->Status ?? 'Scheduled' }}</td>
        <td>
          @if($a->cancellation)
            <div class="text-danger">Yes ({{ $a->cancellation->CancellationTimestamp }})</div>
          @else
            <div>No</div>
          @endif
        </td>
        <td>
          @if($a->followUps && $a->followUps->count())
            {{ $a->followUps->pluck('FollowUpDate')->join(', ') }}
          @else
            -
          @endif
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
