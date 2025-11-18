@if ($primaryReminder)
    <div x-data="countdownModal('{{ $primaryReminder->target_date }}', '{{ $primaryReminder->created_at }}')" x-init="start()" x-show="open" x-cloak x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div x-transition.scale class="bg-white w-full max-w-md p-6 rounded-2xl shadow-2xl relative overflow-hidden">
            <!-- Top gradient -->
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-indigo-600"></div>

            <!-- Header -->
            <div class="flex flex-col items-center text-center">
                <div class="bg-blue-100 p-3 rounded-full mb-3">
                    <!-- VALID ICON -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <h2 class="text-xl font-bold text-gray-800">
                    {{ $primaryReminder->title }}
                </h2>

                <p class="text-gray-600 text-sm mt-1">
                    {{ $primaryReminder->description }}
                </p>
            </div>

            <!-- Countdown -->
            <div class="mt-5 flex justify-center gap-4">
                <template x-for="(value, key) in time" :key="key">
                    <div class="text-center">
                        <div class="text-3xl font-extrabold text-gray-900" x-text="value"></div>
                        <div class="text-xs uppercase tracking-wider text-gray-500" x-text="key"></div>
                    </div>
                </template>
            </div>

            <!-- Additional Data -->
            <div class="mt-6 grid grid-cols-2 gap-3">

                <!-- Time Passed -->
                <div class="bg-gray-50 p-3 rounded-xl text-center">
                    <p class="text-xs text-gray-500">Sudah Berjalan</p>
                    <p class="text-sm font-semibold" x-text="timePassedText"></p>
                </div>

                <!-- Total Time Left -->
                <div class="bg-gray-50 p-3 rounded-xl text-center">
                    <p class="text-xs text-gray-500">Sisa Waktu</p>
                    <p class="text-sm font-semibold" x-text="timeLeftText"></p>
                </div>

                <!-- Reminder Age -->
                <div class="bg-gray-50 p-3 rounded-xl text-center col-span-2">
                    <p class="text-xs text-gray-500">Reminder dibuat</p>
                    <p class="text-sm font-semibold" x-text="createdAgo"></p>
                </div>

            </div>


            <!-- Target date -->
            <div class="mt-4 bg-gray-50 p-3 rounded-xl text-center">
                <p class="text-sm text-gray-700">
                    Target Date:
                    <span class="font-semibold text-gray-900">
                        {{ \Carbon\Carbon::parse($primaryReminder->target_date)->format('d M Y H:i') }}
                    </span>
                </p>
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex justify-between">
                <a href="{{ route('reminders.index') }}"
                    class="px-5 py-2 text-sm bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                    Lihat Semua Reminder
                </a>

                <button @click="open = false"
                    class="px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow transition">
                    Tutup
                </button>
            </div>

        </div>
    </div>
@endif



<div id="main-content" class="grid grid-cols-12 gap-6">
    <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
        @include('pages.dashboard.general-report')
        @include('pages.dashboard.monthly-expense-report')
        @include('pages.dashboard.monthly-expense-categories')
        @include('pages.dashboard.count-expense-transactions')

        @include('pages.dashboard.daily-transaction-report')
        @include('pages.dashboard.biometric-card')
    </div>
    <div class="col-span-12 xxl:col-span-3 xxl:border-l border-theme-5 -mb-10 pb-10">
        @include('pages.dashboard.right-section')
    </div>
</div>

@include('pages.dashboard.js-dashboard')
<script>
    function countdownModal(targetDate, createdAt) {
        return {
            open: true,
            target: new Date(targetDate).getTime(),
            created: new Date(createdAt).getTime(),

            time: {
                days: 0,
                hours: 0,
                minutes: 0,
                seconds: 0
            },

            timeLeftText: "",
            timePassedText: "",
            createdAgo: "",

            start() {
                this.updateTime();
                this.timer = setInterval(() => this.updateTime(), 1000);
            },

            updateTime() {
                const now = Date.now();
                const distance = this.target - now;

                // Countdown utama
                this.time.days = Math.floor(distance / (1000 * 60 * 60 * 24));
                this.time.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                this.time.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                this.time.seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Sisa waktu total (jam/menit)
                const hoursLeft = Math.floor(distance / (1000 * 60 * 60));
                const minsLeft = Math.floor(distance / (1000 * 60));
                this.timeLeftText = `${hoursLeft} Jam (${minsLeft} Menit)`;

                // Sudah berjalan
                const elapsed = now - this.created;
                const elapsedHours = Math.floor(elapsed / (1000 * 60 * 60));
                const elapsedMinutes = Math.floor((elapsed % (1000 * 60 * 60)) / (1000 * 60));
                this.timePassedText = `${elapsedHours} Jam ${elapsedMinutes} Menit`;

                // Created ago (relative)
                const diffSec = Math.floor((now - this.created) / 1000);
                if (diffSec < 60) {
                    this.createdAgo = `${diffSec} detik lalu`;
                } else if (diffSec < 3600) {
                    this.createdAgo = `${Math.floor(diffSec / 60)} menit lalu`;
                } else if (diffSec < 86400) {
                    this.createdAgo = `${Math.floor(diffSec / 3600)} jam lalu`;
                } else {
                    this.createdAgo = `${Math.floor(diffSec / 86400)} hari lalu`;
                }
            }
        }
    }
</script>


<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
