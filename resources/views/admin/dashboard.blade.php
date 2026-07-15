@extends('layout')

@section('content')
@php
    use Carbon\Carbon;
@endphp

<div class="container my-4">
    {{-- Success/Session Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ (session('success')) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Better Header --}}
    <div class="mb-4">
        <h2 class="fw-bold">🛡 Admin Dashboard</h2>
        <p class="text-muted">Manage Patients, Therapists, Sessions and System Data</p>
    </div>

    {{-- Dashboard Statistics Cards --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-primary shadow-sm h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <h6 class="text-muted mb-2">Total Patients</h6>
                    <h2 class="fw-bold text-primary mb-0">{{ $patients->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success shadow-sm h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <h6 class="text-muted mb-2">Total Therapists</h6>
                    <h2 class="fw-bold text-success mb-0">{{ $therapists->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning shadow-sm h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <h6 class="text-muted mb-2">Appointments</h6>
                    <h2 class="fw-bold text-warning mb-0">{{ $appointments->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger shadow-sm h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <h6 class="text-muted mb-2">Cancellations</h6>
                    <h2 class="fw-bold text-danger mb-0">{{ $cancellations->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Search Bar (Polished UI Aspect) --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <input type="text" class="form-control" placeholder="Search patient, therapist or appointment...">
        </div>
    </div>

    {{-- Manage Specializations Button Card --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1 fw-semibold">Specializations</h5>
                <small class="text-muted">Manage therapist specializations and classifications</small>
            </div>
            <a href="{{ route('specializations.index') }}" class="btn btn-primary px-4">Manage</a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left column: Users --}}
        <div class="col-lg-4">
            {{-- Patients card --}}
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-light">
                    <strong class="small text-uppercase tracking-wider">Patients</strong>
                    <span class="badge bg-secondary float-end">{{ $patients->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @if($patients->isEmpty())
                        <div class="p-3 text-muted small">No patients found.</div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($patients as $p)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold small">{{ $p->FullName }}</div>
                                        <div class="small text-muted">{{ $p->Email }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Therapists card --}}
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <strong class="small text-uppercase tracking-wider">Therapists</strong>
                    <span class="badge bg-secondary float-end">{{ $therapists->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @if($therapists->isEmpty())
                        <div class="p-3 text-muted small">No therapists found.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="py-2 ps-3">Name</th>
                                        <th class="py-2">Status</th>
                                        <th class="py-2 text-end pe-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($therapists as $t)
                                        <tr>
                                            <td class="align-middle ps-3 fw-semibold small">{{ $t->FullName }}</td>
                                            <td class="align-middle">
                                                {{-- Color the Verification Status --}}
                                                @if($t->VerificationStatus == "Verified")
                                                    <span class="badge bg-success">Verified</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-end pe-3">
                                                @if($t->VerificationStatus !== 'Verified')
                                                    <form method="POST" action="{{ route('admin.therapist.verify', $t->TherapistID) }}" class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-sm btn-success py-0 px-2">Verify</button>
                                                    </form>
                                                @else
                                                    <span class="text-success small"><i class="bi bi-check-circle"></i> Done</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right column: Appointments, Cancellations, Follow-ups --}}
        <div class="col-lg-8">
            {{-- Appointments --}}
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <strong class="small text-uppercase tracking-wider">Appointments</strong>
                    <div class="small text-muted">{{ $appointments->count() }} total</div>
                </div>
                <div class="card-body p-0">
                    @if($appointments->isEmpty())
                        <div class="p-3 text-muted small">No appointments found.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Session</th>
                                        <th>Patient</th>
                                        <th>Therapist</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Cancelled</th>
                                        <th class="pe-3">Follow-ups</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $a)
                                        <tr>
                                            <td class="align-middle ps-3 fw-semibold">{{ $a->SessionID }}</td>
                                            <td class="align-middle small">{{ optional($a->patient)->FullName }}</td>
                                            <td class="align-middle small">{{ optional($a->therapist)->FullName }}</td>
                                            <td class="align-middle small">{{ Carbon::parse($a->SessionDate)->format('d M Y') }}</td>
                                            <td class="align-middle small">{{ \Illuminate\Support\Str::limit($a->StartTime, 5, '') }} - {{ \Illuminate\Support\Str::limit($a->EndTime, 5, '') }}</td>
                                            <td class="align-middle">
                                                {{-- Color Appointment Status --}}
                                                @if($a->Status == "Scheduled")
                                                    <span class="badge bg-primary">Scheduled</span>
                                                @elseif($a->Status == "Completed")
                                                    <span class="badge bg-success">Completed</span>
                                                @elseif($a->Status == "Cancelled")
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $a->Status ?? 'Scheduled' }}</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                @if($a->cancellation)
                                                    <span class="text-danger small fw-bold">Yes</span>
                                                @else
                                                    <span class="text-muted small">No</span>
                                                @endif
                                            </td>
                                            <td class="align-middle small pe-3 text-muted">
                                                @if($a->followUps && $a->followUps->count())
                                                    {{ $a->followUps->pluck('FollowUpDate')->map(fn($d) => Carbon::parse($d)->format('d M'))->join(', ') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Cancellations --}}
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-light">
                    <strong class="small text-uppercase tracking-wider">Recent Cancellations</strong>
                </div>
                <div class="card-body p-0">
                    @if($cancellations->isEmpty())
                        <div class="p-3 text-muted small">No cancellations recorded.</div>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($cancellations as $c)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div class="fw-semibold small text-danger">Session {{ $c->SessionID }}</div>
                                            <div class="small text-muted italic">"{{ $c->CancellationReason ?? 'No reason provided' }}"</div>
                                        </div>
                                        <div class="text-end small text-muted align-self-center">{{ Carbon::parse($c->CancellationTimestamp)->format('d M Y H:i') }}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            {{-- Follow-ups --}}
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <strong class="small text-uppercase tracking-wider">Recent Follow-ups</strong>
                </div>
                <div class="card-body p-0">
                    @if($followUps->isEmpty())
                        <div class="p-3 text-muted small">No follow-ups found.</div>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($followUps as $f)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-semibold small">Session {{ $f->SessionID }} — <span class="text-primary">{{ Carbon::parse($f->FollowUpDate)->format('d M Y') }}</span></div>
                                            <div class="small text-muted">{{ $f->ReminderMessage ?? 'No reminder message set.' }}</div>
                                        </div>
                                        <div class="text-end small">
                                            <span class="badge bg-info text-dark">Status: {{ $f->Status }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection