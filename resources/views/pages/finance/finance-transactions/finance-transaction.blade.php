<h2 class="intro-y text-lg font-medium mt-10">
    Finance Transactions
</h2>

<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
        <a href="{{ route('finance.transaction.create') }}" class="button text-white bg-theme-1 shadow-md mr-2">
            Add Finance Transaction
        </a>

        <div class="dropdown relative">
            <button class="dropdown-toggle button px-2 box text-gray-700">
                <i class="w-4 h-4" data-feather="more-vertical"></i>
            </button>
            <div class="dropdown-box mt-10 absolute w-44 top-0 left-0 z-20">
                <div class="dropdown-box__content box p-2">
                    <a href="#" class="flex items-center p-2 hover:bg-gray-100 rounded-md transition">
                        <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print
                    </a>
                    <a href="#" class="flex items-center p-2 hover:bg-gray-100 rounded-md transition">
                        <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to Excel
                    </a>
                    <a href="#" class="flex items-center p-2 hover:bg-gray-100 rounded-md transition">
                        <i data-feather="file" class="w-4 h-4 mr-2"></i> Export to PDF
                    </a>
                </div>
            </div>
        </div>

        <div class="hidden md:block mx-auto text-gray-600"></div>

        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0 flex items-center space-x-2">
            {{-- Filter & Search --}}
            <form id="filterForm" action="{{ route('finance.transaction.index') }}" method="GET"
                class="flex items-center space-x-2">
                {{-- Dropdown Kategori --}}
                <div class="relative">
                    <select name="category" id="categoryFilter"
                        class="input box pr-8 w-40 appearance-none cursor-pointer text-gray-700 focus:border-theme-1">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <i class="w-4 h-4 absolute my-auto inset-y-0 right-0 mr-3 text-gray-500"
                        data-feather="chevron-down"></i>
                </div>

                {{-- Search Input --}}
                <div class="w-56 relative text-gray-700">
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                        class="input w-56 box pr-10 placeholder-theme-13" placeholder="Search...">
                    <i data-feather="search"
                        class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0 text-gray-500 pointer-events-none"></i>
                </div>
            </form>

            {{-- Reset Filter --}}
            @if (request('search') || request('category'))
                <button type="button" onclick="window.location.href='{{ route('finance.transaction.index') }}'"
                    class="button w-24 bg-theme-1 text-white">Reset</button>
                {{-- <a href="{{ route('finance.transaction.index') }}"
                    class="text-sm text-gray-500 hover:text-theme-1">Reset</a> --}}
            @endif
        </div>

    </div>

    <!-- BEGIN: Data List -->

    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible mt-5">
        <div class="col-span-12 mt-2 mb-2">
            <div class="intro-y flex items-center h-10 mb-4">
                <h2 class="text-lg font-semibold text-gray-800">
                    Financial Overview
                </h2>
            </div>

            <!-- GRID 4 SUMMARY BOX -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="box p-6 text-center shadow-md border-l-4 border-theme-9 hover:shadow-lg transition duration-300">
                    <div class="text-base font-semibold text-theme-9">Total Income</div>
                    <div class="text-gray-600 mt-1 text-sm">{{ number_format($totalIncome, 0, ',', '.') }}</div>
                </div>

                <div
                    class="box p-6 text-center shadow-md border-l-4 border-theme-6 hover:shadow-lg transition duration-300">
                    <div class="text-base font-semibold text-theme-6">Total Expenses</div>
                    <div class="text-gray-600 mt-1 text-sm">{{ number_format($totalExpense, 0, ',', '.') }}</div>
                </div>

                <div
                    class="box p-6 text-center shadow-md border-l-4 border-theme-1 hover:shadow-lg transition duration-300">
                    <div class="text-base font-semibold text-theme-1">Total Transfers</div>
                    <div class="text-gray-600 mt-1 text-sm">{{ number_format($totalTransfer, 0, ',', '.') }}</div>
                </div>

                <div
                    class="box p-6 text-center shadow-md border-l-4 border-theme-12 hover:shadow-lg transition duration-300">
                    <div class="text-base font-semibold text-theme-12">Net Balance</div>
                    <div class="text-gray-600 mt-1 text-sm font-bold">
                        {{ number_format($netBalance, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>


        <table class="table table-report">
            <thead>
                <tr>
                    <th class="whitespace-nowrap">Finance Category</th>
                    <th class="whitespace-nowrap">Finance Account</th>
                    <th class="text-center whitespace-nowrap">Type</th>
                    <th class="text-center whitespace-nowrap">Amount</th>
                    <th class="text-center whitespace-nowrap">Description</th>
                    <th class="text-center whitespace-nowrap">Date & Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr class="intro-x">
                        <!-- Finance Category -->
                        <td>
                            <a href="#" class="font-medium text-gray-800">{{ $item->financeCategory->name }}</a>
                        </td>

                        <!-- Finance Account -->
                        <td class="text-left">
                            <div class="flex items-center justify-start space-x-2">
                                @if (!empty($item->financeAccount->logo))
                                    <img src="{{ $item->financeAccount->logo }}"
                                        alt="{{ $item->financeAccount->bank_name }} logo"
                                        class="w-16 h-8 rounded object-cover">
                                @else
                                    <div
                                        class="w-8 h-8 rounded bg-gray-200 text-gray-700 flex items-center justify-center text-xs font-medium">
                                        {{ strtoupper(mb_substr($item->financeAccount->bank_name ?? '-', 0, 1)) }}
                                    </div>
                                @endif
                                <span class="text-gray-700">{{ $item->financeAccount->bank_name ?? '-' }}</span>
                            </div>
                        </td>

                        <!-- Type -->
                        <td class="text-center">
                            @php
                                $type = strtolower($item->financeType->name ?? '');
                                if ($type === 'income') {
                                    $badgeBg = 'bg-green-100';
                                    $badgeText = 'text-green-800';
                                    $icon = 'trending-up';
                                } elseif ($type === 'expense') {
                                    $badgeBg = 'bg-red-100';
                                    $badgeText = 'text-red-800';
                                    $icon = 'trending-down';
                                } elseif ($type === 'transfer') {
                                    $badgeBg = 'bg-blue-100';
                                    $badgeText = 'text-blue-800';
                                    $icon = 'shuffle';
                                } elseif ($type === 'withdraw') {
                                    $badgeBg = 'bg-yellow-100';
                                    $badgeText = 'text-yellow-800';
                                    $icon = 'arrow-down';
                                } elseif ($type === 'deposit') {
                                    $badgeBg = 'bg-indigo-100';
                                    $badgeText = 'text-indigo-800';
                                    $icon = 'arrow-up';
                                } else {
                                    $badgeBg = 'bg-gray-100';
                                    $badgeText = 'text-gray-800';
                                    $icon = 'tag';
                            } @endphp
                            <div class="flex items-center justify-center">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $badgeBg }} {{ $badgeText }}"
                                    title="{{ ucfirst($item->financeType->name ?? '') }}">
                                    <i data-feather="{{ $icon }}" class="w-4 h-4 mr-2"></i>
                                    {{ ucfirst($item->financeType->name ?? '') }}
                                </span>
                            </div>
                        </td>

                        <!-- Amount -->
                        <td class="text-center">
                            @php
                                $amount = $item->amount ?? 0;
                                $type = strtolower($item->financeType->name ?? '');
                                if ($type === 'income') {
                                    $amountClass = 'text-green-600';
                                } elseif ($type === 'expense') {
                                    $amountClass = 'text-red-600';
                                } elseif ($type === 'transfer') {
                                    $amountClass = 'text-blue-600';
                                } elseif ($type === 'withdraw') {
                                    $amountClass = 'text-yellow-600';
                                } elseif ($type === 'deposit') {
                                    $amountClass = 'text-indigo-600';
                                } else {
                                    $amountClass = 'text-gray-600';
                                }
                                $sign = $type === 'expense' ? '- ' : '';
                            @endphp
                            <div class="text-lg font-semibold {{ $amountClass }}">
                                {{ $sign }}Rp {{ number_format($amount, 0, ',', '.') }}
                            </div>
                        </td>


                        <!-- Description -->
                        <td class="text-center text-gray-700" title="{{ $item->description }}">
                            {{ \Illuminate\Support\Str::words(strip_tags($item->description ?? ''), 5, '...') }}
                        </td>

                        <!-- Date -->
                        <td class="text-center">
                            @php
                                $dt = $item->date ? \Carbon\Carbon::parse($item->date) : null;
                            @endphp
                            <div class="flex flex-col items-center justify-center h-full">
                                <span class="text-sm font-semibold text-gray-800">
                                    {{ $dt ? $dt->format('d M Y') : '-' }}
                                </span>
                                <span class="mt-1 inline-flex items-center text-xs text-gray-500">
                                    <i data-feather="clock" class="w-3 h-3 mr-1"></i>
                                    {{ $dt ? $dt->format('H:i') : '-' }}
                                </span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->

    <!-- BEGIN: Pagination -->
    <div class="intro-y col-span-12 flex items-center mt-4">
        <div class="w-full flex justify-center sm:justify-end">
            <div class="mt-5">
                {{ $data->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
    <!-- END: Pagination -->
</div>

<!-- BEGIN: Delete Confirmation Modal -->
<div class="modal" id="delete-confirmation-modal">
    <div class="modal__content">
        <div class="p-5 text-center">
            <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
            <div class="text-2xl font-semibold mt-5">Are you sure?</div>
            <div class="text-gray-600 mt-2 text-sm">
                Do you really want to delete this transaction? <br>This action cannot be undone.
            </div>
        </div>
        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Cancel</button>
            <button type="button" class="button w-24 bg-theme-6 text-white">Delete</button>
        </div>
    </div>
</div>
<!-- END: Delete Confirmation Modal -->


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filterForm');
        const category = document.getElementById('categoryFilter');
        const search = document.getElementById('searchInput');
        let debounceTimer;

        // 🔹 Auto submit saat kategori diubah
        category.addEventListener('change', () => {
            form.submit();
        });

        // 🔹 Auto search dengan delay 500ms
        search.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                form.submit();
            }, 500);
        });
    });
</script>
