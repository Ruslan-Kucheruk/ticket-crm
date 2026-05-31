@extends('layouts.admin')

@section('content')
    <div class="mb-3">
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary">
            Back to tickets
        </a>
    </div>

    <div class="card shadow-sm">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card-body">
            <h1 class="mb-4">Ticket #{{ $ticket->id }}</h1>

            <dl class="row">
                <dt class="col-sm-3">Customer</dt>
                <dd class="col-sm-9">{{ $ticket->customer->name }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $ticket->customer->email }}</dd>

                <dt class="col-sm-3">Phone</dt>
                <dd class="col-sm-9">{{ $ticket->customer->phone }}</dd>

                <dt class="col-sm-3">Subject</dt>
                <dd class="col-sm-9">{{ $ticket->subject }}</dd>

                <dt class="col-sm-3">Message</dt>
                <dd class="col-sm-9">{{ $ticket->message }}</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">
                    <span class="badge text-bg-secondary">
                        {{ $ticket->status }}
                    </span>
                </dd>

                <dt class="col-sm-3">Created at</dt>
                <dd class="col-sm-9">{{ $ticket->created_at->format('Y-m-d H:i') }}</dd>

                <dt class="col-sm-3">Manager replied at</dt>
                <dd class="col-sm-9">
                    {{ $ticket->manager_replied_at?->format('Y-m-d H:i') ?? 'Not replied yet' }}
                </dd>
            </dl>

            <hr>

            <h4>Attachments</h4>

            @forelse($ticket->getMedia('attachments') as $media)
                <div>
                    <a href="{{ $media->getUrl() }}" target="_blank">
                        {{ $media->file_name }}
                    </a>
                </div>
            @empty
                <p class="text-muted">No attachments.</p>
            @endforelse

            <hr>

            <h4>Update status</h4>

            <form method="POST" action="{{ route('admin.tickets.updateStatus', $ticket) }}">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <select name="status" class="form-select">
                        <option value="new" @selected($ticket->status === 'new')>New</option>
                        <option value="in_progress" @selected($ticket->status === 'in_progress')>In progress</option>
                        <option value="processed" @selected($ticket->status === 'processed')>Processed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Save status
                </button>
            </form>
        </div>
    </div>
@endsection