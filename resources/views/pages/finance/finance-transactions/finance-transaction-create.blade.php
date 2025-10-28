<div class="intro-y flex items-center mt-8">
    <a onclick="history.back()" class="button text-white bg-theme-1 shadow-md mr-2 inline-flex items-center"
        aria-label="Back">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Back
    </a>

    <h2 class="text-lg font-semibold text-gray-800 mr-auto tracking-tight">
        Create New Finance Transaction
    </h2>
</div>

<div class="grid grid-cols-12 mt-6">
    <div class="intro-y col-span-12 lg:col-span-10 lg:col-start-2">
        <div class="intro-y box p-6 rounded-xl shadow-sm border border-gray-100 bg-white">

            {{-- STEP 1: Choose Finance Type --}}
            <div id="step-type">
                <label class="font-medium text-gray-800">
                    Finance Type <span class="text-red-600 ml-1">*</span>
                </label>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 mt-3">
                    @foreach ($financeTypes as $item)
                        @php
                            $colors = [
                                'bg-green-100 text-green-700',
                                'bg-blue-100 text-blue-700',
                                'bg-purple-100 text-purple-700',
                                'bg-pink-100 text-pink-700',
                                'bg-orange-100 text-orange-700',
                                'bg-yellow-100 text-yellow-700',
                                'bg-teal-100 text-teal-700',
                                'bg-red-100 text-red-700',
                            ];
                            $color = $colors[crc32($item->label) % count($colors)];
                        @endphp

                        <div class="finance-type-card border-2 border-gray-200 rounded-xl p-3 cursor-pointer 
                                    hover:border-theme-1 hover:shadow-md transition-all duration-150 text-center bg-white"
                            data-id="{{ $item->id }}">
                            <div
                                class="w-10 h-10 mx-auto flex items-center justify-center rounded-lg font-semibold {{ $color }}">
                                {{ strtoupper(substr($item->label, 0, 1)) }}
                            </div>
                            <p class="mt-2 text-sm font-medium text-gray-700 leading-tight text-center">
                                {!! preg_replace('/\s*\(/', '<br>(', e($item->label)) !!}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- STEP 2 & 3: Main Form --}}
            <form id="finance-form" action="{{ route('finance.transaction.store') }}" method="POST"
                class="space-y-6 mt-6 hidden">
                @csrf

                {{-- Hidden Inputs --}}
                <input type="hidden" name="finance_type_id" id="finance_type_id" required>
                <input type="hidden" name="finance_account_id" id="finance_account_id" required>

                {{-- STEP 2: Choose Finance Account --}}
                <div id="step-account" class="hidden">
                    <label class="font-medium text-gray-800">
                        Finance Account <span class="text-red-600 ml-1">*</span>
                    </label>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 mt-3">
                        @foreach ($financeAccounts as $item)
                            <div class="finance-account-card border-2 border-gray-200 rounded-xl p-3 cursor-pointer 
                                        hover:border-theme-1 hover:shadow-md transition-all duration-150 text-center bg-white"
                                data-id="{{ $item->id }}">
                                @if (!empty($item->logo))
                                    <img src="{{ $item->logo }}" alt="{{ $item->bank_name }} logo"
                                        class="mx-auto w-10 h-10 object-contain">
                                @else
                                    <div
                                        class="mx-auto w-10 h-10 flex items-center justify-center bg-gray-100 
                                                rounded-lg text-sm font-semibold text-gray-600">
                                        {{ strtoupper(substr($item->bank_name, 0, 1)) }}
                                    </div>
                                @endif
                                <p class="mt-2 text-sm font-medium text-gray-700 truncate">{{ $item->bank_name }}</p>
                                @if (isset($item->balance))
                                    <p class="text-xs text-gray-500 mt-1">
                                        Rp {{ number_format($item->balance, 0, ',', '.') }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- STEP 3: Transaction Details --}}
                <div id="step-fields" class="hidden">
                    {{-- Finance Category --}}
                    <div>
                        <label class="font-medium text-gray-800">
                            Finance Category <span class="text-red-600 ml-1">*</span>
                        </label>
                        <select id="finance_category_id" name="finance_category_id"
                            class="w-full mt-2 border-gray-300 rounded-lg text-sm" required>
                            <option value="">-- Select Category --</option>
                            @foreach ($financeCategories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Two Columns --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Amount --}}
                        <div>
                            <label class="font-medium text-gray-800">
                                Amount <span class="text-red-600 ml-1">*</span>
                            </label>
                            <input type="number" name="amount" class="input w-full border mt-2 rounded-lg text-sm"
                                step="0.01" placeholder="Enter amount (e.g., 500000)" required>
                        </div>

                        {{-- Date --}}
                        <div>
                            <label class="font-medium text-gray-800">
                                Date & Time <span class="text-red-600 ml-1">*</span>
                            </label>
                            <input type="datetime-local" name="date"
                                class="input w-full border mt-2 rounded-lg text-sm"
                                value="{{ old('date', now()->format('Y-m-d\TH:i')) }}" required>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="font-medium text-gray-800">Description</label>
                        <textarea name="description" class="input w-full border mt-2 rounded-lg text-sm" rows="3"
                            placeholder="Add notes or transaction details (optional)"></textarea>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end pt-4 border-t border-gray-100 mt-6">
                    <button type="button" onclick="history.back()"
                        class="button w-28 border text-gray-700 mr-2 hover:bg-gray-100 transition">
                        Cancel
                    </button>
                    <button type="submit" class="button w-28 bg-theme-1 text-white hover:opacity-90 transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ✅ JS Logic -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Step 1 → Step 2
        document.querySelectorAll('.finance-type-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.finance-type-card').forEach(c =>
                    c.classList.remove('border-theme-1', 'shadow-md'));
                this.classList.add('border-theme-1', 'shadow-md');

                document.getElementById('finance_type_id').value = this.dataset.id;

                const form = document.getElementById('finance-form');
                const accountStep = document.getElementById('step-account');

                form.classList.remove('hidden');
                accountStep.classList.remove('hidden');
                accountStep.scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Step 2 → Step 3
        document.querySelectorAll('.finance-account-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.finance-account-card').forEach(c =>
                    c.classList.remove('border-theme-1', 'shadow-md'));
                this.classList.add('border-theme-1', 'shadow-md');

                document.getElementById('finance_account_id').value = this.dataset.id;

                const stepFields = document.getElementById('step-fields');
                stepFields.classList.remove('hidden');
                stepFields.scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Tom Select (Category)
        new TomSelect('#finance_category_id', {
            create: false,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            placeholder: 'Search or select a category...',
            maxOptions: 100,
        });
    });
</script>

<!-- ✅ Tom Select CSS -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
