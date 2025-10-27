<div class="intro-y flex items-center mt-8">
    <a onclick="history.back()" class="button text-white bg-theme-1 shadow-md mr-2 inline-flex items-center"
        aria-label="Back">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Back
    </a>


    <h2 class="text-lg font-medium mr-auto">
        Update Finance Account
    </h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-6">
        <!-- BEGIN: Finance Account Form -->
        <form action="{{ route('finance.account.edit', ['id' => $data->id]) }}" method="POST">
            @csrf


            <div class="intro-y box p-5">
                <div class="mt-3">
                    <label class="font-medium">Type</label>
                    <select class="input w-full border mt-2" name="type" value="{{ $data->type }}">
                        <option value="cash" {{ $data->type === 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="bank" {{ $data->type === 'bank' ? 'selected' : '' }}>Bank</option>
                        <option value="ewallet" {{ $data->type === 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                        <option value="other" {{ $data->type === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="mt-3">
                    <label class="font-medium">Logo</label>
                    <input type="text" class="input w-full border mt-2" name="logo"
                        placeholder="e.g., https://link-to-your-logo.com/logo.png" value="{{ $data->logo }}">
                </div>

                <div class="mt-3">
                    <label class="font-medium">Bank Name</label>
                    <input type="text" class="input w-full border mt-2" name="bank_name"
                        placeholder="e.g., Bank Central Asia" value="{{ $data->bank_name }}">
                </div>

                <div class="mt-3">
                    <label class="font-medium">Account Number</label>
                    <input type="text" class="input w-full border mt-2" name="bank_number"
                        placeholder="e.g., 1234567890" value="{{ $data->bank_number }}">
                </div>

                <div class="mt-3">
                    <label class="font-medium">Full Name (Account Owner)</label>
                    <input type="text" class="input w-full border mt-2" name="fullname"
                        placeholder="e.g., Reza Kurnia" value="{{ $data->fullname }}">
                </div>

                <div class="mt-5 text-right">
                    <button type="button" class="button w-24 border text-gray-700 mr-1">Cancel</button>
                    <button type="submit" class="button w-24 bg-theme-1 text-white">Save</button>
                </div>
            </div>
        </form>
        <!-- END: Finance Account Form -->
    </div>
</div>
