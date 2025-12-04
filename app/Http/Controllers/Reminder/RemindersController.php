<?php

namespace App\Http\Controllers\Reminder;

use Illuminate\Http\Request;
use App\Models\Reminder\Reminders;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RemindersController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $perPage = 5;

        $activeReminders = Reminders::when($userId, fn($q) => $q->where('created_by', $userId))
            ->where('status', 'active')
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage, ['*'], 'activePage');

        $completedReminders = Reminders::when($userId, fn($q) => $q->where('created_by', $userId))
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage, ['*'], 'completedPage');

        $deletedReminders = Reminders::when($userId, fn($q) => $q->where('created_by', $userId))
            ->where('status', 'deleted')
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage, ['*'], 'deletedPage');

        return view('layouts.app', [
            'content' => view('pages.reminders.reminder', compact('activeReminders', 'completedReminders', 'deletedReminders'))->render()
        ]);
    }

    public function create()
    {
        return view('layouts.app', [
            'content' => view('pages.reminders.reminder-create')->render()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'target_date' => 'required|date',
            'category' => 'required|string|max:50',
            'repeat_type' => 'required|in:none,daily,weekly,monthly,yearly',
            'notify_before_hours' => 'required|integer|min:0',
        ]);

        Reminders::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'target_date' => $validated['target_date'],
            'category' => $validated['category'],
            'repeat_type' => $validated['repeat_type'],
            'notify_before_hours' => $validated['notify_before_hours'],
            'status' => 'active',
            'is_primary' => false,
            'created_by'  => Auth::id(),
        ]);

        return redirect()->route('reminders.index')->with('success', 'Reminder created successfully.');
    }

    // soft-delete -> set status = deleted
    public function destroy($id)
    {
        $userId = Auth::id();

        $reminder = Reminders::when($userId, fn($q) => $q->where('created_by', $userId))
            ->find($id);

        if (! $reminder) {
            return redirect()->route('reminders.index')->with('error', 'Reminder not found or unauthorized.');
        }

        $reminder->status = 'deleted';
        $reminder->updated_at = now();
        $reminder->save();

        return redirect()->route('reminders.index')->with('success', 'Reminder deleted successfully.');
    }

    // restore reminder (set status = active)
    public function restore($id)
    {
        $userId = Auth::id();

        $reminder = Reminders::when($userId, fn($q) => $q->where('created_by', $userId))
            ->find($id);

        if (! $reminder) {
            return redirect()->route('reminders.index')->with('error', 'Reminder not found or unauthorized.');
        }

        $reminder->status = 'active';
        $reminder->updated_at = now();
        $reminder->save();

        return redirect()->route('reminders.index')->with('success', 'Reminder restored successfully.');
    }

    // force delete reminder (permanent)
    public function forceDelete($id)
    {
        $userId = Auth::id();

        $reminder = Reminders::when($userId, fn($q) => $q->where('created_by', $userId))
            ->find($id);

        if (! $reminder) {
            return redirect()->route('reminders.index')->with('error', 'Reminder not found or unauthorized.');
        }

        $reminder->delete();

        return redirect()->route('reminders.index')->with('success', 'Reminder permanently deleted successfully.');
    }

    // togglePrimary (only affects reminders of the same user)
    public function togglePrimary($id)
    {
        $userId = Auth::id();

        $reminder = Reminders::when($userId, fn($q) => $q->where('created_by', $userId))
            ->find($id);

        if (! $reminder) {
            return redirect()->route('reminders.index')->with('error', 'Reminder not found or unauthorized.');
        }

        if (! $reminder->is_primary) {
            // Set all other reminders of this user to not primary
            Reminders::when($userId, fn($q) => $q->where('created_by', $userId))
                ->where('is_primary', true)
                ->update(['is_primary' => false]);

            // Set this reminder as primary
            $reminder->is_primary = true;
        } else {
            // Toggle off primary
            $reminder->is_primary = false;
        }

        $reminder->updated_at = now();
        $reminder->save();

        return redirect()->route('reminders.index')->with('success', 'Reminder primary status toggled successfully.');
    }
}
