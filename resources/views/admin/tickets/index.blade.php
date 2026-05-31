@extends('layouts.admin')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">

            <h1 class="mb-4">Tickets</h1>

            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-2">
                    <label for="date_from" class="form-label">Date From</label>
                    <input type="date" name="date_from" id="date_from" class="form-control"
                        value="{{ request('date_from') }}">
                </div>

                <div class="col-md-2">
                    <label for="date_to" class="form-label">Date To</label>
                    <input type="date" name="date_to" id="date_to" class="form-control"
                        value="{{ request('date_to') }}">
                </div>

                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All statuses</option>
                        <option value="new" @selected(request('status') === 'new')>New</option>
                        <option value="in_progress" @selected(request('status') === 'in_progress')>In progress</option>
                        <option value="processed" @selected(request('status') === 'processed')>Processed</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="Email"
                        value="{{ request('email') }}">
                </div>

                <div class="col-md-2">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone"
                        value="{{ request('phone') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->customer->name }}</td>
                            <td>{{ $ticket->customer->email }}</td>
                            <td>{{ $ticket->customer->phone }}</td>
                            <td>{{ $ticket->subject }}</td>
                            <td>
                                @if ($ticket->status === 'new')
                                    <span class="badge text-bg-primary">New</span>
                                @elseif($ticket->status === 'in_progress')
                                    <span class="badge text-bg-warning">In Progress</span>
                                @else
                                    <span class="badge text-bg-success">Processed</span>
                                @endif
                            </td>
                            <td>{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.tickets.show', $ticket) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    Open
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No tickets found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $tickets->links() }}
        </div>
    </div>
@endsection
