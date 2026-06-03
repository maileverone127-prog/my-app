@extends('layouts.admin')

@section('title', 'Messages')

@section('breadcrumb')
<nav class="breadcrumb" aria-label="Breadcrumb">
    <span style="color:var(--text);font-weight:600;font-size:.9375rem">Messages</span>
</nav>
@endsection

@section('content')

@if(session('success'))
    <div style="background:#dcfce7;color:#15803d;border:1px solid #86efac;border-radius:var(--r-sm);padding:.875rem 1rem;margin-bottom:1.25rem;font-size:.875rem;display:flex;align-items:center;gap:.5rem">
        <svg style="width:16px;height:16px;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
@endif

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem">
    <div>
        <h2 style="font-size:1.25rem;font-weight:700;color:var(--text)">Contact Messages</h2>
        <p style="font-size:.875rem;color:var(--text-muted);margin-top:.25rem">
            {{ $messages->total() }} total &middot;
            <span style="color:#6366f1;font-weight:500">{{ \App\Models\Message::unread()->count() }} unread</span>
        </p>
    </div>
</div>

<div class="a-card" style="padding:0;overflow:hidden">
    @if($messages->isEmpty())
        <div style="padding:3rem;text-align:center;color:var(--text-muted)">
            <svg style="width:40px;height:40px;margin:0 auto 1rem;opacity:.4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            <p style="font-size:.9375rem">No messages yet.</p>
        </div>
    @else
        <table style="width:100%;border-collapse:collapse;font-size:.875rem">
            <thead>
                <tr style="border-bottom:1px solid var(--border)">
                    <th style="text-align:left;padding:.75rem 1rem;color:var(--text-muted);font-weight:500;font-size:.8125rem">Sender</th>
                    <th style="text-align:left;padding:.75rem 1rem;color:var(--text-muted);font-weight:500;font-size:.8125rem">Preview</th>
                    <th style="text-align:left;padding:.75rem 1rem;color:var(--text-muted);font-weight:500;font-size:.8125rem">Received</th>
                    <th style="text-align:left;padding:.75rem 1rem;color:var(--text-muted);font-weight:500;font-size:.8125rem">Status</th>
                    <th style="text-align:right;padding:.75rem 1rem;color:var(--text-muted);font-weight:500;font-size:.8125rem">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $msg)
                <tr style="border-bottom:1px solid var(--border);transition:background .15s;{{ !$msg->isRead() ? 'background:var(--p-50)' : '' }}"
                    onmouseover="this.style.background='var(--bg-2)'" onmouseout="this.style.background='{{ !$msg->isRead() ? 'var(--p-50)' : '' }}'">
                    <td style="padding:.875rem 1rem">
                        <div style="display:flex;align-items:center;gap:.625rem">
                            @if(!$msg->isRead())
                                <span style="width:8px;height:8px;border-radius:50%;background:#6366f1;flex-shrink:0"></span>
                            @else
                                <span style="width:8px;height:8px;flex-shrink:0"></span>
                            @endif
                            <div>
                                <div style="font-weight:{{ !$msg->isRead() ? '700' : '500' }};color:var(--text)">{{ $msg->name }}</div>
                                <div style="font-size:.8125rem;color:var(--text-muted)">{{ $msg->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding:.875rem 1rem;color:var(--text-muted);max-width:280px">
                        <span style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                            {{ Str::limit($msg->message, 60) }}
                        </span>
                    </td>
                    <td style="padding:.875rem 1rem;color:var(--text-muted);white-space:nowrap">
                        {{ $msg->created_at->diffForHumans() }}
                    </td>
                    <td style="padding:.875rem 1rem">
                        @if($msg->isRead())
                            <span style="background:#f3f4f6;color:#6b7280;padding:.25rem .625rem;border-radius:999px;font-size:.75rem;font-weight:500">Read</span>
                        @else
                            <span style="background:#eef2ff;color:#6366f1;padding:.25rem .625rem;border-radius:999px;font-size:.75rem;font-weight:600">Unread</span>
                        @endif
                    </td>
                    <td style="padding:.875rem 1rem;text-align:right">
                        <div style="display:flex;align-items:center;justify-content:flex-end;gap:.5rem">
                            <a href="{{ route('admin.messages.show', $msg) }}"
                               style="display:inline-flex;align-items:center;gap:.375rem;background:var(--p-50);color:var(--p);padding:.375rem .75rem;border-radius:var(--r-sm);font-size:.8125rem;font-weight:500;text-decoration:none;transition:background .2s"
                               onmouseover="this.style.background='var(--p)';this.style.color='#fff'" onmouseout="this.style.background='var(--p-50)';this.style.color='var(--p)'">
                                View
                            </a>
                            <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST"
                                  onsubmit="return confirm('Delete this message?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        style="display:inline-flex;align-items:center;background:#fee2e2;color:#dc2626;padding:.375rem .75rem;border-radius:var(--r-sm);font-size:.8125rem;font-weight:500;border:none;cursor:pointer;transition:background .2s"
                                        onmouseover="this.style.background='#dc2626';this.style.color='#fff'" onmouseout="this.style.background='#fee2e2';this.style.color='#dc2626'">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($messages->hasPages())
            <div style="padding:1rem 1.25rem;border-top:1px solid var(--border)">
                {{ $messages->links() }}
            </div>
        @endif
    @endif
</div>

@endsection
