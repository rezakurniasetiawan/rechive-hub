@if ($primaryReminder)
    <div x-data="countdownModal('{{ $primaryReminder->target_date }}')" x-init="start()" x-show="open" x-cloak x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div x-transition class="bg-white p-6 rounded-xl shadow-lg w-96 text-center">
            <h2 class="text-lg font-bold mb-2">{{ $primaryReminder->title }}</h2>
            <p class="text-gray-600 text-sm mb-4">{{ $primaryReminder->description }}</p>

            <div class="text-2xl font-semibold mb-4">
                <span x-text="time.days"></span>d :
                <span x-text="time.hours"></span>h :
                <span x-text="time.minutes"></span>m :
                <span x-text="time.seconds"></span>s
            </div>

            <button @click="open = false"
                class=" rounded-2xl bg-theme-1 px-16 py-3 bg-blue-600 text-white shadow-md transition">
                Tutup
            </button>
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
    function countdownModal(targetDate) {
        return {
            open: true,
            target: new Date(targetDate),
            time: {
                days: 0,
                hours: 0,
                minutes: 0,
                seconds: 0
            },

            start() {
                this.updateTime();
                this.timer = setInterval(() => this.updateTime(), 1000);
            },

            updateTime() {
                const now = new Date().getTime();
                const distance = this.target - now;

                if (distance <= 0) {
                    clearInterval(this.timer);
                    this.time = {
                        days: 0,
                        hours: 0,
                        minutes: 0,
                        seconds: 0
                    };
                    return;
                }

                this.time.days = Math.floor(distance / (1000 * 60 * 60 * 24));
                this.time.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                this.time.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                this.time.seconds = Math.floor((distance % (1000 * 60)) / 1000);
            }
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
