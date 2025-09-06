<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of contact messages
     */
    public function index(Request $request)
    {
        $query = Contact::query()->orderBy('created_at', 'desc');

        // Filter by read status
        if ($request->has('status')) {
            if ($request->status === 'unread') {
                $query->unread();
            } elseif ($request->status === 'read') {
                $query->read();
            }
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $contacts = $query->paginate(15);
        $unreadCount = Contact::unread()->count();

        return view('admin.contacts.index', compact('contacts', 'unreadCount'));
    }

    /**
     * Display the specified contact message
     */
    public function show(Contact $contact)
    {
        // Mark as read when viewed
        if (!$contact->is_read) {
            $contact->markAsRead();
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Mark contact message as read
     */
    public function markAsRead(Contact $contact)
    {
        $contact->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Message marked as read'
        ]);
    }

    /**
     * Mark contact message as unread
     */
    public function markAsUnread(Contact $contact)
    {
        $contact->update([
            'is_read' => false,
            'read_at' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message marked as unread'
        ]);
    }

    /**
     * Delete contact message
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact message deleted successfully.');
    }

    /**
     * Bulk actions for contact messages
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:mark_read,mark_unread,delete',
            'contact_ids' => 'required|array',
            'contact_ids.*' => 'exists:contacts,id'
        ]);

        $contacts = Contact::whereIn('id', $request->contact_ids);

        switch ($request->action) {
            case 'mark_read':
                $contacts->update([
                    'is_read' => true,
                    'read_at' => now()
                ]);
                $message = 'Selected messages marked as read.';
                break;

            case 'mark_unread':
                $contacts->update([
                    'is_read' => false,
                    'read_at' => null
                ]);
                $message = 'Selected messages marked as unread.';
                break;

            case 'delete':
                $contacts->delete();
                $message = 'Selected messages deleted successfully.';
                break;
        }

        return redirect()->route('admin.contacts.index')
            ->with('success', $message);
    }
}
