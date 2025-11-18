<div class="max-w-3xl mx-auto mt-10 p-8 bg-white rounded-3xl shadow-lg border border-gray-200">

    <h2 class=" font-semibold text-gray-800 mb-6 flex items-center gap-2">
        <a onclick="history.back()" class="button text-white bg-theme-1 shadow-md mr-2 inline-flex items-center"
            aria-label="Back">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
        {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg> --}}
        Create New Reminder
    </h2>

    <form action="{{ route('reminders.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label class="text-sm font-medium text-gray-700">Title</label>
            <input name="title" type="text" maxlength="150" required
                class="w-full mt-2 px-4 py-3 border rounded-2xl focus:ring-2
                focus:ring-blue-500 focus:border-blue-500"
                placeholder="e.g. Pay Electricity Bill">
        </div>
        <div>
            <label class="text-sm font-medium text-gray-700">Description (Optional)</label>
            <textarea name="description" rows="3"
                class="w-full mt-2 px-4 py-3 border rounded-2xl focus:ring-blue-500 focus:border-blue-500"
                placeholder="Short description..."></textarea>
        </div>
        <div>
            <label class="text-sm font-medium text-gray-700">Target Date & Time</label>
            <input name="target_date" type="datetime-local" required
                class="w-full mt-2 px-4 py-3 border rounded-2xl focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label class="text-sm font-medium text-gray-700">Category</label>
            <input name="category" type="text" maxlength="50"
                class="w-full mt-2 px-4 py-3 border rounded-2xl focus:ring-blue-500 focus:border-blue-500"
                placeholder="e.g. Finance, Work, Personal (default: custom)">
        </div>
        <div>
            <label class="text-sm font-medium text-gray-700">Repeat</label>
            <select name="repeat_type"
                class="w-full mt-2 px-4 py-3 border rounded-2xl focus:ring-blue-500 focus:border-blue-500">
                <option value="none">None</option>
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700">Notify Before (Hours)</label>
            <input name="notify_before_hours" type="number" min="0" max="168"
                class="w-full mt-2 px-4 py-3 border rounded-2xl focus:ring-blue-500 focus:border-blue-500"
                placeholder="Example: 1 = notify 1 hour before">
        </div>

        <div class="flex justify-end gap-4 mt-8">
            <a href="{{ route('reminders.index') }}"
                class="px-5 py-3 rounded-2xl bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                Cancel
            </a>

            <button type="submit"
                class="bg-theme-1 px-5 py-3 bg-blue-600 text-white hover:bg-blue-700 shadow-md transition">
                Save Reminder
            </button>
        </div>

    </form>
</div>
