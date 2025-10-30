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

        <div class="hidden md:block mx-auto text-gray-600">Showing 1 to 10 of 150 entries</div>

        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <div class="w-56 relative text-gray-700">
                <input type="text" class="input w-56 box pr-10 placeholder-theme-13" placeholder="Search...">
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0 text-gray-400" data-feather="search"></i>
            </div>
        </div>
    </div>

    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible mt-5">
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
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-no-wrap items-center mt-4">
        <ul class="pagination">
            <li><a class="pagination__link" href=""><i class="w-4 h-4" data-feather="chevrons-left"></i></a></li>
            <li><a class="pagination__link" href=""><i class="w-4 h-4" data-feather="chevron-left"></i></a></li>
            <li><a class="pagination__link pagination__link--active" href="">1</a></li>
            <li><a class="pagination__link" href="">2</a></li>
            <li><a class="pagination__link" href="">3</a></li>
            <li><a class="pagination__link" href=""><i class="w-4 h-4" data-feather="chevron-right"></i></a></li>
            <li><a class="pagination__link" href=""><i class="w-4 h-4" data-feather="chevrons-right"></i></a>
            </li>
        </ul>

        <select class="w-20 input box mt-3 sm:mt-0 ml-auto">
            <option>10</option>
            <option>25</option>
            <option>35</option>
            <option>50</option>
        </select>
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
