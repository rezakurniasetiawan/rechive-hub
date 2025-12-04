{{-- resources/views/reports/general-report.blade.php --}}
<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5">General Report</h2>

        {{-- Reload tetap di sini --}}
        <a href="{{ url()->current() }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}"
            class="ml-auto flex items-center text-theme-1 text-sm">
            <i data-feather="refresh-ccw" class="w-4 h-4 mr-2"></i>
            Reload Data
        </a>
    </div>

    {{-- Filter bar --}}
    <div class="flex items-center w-full mt-3">
        <form method="GET" action="{{ url()->current() }}" class="ml-auto flex items-center space-x-3" id="filterForm">
            <label for="period" class="sr-only">Pilih Bulan</label>

            {{-- Modern month picker (preferred) --}}
            <input id="period" name="period" type="month"
                value="{{ request('period') ?? (request('month') && request('year') ? request('year') . '-' . str_pad(request('month'), 2, '0', STR_PAD_LEFT) : date('Y-m')) }}"
                class="form-input block w-40 px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-theme-1"
                aria-label="Filter bulan dan tahun" onchange="document.getElementById('filterForm').submit()" />

            {{-- Fallback select (month only) - will be shown when browser doesn't support input[type=month] --}}
            <div id="fallbackSelect" class="hidden flex items-center space-x-2">
                <select id="monthSelect" name="month" class="form-select w-36 mt-1" aria-label="Bulan">
                    @php
                        $months = [
                            1 => 'January',
                            2 => 'February',
                            3 => 'March',
                            4 => 'April',
                            5 => 'May',
                            6 => 'June',
                            7 => 'July',
                            8 => 'August',
                            9 => 'September',
                            10 => 'October',
                            11 => 'November',
                            12 => 'December',
                        ];
                        // fallback values
                        $reqMonth = request('month') ?? (int) date('n');
                        $reqYear = request('year') ?? date('Y');
                    @endphp
                    <option value="">-- Pilih Bulan --</option>
                    @foreach ($months as $num => $name)
                        <option value="{{ $num }}" {{ (int) $reqMonth === $num ? 'selected' : '' }}>
                            {{ $name }} {{ $reqYear }}</option>
                    @endforeach
                </select>

                <input id="yearSelect" name="year" type="number" min="1900" max="2100"
                    value="{{ $reqYear }}" class="form-input w-24 px-2 py-2 border rounded-md" />
                <button type="submit"
                    class="inline-flex items-center px-3 py-2 border border-gray-200 rounded-md text-sm text-gray-600 hover:bg-gray-50">Apply</button>
            </div>

            {{-- Reset button --}}
            <button type="button" onclick="resetPeriod()" class="button text-white bg-theme-1 shadow-md"
                title="Reset ke bulan sekarang">
                Reset
            </button>
        </form>
    </div>

    {{-- Cards --}}
    <div class="grid grid-cols-12 gap-6 mt-5">
        {{-- Total Balance --}}
        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex items-center">
                        <i data-feather="dollar-sign" class="report-box__icon text-theme-10"></i>
                        <div class="ml-auto flex items-center space-x-2">
                            <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer"
                                title="Updated automatically from accounts">
                                <i data-feather="refresh-ccw" class="w-4 h-4"></i>
                            </div>
                            <button id="toggleBalance" aria-pressed="false"
                                class="text-gray-600 hover:text-gray-800 focus:outline-none"
                                title="Toggle balance visibility">
                                <i data-feather="eye" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <div id="balanceValue" class="text-3xl font-bold leading-8 mt-6 hidden" aria-live="polite">
                        Rp{{ number_format($totalBalance ?? 0, 0, ',', '.') }}
                    </div>
                    <div id="balanceHidden" class="text-3xl font-bold leading-8 mt-6">
                        ••••••••
                    </div>

                    <div class="text-base text-gray-600 mt-1">Total Balance</div>
                </div>
            </div>
        </div>

        {{-- Income This Month --}}
        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex items-center">
                        <i data-feather="trending-up" class="report-box__icon text-theme-9"></i>
                        <div class="ml-auto">
                            <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer"
                                title="Total income this month">
                                +{{ $incomeGrowth ?? 0 }}% <i data-feather="chevron-up" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>
                    <div class="text-3xl font-bold leading-8 mt-6">
                        Rp{{ number_format($incomeMonth ?? 0, 0, ',', '.') }}</div>
                    <div class="text-base text-gray-600 mt-1">Income This Month</div>
                </div>
            </div>
        </div>

        {{-- Expense This Month --}}
        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex items-center">
                        <i data-feather="trending-down" class="report-box__icon text-theme-6"></i>
                        <div class="ml-auto">
                            <div class="report-box__indicator bg-theme-6 tooltip cursor-pointer"
                                title="Total expenses this month">
                                -{{ $expenseGrowth ?? 0 }}% <i data-feather="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>
                    <div class="text-3xl font-bold leading-8 mt-6">
                        Rp{{ number_format($expenseMonth ?? 0, 0, ',', '.') }}</div>
                    <div class="text-base text-gray-600 mt-1">Expense This Month</div>
                </div>
            </div>
        </div>

        {{-- Net Flow --}}
        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex items-center">
                        <i data-feather="bar-chart-2" class="report-box__icon text-theme-12"></i>
                        <div class="ml-auto">
                            <div class="report-box__indicator {{ ($netFlow ?? 0) >= 0 ? 'bg-theme-9' : 'bg-theme-6' }} tooltip cursor-pointer"
                                title="Net flow = Income - Expense">
                                {{ ($netFlow ?? 0) >= 0 ? '+' : '' }}{{ $netFlowGrowth ?? 0 }}% <i
                                    data-feather="{{ ($netFlow ?? 0) >= 0 ? 'chevron-up' : 'chevron-down' }}"
                                    class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>
                    <div class="text-3xl font-bold leading-8 mt-6">Rp{{ number_format($netFlow ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="text-base text-gray-600 mt-1">Net Flow</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Feather icons
        if (typeof feather !== 'undefined') feather.replace();

        // Toggle balance visibility (keamanan/usability)
        const toggleBtn = document.getElementById('toggleBalance');
        const balanceValue = document.getElementById('balanceValue');
        const balanceHidden = document.getElementById('balanceHidden');
        let isVisible = false;

        toggleBtn.addEventListener('click', () => {
            isVisible = !isVisible;
            toggleBtn.setAttribute('aria-pressed', String(isVisible));
            if (isVisible) {
                balanceValue.classList.remove('hidden');
                balanceHidden.classList.add('hidden');
                toggleBtn.innerHTML = '<i data-feather="eye-off" class="w-4 h-4"></i>';
            } else {
                balanceValue.classList.add('hidden');
                balanceHidden.classList.remove('hidden');
                toggleBtn.innerHTML = '<i data-feather="eye" class="w-4 h-4"></i>';
            }
            if (typeof feather !== 'undefined') feather.replace();
        });

        // Feature-detect input[type=month]. If unsupported, show fallback selects.
        const input = document.createElement('input');
        input.setAttribute('type', 'month');
        if (input.type !== 'month') {
            document.getElementById('period').classList.add('hidden');
            document.getElementById('fallbackSelect').classList.remove('hidden');
            // sync fallback to URL period if present
            @if (request('period'))
                try {
                    const parts = "{{ request('period') }}".split('-');
                    if (parts.length === 2) {
                        document.getElementById('monthSelect').value = parseInt(parts[1], 10);
                        document.getElementById('yearSelect').value = parts[0];
                    }
                } catch (e) {}
            @endif
        }
    });

    function resetPeriod() {
        const now = new Date();
        const yyyy = now.getFullYear();
        const mm = String(now.getMonth() + 1).padStart(2, '0');
        const periodInput = document.getElementById('period');
        if (periodInput && !periodInput.classList.contains('hidden')) {
            periodInput.value = `${yyyy}-${mm}`;
            document.getElementById('filterForm').submit();
            return;
        }
        // fallback case: use selects
        const monthSelect = document.getElementById('monthSelect');
        const yearSelect = document.getElementById('yearSelect');
        if (monthSelect && yearSelect) {
            monthSelect.value = now.getMonth() + 1;
            yearSelect.value = yyyy;
            document.getElementById('filterForm').submit();
        }
    }
</script>
