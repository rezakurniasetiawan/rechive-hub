<div class="flex items-center justify-between mt-10 mb-8">
    <div>
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Reminder</h2>
        <p class="text-slate-500 text-sm mt-1">Manage your daily schedules and tasks.</p>
    </div>
    <a href="{{ route('reminders.create') }}" class="button text-white bg-theme-1 shadow-md mr-2 px-5 py-3 transition">
        Create New Reminder
    </a>

</div>

<div class="mb-10">
    <div class="flex items-center gap-2 mb-4 px-1">
        <div class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-pulse"></div>
        <h3 class="text-xl font-bold text-slate-800 flex items-center">
            <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                </path>
            </svg>
            Active Reminders
        </h3>
        <span
            class="px-3 py-0.5 text-sm font-semibold bg-emerald-100 text-emerald-700 rounded-full">{{ $activeReminders->total() }}</span>
    </div>

    <div class="bg-white border border-indigo-200 rounded-xl shadow-xl overflow-hidden">
        <ul class="divide-y divide-slate-100">
            @forelse ($activeReminders as $reminder)
                <li class="group hover:bg-indigo-50 transition duration-150 ease-in-out">
                    <div class="flex items-center px-6 py-4">
                        <div class="min-w-0 flex-1 flex items-start">
                            <div class="flex-shrink-0 pt-1 relative">
                                @if ($reminder->is_primary)
                                    <div
                                        class="absolute -top-2 -left-2 bg-amber-400 text-white rounded-full p-1.5 shadow-lg z-10">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                                <div
                                    class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1 px-4">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="text-base font-bold text-slate-900 truncate">{{ $reminder->title }}
                                    </p>
                                    <div class="flex items-center gap-3 ml-2">
                                        @if ($reminder->is_primary)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                                Primary
                                            </span>
                                        @endif
                                        @if ($reminder->category)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 border border-indigo-200 px-2">
                                                {{ $reminder->category }}
                                            </span>
                                        @endif
                                        <div
                                            class="flex items-center text-xs text-slate-600 bg-slate-100 px-2 py-1 rounded border border-slate-200">
                                            <svg class="mr-2 h-4 w-4 text-slate-400 " fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>

                                            {{ \Carbon\Carbon::parse($reminder->target_date)->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-2">
                                    <p class="text-sm text-slate-500 truncate max-w-md">
                                        {{ $reminder->description ?? 'Tidak ada deskripsi tambahan.' }}</p>

                                    <div class="flex items-center gap-2 flex-shrink-0 ml-4">
                                        <form action="{{ route('reminders.togglePrimary', $reminder->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="p-1.5 hover:text-amber-600 hover:bg-amber-100 rounded-md transition {{ $reminder->is_primary ? 'text-amber-600 bg-amber-50' : 'text-slate-500' }}"
                                                title="{{ $reminder->is_primary ? 'Remove Primary' : 'Set as Primary' }}">
                                                <svg class="w-5 h-5"
                                                    fill="{{ $reminder->is_primary ? 'currentColor' : 'none' }}"
                                                    stroke="{{ $reminder->is_primary ? 'none' : 'currentColor' }}"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                        <a href="{{ route('reminders.edit', $reminder->id) }}"
                                            class="p-1.5 text-slate-500 hover:text-indigo-600 hover:bg-indigo-100 rounded-md transition"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('reminders.destroy', $reminder->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-rose-100 rounded-md transition"
                                                title="Hapus"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus pengingat ini?');">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-6 py-12 text-center">
                    <div class="mx-auto h-12 w-12 text-slate-300">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <h3 class="mt-2 text-base font-medium text-slate-900">No active reminders</h3>
                    <p class="mt-1 text-sm text-slate-500">Time to create a new reminder!</p>
                </li>
            @endforelse
        </ul>

        {{-- Pagination Aktif --}}
        @if ($activeReminders->hasPages())
            <div class="p-4 border-t border-indigo-100 bg-indigo-50/50">
                {{ $activeReminders->links() }}
            </div>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    <div>
        <div class="flex items-center gap-2 mb-4 px-1">
            <div class="w-2.5 h-2.5 bg-green-500 rounded-full"></div>
            <h3 class="text-xl font-bold text-slate-700 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Completed
            </h3>
            <span
                class="px-3 py-0.5 text-sm font-medium bg-green-100 text-green-700 rounded-full">{{ $completedReminders->total() }}</span>
        </div>

        <div class="bg-white border border-green-200 rounded-xl shadow-md overflow-hidden">
            <ul class="divide-y divide-green-50">
                @forelse ($completedReminders as $reminder)
                    <li class="px-5 py-4 hover:bg-green-50 transition">
                        <div class="flex items-center justify-between">
                            <div class="min-w-0 flex-1">
                                <p class="text-base font-medium text-slate-500 line-through truncate">
                                    {{ $reminder->title }}</p>
                                <p class="text-xs text-slate-400 mt-0.5 flex items-center gap-2">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Done</span>
                                    Completed:
                                    {{ \Carbon\Carbon::parse($reminder->updated_at)->format('d M Y') }}
                                </p>
                            </div>
                            <form action="{{ route('reminders.restore', $reminder->id) }}" method="POST"
                                class="ml-4 flex-shrink-0">
                                @csrf
                                <button type="submit"
                                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800 hover:underline">Recover</button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="px-5 py-6 text-center text-sm text-slate-500">🎉 No completed reminders yet.</li>
                @endforelse
            </ul>

            {{-- Pagination Selesai --}}
            @if ($completedReminders->hasPages())
                <div class="p-3 border-t border-green-100 bg-green-50/50">
                    {{ $completedReminders->links() }}
                </div>
            @endif
        </div>
    </div>

    <div>
        <div class="flex items-center gap-2 mb-4 px-1">
            <div class="w-2.5 h-2.5 bg-rose-500 rounded-full"></div>
            <h3 class="text-xl font-bold text-slate-700 flex items-center">
                <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
                Trash
            </h3>
            <span
                class="px-3 py-0.5 text-sm font-medium bg-rose-100 text-rose-700 rounded-full">{{ $deletedReminders->total() }}</span>
        </div>

        <div class="bg-white border border-rose-200 rounded-xl shadow-md overflow-hidden">
            <ul class="divide-y divide-rose-100">
                @forelse ($deletedReminders as $reminder)
                    <li class="px-5 py-4 hover:bg-rose-50 transition">
                        <div class="flex items-center justify-between">
                            <div class="min-w-0 flex-1">
                                <p class="text-base font-medium text-rose-700 truncate">{{ $reminder->title }}</p>
                                <p class="text-xs text-rose-400 mt-0.5 flex items-center gap-2">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">Deleted</span>
                                    Deleted: {{ \Carbon\Carbon::parse($reminder->deleted_at)->format('d M Y') }}
                                </p>
                            </div>
                            <div class="flex items-center gap-3 ml-4">
                                <form action="{{ route('reminders.restore', $reminder->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="text-sm font-medium text-indigo-600 hover:text-indigo-800 hover:underline">Recover</button>
                                </form>
                                <form action="{{ route('reminders.forceDelete', $reminder->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-sm font-medium text-rose-600 hover:text-rose-800 hover:underline"
                                        onclick="return confirm('PERINGATAN! Tindakan ini akan menghapus pengingat secara permanen. Lanjutkan?');">Delete</button>
                                </form>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-5 py-6 text-center text-sm text-slate-500">Trash is empty.</li>
                @endforelse
            </ul>

            {{-- Pagination Trash --}}
            @if ($deletedReminders->hasPages())
                <div class="p-3 border-t border-rose-100 bg-rose-50/50">
                    {{ $deletedReminders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
