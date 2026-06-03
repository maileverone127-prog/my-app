@extends('layouts.admin')

@section('title', 'Message from ' . $message->name)

@section('breadcrumb')
<nav class="breadcrumb" aria-label="Breadcrumb" style="display:flex;align-items:center;gap:.5rem;font-size:.9375rem">
    <a href="{{ route('admin.messages.index') }}" style="color:var(--p);text-decoration:none;font-weight:500">Messages</a>
    <span style="color:var(--text-muted)">/</span>
    <span style="color:var(--text);font-weight:600">{{ $message->name }}</span>
</nav>
@endsection

@section('content')

@if(session('success'))
    <div style="background:#dcfce7;color:#15803d;border:1px solid #86efac;border-radius:var(--r-sm);padding:.875rem 1rem;margin-bottom:1.25rem;font-size:.875rem">
        {{ session('success') }}
    </div>
@endif

<div style="max-width:680px">
    <div class="a-card" style="padding:1.75rem">

        {{-- Header --}}
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap">
            <div>
                <h2 style="font-size:1.125rem;font-weight:700;color:var(--text);margin-bottom:.25rem">{{ $message->name }}</h2>
                <a href="mailto:{{ $message->email }}" style="font-size:.875rem;color:var(--p);text-decoration:none">{{ $message->email }}</a>
            </div>
            <div style="display:flex;align-items:center;gap:.625rem;flex-wrap:wrap">
                @if($message->isRead())
                    <form action="{{ route('admin.messages.unread', $message) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit"
                                style="display:inline-flex;align-items:center;gap:.375rem;background:var(--bg-2);color:var(--text-muted);padding:.5rem 1rem;border-radius:var(--r-sm);font-size:.8125rem;font-weight:500;border:1px solid var(--border);cursor:pointer">
                            <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Mark Unread
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.messages.read', $message) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit"
                                style="display:inline-flex;align-items:center;gap:.375rem;background:#eef2ff;color:#6366f1;padding:.5rem 1rem;border-radius:var(--r-sm);font-size:.8125rem;font-weight:600;border:none;cursor:pointer">
                            <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Mark Read
                        </button>
                    </form>
                @endif

                <a href="mailto:{{ $message->email }}?subject=Re: Your message&body=Hi {{ urlencode($message->name) }},"
                   style="display:inline-flex;align-items:center;gap:.375rem;background:var(--p);color:#fff;padding:.5rem 1rem;border-radius:var(--r-sm);font-size:.8125rem;font-weight:500;text-decoration:none">
                    <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                    Reply
                </a>

                <form action="{{ route('admin.messages.destroy', $message) }}" method="POST"
                      onsubmit="return confirm('Delete this message?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="display:inline-flex;align-items:center;gap:.375rem;background:#fee2e2;color:#dc2626;padding:.5rem 1rem;border-radius:var(--r-sm);font-size:.8125rem;font-weight:500;border:none;cursor:pointer">
                        <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        {{-- Meta --}}
        <div style="display:flex;gap:1.5rem;font-size:.8125rem;color:var(--text-muted);margin-bottom:1.5rem;flex-wrap:wrap">
            <span>Received: {{ $message->created_at->format('D, d M Y \a\t H:i') }}</span>
            <span>
                Status:
                @if($message->isRead())
                    <span style="color:#16a34a;font-weight:500">Read {{ $message->read_at->diffForHumans() }}</span>
                @else
                    <span style="color:#6366f1;font-weight:600">Unread</span>
                @endif
            </span>
        </div>

        {{-- Message --}}
        <div style="background:var(--bg-2);border:1px solid var(--border);border-radius:var(--r-sm);padding:1.25rem 1.5rem">
            <p style="margin:0;font-size:.9375rem;color:var(--text);line-height:1.75;white-space:pre-wrap">{{ $message->message }}</p>
        </div>

    </div>

    <div style="margin-top:1rem">
        <a href="{{ route('admin.messages.index') }}"
           style="font-size:.875rem;color:var(--text-muted);text-decoration:none;display:inline-flex;align-items:center;gap:.375rem">
            ← Back to Messages
        </a>
    </div>
</div>

@endsection
