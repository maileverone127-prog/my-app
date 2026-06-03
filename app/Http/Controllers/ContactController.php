<?php

namespace App\Http\Controllers;

use App\Mail\NewContactMessage;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Save to database
        $message = Message::create($validated);

        // Send email notification
        $mailSent = false;
        try {
            $recipient = config('mail.contact_recipient', config('mail.from.address'));
            Mail::to($recipient)->send(new NewContactMessage($message));
            $mailSent = true;
        } catch (\Exception $e) {
            Log::error('Contact mail failed: ' . $e->getMessage());
        }

        $successMsg = $mailSent
            ? '✅ Message sent! I\'ll get back to you soon.'
            : '✅ Message received! (Email notification unavailable, but your message is saved.)';

        return back()->with('success', $successMsg);
    }

    /* ================= ADMIN ================= */

    public function adminIndex()
    {
        $messages = Message::latest()->paginate(15);
        return view('admin.messages.index', compact('messages'));
    }

    public function adminShow(Message $message)
    {
        if (!$message->isRead()) {
            $message->update(['read_at' => now()]);
        }
        return view('admin.messages.show', compact('message'));
    }

    public function markRead(Message $message)
    {
        $message->update(['read_at' => now()]);
        return back()->with('success', 'Message marked as read.');
    }

    public function markUnread(Message $message)
    {
        $message->update(['read_at' => null]);
        return back()->with('success', 'Message marked as unread.');
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Message deleted.');
    }
}
