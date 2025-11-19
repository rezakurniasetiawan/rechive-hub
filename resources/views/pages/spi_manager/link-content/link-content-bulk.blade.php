<div class="intro-y flex items-center mt-8">
    <a onclick="history.back()" class="button text-white bg-theme-1 shadow-md mr-2 inline-flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Back
    </a>

    <h2 class="text-lg font-medium mr-auto">
        Bulk Upload Link Content
    </h2>
</div>

<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-8">
        <div class="intro-y box p-5">
            <form action="{{ route('spi.content.bulkStore') }}" method="POST">
                @csrf

                <div class="">
                    <label class="font-medium">Paste Multiple Links
                        <span class="text-red-600 ml-1">*</span>
                    </label>
                    <textarea name="links" rows="12" class="input w-full border mt-2 p-3" placeholder="Paste one link per line..."
                        required></textarea>

                    <p class="text-xs text-gray-500 mt-2">
                        • Paste banyak link sekaligus<br>
                        • Sistem akan otomatis mendeteksi platform (IG / TikTok)<br>
                        • Otomatis create ke database satu per satu
                    </p>
                </div>

                <div class="mt-5 text-right">
                    <button type="button" onclick="history.back()" class="button w-24 border text-gray-700 mr-1">
                        Cancel
                    </button>
                    <button type="submit" class="button w-32 bg-theme-1 text-white">
                        Upload All
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
