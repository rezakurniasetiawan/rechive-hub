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

    <h2 class="text-lg font-medium mr-auto">
        Update Finance Transaction
    </h2>
</div>

<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-6">
        <!-- BEGIN: Finance Category Form -->
        <div class="intro-y box p-5">
            <form action="{{ route('finance.category.edit', ['id' => $data->id]) }}" method="POST">
                @csrf

                <!-- Name Field -->
                <div class="mt-3">
                    <label class="font-medium">Category Name</label>
                    <input type="text" name="name" class="input w-full border mt-2"
                        placeholder="e.g., Operational, Savings, Personal Expense" value="{{ $data->name }}" required>
                </div>

                {{-- Type --}}
                <div class="mt-3">
                    <label class="font-medium">
                        Type
                    </label>
                    <select class="input w-full border mt-2" name="type">
                        <option value="income" {{ $data->type === 'income' ? 'selected' : '' }}>Income (Pemasukan)
                        </option>
                        <option value="expense" {{ $data->type === 'expense' ? 'selected' : '' }}>Expense (Pengeluaran)
                        </option>
                        <option value="transfer" {{ $data->type === 'transfer' ? 'selected' : '' }}>Transfer (Antar
                            Akun)</option>
                        <option value="withdraw" {{ $data->type === 'withdraw' ? 'selected' : '' }}>Withdraw (Ambil
                            Tunai dari Bank)</option>
                        <option value="deposit" {{ $data->type === 'deposit' ? 'selected' : '' }}>Deposit (Simpan Tunai
                            ke Bank)</option>
                    </select>
                </div>

                <!-- Color Picker -->
                <div class="mt-3">
                    <label class="font-medium">Category Color</label>
                    <div class="flex items-center gap-3 mt-2">
                        <input type="color" name="color" class="w-12 h-10 border rounded-md cursor-pointer"
                            value ="{{ $data->color }}">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-5 text-right">
                    <button type="button" onclick="history.back()"
                        class="button w-24 border text-gray-700 mr-1">Cancel</button>
                    <button type="submit" class="button w-24 bg-theme-1 text-white">Save</button>
                </div>
            </form>
        </div>
        <!-- END: Finance Category Form -->
    </div>
</div>
