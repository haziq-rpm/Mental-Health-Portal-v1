@extends('layout')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">

        <h2>Manage Specializations</h2>

        <a href="{{ route('specializations.create') }}"
           class="btn btn-primary">

            Add Specialization

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <table class="table table-bordered table-striped">

        <thead class="table-dark">

            <tr>

                <th>ID</th>

                <th>Name</th>

                <th>Description</th>

                <th width="180">Actions</th>

            </tr>

        </thead>

        <tbody>

        @foreach($specializations as $s)

            <tr>

                <td>{{ $s->SpecializationID }}</td>

                <td>{{ $s->SpecializationName }}</td>

                <td>{{ $s->Description }}</td>

                <td>

                    <a href="{{ route('specializations.edit',$s->SpecializationID) }}"
                       class="btn btn-warning btn-sm">

                        Edit

                    </a>

                    <form action="{{ route('specializations.destroy',$s->SpecializationID) }}"
                          method="POST"
                          class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this specialization?')">

                            Delete

                        </button>

                    </form>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection