<!-- BEGIN: Data List -->
<div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
    <a href="{{ route('spi.content.create') }}" class="button text-white bg-theme-1 shadow-md mr-2">Add
        Link</a>
    <a href="{{ route('spi.content.bulkCreate') }}" class="button text-white bg-theme-1 shadow-md mr-2">Add
        Build Link</a>
</div>
<div class="intro-y col-span-12 overflow-auto lg:overflow-visible mt-8">
    <h3 class="text-lg font-semibold mb-3">Pending</h3>
    <table class="table table-report -mt-2">
        <thead>
            <tr>
                <th class="whitespace-no-wrap">Platform</th>
                <th class="whitespace-no-wrap">Video URL</th>
                <th class="text-center whitespace-no-wrap">Copied On</th>
                <th class="text-center whitespace-no-wrap">Status</th>
                <th class="text-center whitespace-no-wrap">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pending as $item)
                <tr class="intro-x">
                    <!-- Name -->
                    <td>
                        <a href="#" class="font-medium whitespace-no-wrap">
                            {{ $item->platform }}
                        </a>
                    </td>

                    <!-- Konten -->
                    <td class="font-medium whitespace-no-wrap">
                        {{ $item->video_url }}
                    </td>

                    {{-- copied_at --}}
                    <td class="text-center">
                        {{ $item->copied_at ? \Carbon\Carbon::parse($item->copied_at)->diffForHumans() : 'N/A' }}
                    </td>

                    <!-- Status -->
                    <td class="text-center">
                        <span
                            class="px-2 py-1 rounded-full text-xs bg-yellow-200 text-yellow-800 border border-yellow-300">
                            Pending
                        </span>
                    </td>

                    <!-- Actions -->
                    <td class="table-report__action w-56">
                        <div class="flex justify-center items-center">
                            {{-- Pending: boleh Copy Link + Delete --}}
                            <a class="flex items-center mr-3 text-blue-600 hover:text-blue-700"
                                href="{{ route('spi.content.copyLink', $item->id) }}"
                                onclick="copyToClipboard('{{ $item->video_url }}')">
                                <i data-feather="copy" class="w-4 h-4 mr-1"></i> Copy Link
                            </a>
                            <a class="flex items-center text-theme-6 hover:text-red-700" href="javascript:;"
                                data-toggle="modal" data-target="#delete-confirmation-modal">
                                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-500">Tidak ada data pending.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $pending->appends(request()->except('pending_page'))->links() }}
    </div>
</div>

{{-- BAGIAN 2 & 3: COPIED (KIRI) dan USED (KANAN) --}}
<div class="intro-y col-span-12 lg:col-span-6 overflow-auto lg:overflow-visible mt-8">
    <h3 class="text-lg font-semibold mb-3">Copied</h3>
    <table class="table table-report -mt-2">
        <thead>
            <tr>
                <th class="whitespace-no-wrap">Platform</th>
                <th class="whitespace-no-wrap">Video URL</th>
                <th class="text-center whitespace-no-wrap">Copied On</th>
                <th class="text-center whitespace-no-wrap">Status</th>
                <th class="text-center whitespace-no-wrap">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($copied as $item)
                <tr class="intro-x">
                    <!-- Name -->
                    <td>
                        <a href="#" class="font-medium whitespace-no-wrap">
                            {{ $item->platform }}
                        </a>
                    </td>

                    <!-- Konten -->
                    <td class="font-medium whitespace-no-wrap">
                        {{ $item->video_url }}
                    </td>

                    {{-- copied_at --}}
                    <td class="text-center">
                        {{ $item->copied_at ? \Carbon\Carbon::parse($item->copied_at)->diffForHumans() : 'N/A' }}
                    </td>

                    <!-- Status -->
                    <td class="text-center">
                        <span class="px-2 py-1 rounded-full text-xs bg-blue-200 text-blue-800 border border-blue-300">
                            Copied
                        </span>
                    </td>

                    <!-- Actions -->
                    <td class="table-report__action w-56">
                        <div class="flex justify-center items-center">
                            {{-- Copied: boleh Mark as Used + Delete --}}
                            <a class="flex items-center mr-3 text-yellow-600 hover:text-yellow-700"
                                href="{{ route('spi.content.markAsUsed', $item->id) }}">
                                <i data-feather="check-circle" class="w-4 h-4 mr-1"></i> Mark as Used
                            </a>
                            <a class="flex items-center text-theme-6 hover:text-red-700" href="javascript:;"
                                data-toggle="modal" data-target="#delete-confirmation-modal">
                                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-500">Tidak ada data copied.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $copied->appends(request()->except('copied_page'))->links() }}
    </div>
</div>

<div class="intro-y col-span-12 lg:col-span-6 overflow-auto lg:overflow-visible mt-8">
    <h3 class="text-lg font-semibold mb-3">Used</h3>
    <table class="table table-report -mt-2">
        <thead>
            <tr>
                <th class="whitespace-no-wrap">Platform</th>
                <th class="whitespace-no-wrap">Video URL</th>
                <th class="text-center whitespace-no-wrap">Copied On</th>
                <th class="text-center whitespace-no-wrap">Status</th>
                <th class="text-center whitespace-no-wrap">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($used as $item)
                <tr class="intro-x">
                    <!-- Name -->
                    <td>
                        <a href="#" class="font-medium whitespace-no-wrap">
                            {{ $item->platform }}
                        </a>
                    </td>

                    <!-- Konten -->
                    <td class="font-medium whitespace-no-wrap">
                        {{ $item->video_url }}
                    </td>

                    {{-- copied_at --}}
                    <td class="text-center">
                        {{ $item->copied_at ? \Carbon\Carbon::parse($item->copied_at)->diffForHumans() : 'N/A' }}
                    </td>

                    <!-- Status -->
                    <td class="text-center">
                        <span
                            class="px-2 py-1 rounded-full text-xs bg-green-200 text-green-800 border border-green-300">
                            Used
                        </span>
                    </td>

                    <!-- Actions -->
                    <td class="table-report__action w-56">
                        <div class="flex justify-center items-center">
                            {{-- Used: mungkin hanya Delete --}}
                            <a class="flex items-center text-theme-6 hover:text-red-700" href="javascript:;"
                                data-toggle="modal" data-target="#delete-confirmation-modal">
                                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-500">Tidak ada data used.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $used->appends(request()->except('used_page'))->links() }}
    </div>
</div>
<!-- END: Data List -->

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            console.log('Text copied to clipboard');
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    }
</script>
