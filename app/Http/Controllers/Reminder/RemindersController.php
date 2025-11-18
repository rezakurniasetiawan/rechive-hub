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
        $perPage = 5;

        $activeReminders = Reminders::where('status', 'active')->orderBy('updated_at', 'desc')->paginate($perPage, ['*'], 'activePage');
        $completedReminders = Reminders::where('status', 'completed')->orderBy('updated_at', 'desc')->paginate($perPage, ['*'], 'completedPage');
        $deletedReminders = Reminders::where('status', 'deleted')->orderBy('updated_at', 'desc')->paginate($perPage, ['*'], 'deletedPage');

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
            'title' => $request->title,
            'description' => $request->description,
            'target_date' => $request->target_date,
            'category' => $request->category,
            'repeat_type' => $request->repeat_type,
            'notify_before_hours' => $request->notify_before_hours,
            'status' => 'active',
            'is_primary' => false,
            'created_by'  => Auth::id(),
        ]);

        return redirect()->route('reminders.index')->with('success', 'Reminder created successfully.');
    }

    // delete reminder
    public function destroy($id)
    {
        $reminder = Reminders::findOrFail($id);
        $reminder->status = 'deleted';
        $reminder->updated_at = now();
        $reminder->save();

        return redirect()->route('reminders.index')->with('success', 'Reminder deleted successfully.');
    }

    // restore reminder
    public function restore($id)
    {
        $reminder = Reminders::findOrFail($id);
        $reminder->status = 'active';
        $reminder->updated_at = now();
        $reminder->save();

        return redirect()->route('reminders.index')->with('success', 'Reminder restored successfully.');
    }

    // force delete reminder
    public function forceDelete($id)
    {
        $reminder = Reminders::findOrFail($id);
        $reminder->delete();

        return redirect()->route('reminders.index')->with('success', 'Reminder permanently deleted successfully.');
    }

    // togglePrimary
    public function togglePrimary($id)
    {
        $reminder = Reminders::findOrFail($id);

        if (!$reminder->is_primary) {
            // Set all other reminders to not primary
            Reminders::where('is_primary', true)->update(['is_primary' => false]);

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
