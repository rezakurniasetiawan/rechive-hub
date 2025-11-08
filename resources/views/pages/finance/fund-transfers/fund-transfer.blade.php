<div class="intro-y flex items-center mt-8">
    <h2 class="text-2xl font-semibold text-[#1C3FAA] mr-auto">
        Fund Transfer
    </h2>
</div>

<div class="grid grid-cols-12 gap-6 mt-6">
    <!-- FORM CARD -->
    <div class="intro-y col-span-12 lg:col-span-5">
        <div class="bg-white shadow-lg rounded-2xl border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-[#1C3FAA] mb-4">Create New Transfer</h3>

            <!-- Alert Success -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- Alert Error -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>⚠️ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('finance.fundtransfer.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- From Account -->
                <div class="flex items-center">
                    <label class="w-1/3 font-medium text-gray-700">From Account <span
                            class="text-red-500">*</span></label>
                    <select class="select2 w-2/3" name="from_account_id">
                        <option value="">-- Select Source Account --</option>
                        @foreach ($accounts as $acc)
                            <option value="{{ $acc->id }}"
                                {{ old('from_account_id') == $acc->id ? 'selected' : '' }}>
                                {{ $acc->bank_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- To Account -->
                <div class="flex items-center">
                    <label class="w-1/3 font-medium text-gray-700">To Account <span
                            class="text-red-500">*</span></label>
                    <select name="to_account_id" class="select2 w-2/3" required>
                        <option value="">-- Select Destination Account --</option>
                        @foreach ($accounts as $acc)
                            <option value="{{ $acc->id }}"
                                {{ old('to_account_id') == $acc->id ? 'selected' : '' }}>
                                {{ $acc->bank_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Amount -->
                <div class="flex items-center">
                    <label class="w-1/3 font-medium text-gray-700">Amount (Rp) <span
                            class="text-red-500">*</span></label>
                    <div class="w-2/3">
                        <input type="text" id="amount_display"
                            class="w-full border-gray-300 rounded-lg px-3 py-2 border"
                            placeholder="Masukkan nominal transfer" required>
                        <input type="hidden" name="amount" id="amount_hidden" value="{{ old('amount') }}">
                    </div>
                </div>

                <!-- Date -->
                <div class="flex items-center">
                    <label class="w-1/3 font-medium text-gray-700">Transfer Date <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="date" value="{{ old('date') ?? date('Y-m-d') }}"
                        class="w-2/3 border-gray-300 rounded-lg px-3 py-2 border" required>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end pt-4 border-t border-gray-100 mt-6 space-x-3">
                    <button type="submit" class="button w-24 bg-theme-1 text-white">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- TABLE CARD -->
    <div class="intro-y col-span-12 lg:col-span-7">
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2 w-full">
                <thead class="bg-[#1C3FAA]">
                    <tr>
                        <th class="whitespace-no-wrap px-4 py-3">Date</th>
                        <th class="text-center whitespace px-4 py-3">From Account</th>
                        <th class="text-center whitespace-no-wrap px-4 py-3">To Account</th>
                        <th class="text-center whitespace-no-wrap px-4 py-3">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($fundTransfers as $transfer)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="py-3 px-4 font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($transfer->date)->format('d M Y') }}
                            </td>
                            <td class="text-center">{{ $transfer->fromAccount->bank_name ?? 'N/A' }}</td>
                            <td class="text-center">{{ $transfer->toAccount->bank_name ?? 'N/A' }}</td>
                            <td class="py-3 px-4 text-right font-semibold text-gray-800">
                                Rp {{ number_format($transfer->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">No transfer records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $fundTransfers->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<!-- === Format Rupiah Script === -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const display = document.getElementById('amount_display');
        const hidden = document.getElementById('amount_hidden');

        // Jika ada nilai lama (old value)
        if (hidden.value) {
            display.value = formatRupiah(hidden.value);
        }

        display.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d]/g, '');
            hidden.value = value; // kirim integer ke server
            e.target.value = formatRupiah(value);
        });

        function formatRupiah(angka) {
            if (!angka) return '';
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    });
</script>
