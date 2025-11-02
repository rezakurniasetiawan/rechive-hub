<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pengeluaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --primary: #1C3FAA;
        }

        [x-cloak] {
            display: none !important;
        }

        body {
            background-color: #f7f9fc;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-gray-100 font-inter">

    <div x-data="pengeluaranForm()" x-cloak
        class="flex-1 flex flex-col max-w-md w-full mx-auto bg-white shadow-md sm:rounded-none md:rounded-2xl md:my-8">

        <!-- Header -->
        <div class="bg-[var(--primary)] text-white py-4 px-6 rounded-b-2xl shadow-md">
            <h1 class="text-lg font-semibold text-center">Tambah Pengeluaran</h1>
        </div>

        <!-- Form -->
        <form @submit.prevent="submitForm" class="flex-1 flex flex-col justify-between p-6 overflow-y-auto">

            <div class="space-y-2">
                <!-- Step 1 -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Jenis</label>
                    <select x-model="form.finance_type_id" name="finance_type_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:ring-2 focus:ring-[var(--primary)] focus:outline-none">
                        <option value="">Pilih Jenis</option>
                        @foreach ($financeTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Step 2 -->
                <div x-show="form.finance_type_id" x-transition.opacity.duration.300>
                    <label class="block text-gray-700 font-semibold mb-1">Kategori</label>
                    <select x-model="form.finance_category_id" name="finance_category_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:ring-2 focus:ring-[var(--primary)] focus:outline-none">
                        <option value="">Pilih Kategori</option>
                        @foreach ($financeCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Step 3 -->
                <div x-show="form.finance_category_id" x-transition.opacity.duration.300>
                    <label class="block text-gray-700 font-semibold mb-1">Akun</label>
                    <select x-model="form.finance_account_id" name="finance_account_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:ring-2 focus:ring-[var(--primary)] focus:outline-none">
                        <option value="">Pilih Akun</option>
                        @foreach ($financeAccounts as $account)
                            <option value="{{ $account->id }}">{{ $account->bank_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Step 4 -->
                <div x-show="form.finance_account_id" x-transition.opacity.duration.300>
                    <label class="block text-gray-700 font-semibold mb-1">Jumlah</label>
                    <input type="text" x-model="form.amountFormatted" @input="formatRupiah"
                        placeholder="Masukkan jumlah pengeluaran"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:ring-2 focus:ring-[var(--primary)] focus:outline-none">
                </div>

                <!-- Step 5 -->
                <div x-show="form.amount" x-transition.opacity.duration.300>
                    <label class="block text-gray-700 font-semibold mb-1">Deskripsi</label>
                    <textarea x-model="form.description" name="description" rows="3" placeholder="Tambahkan deskripsi..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:ring-2 focus:ring-[var(--primary)] focus:outline-none"></textarea>
                </div>

                <!-- Step 6 -->
                <div x-show="form.description" x-transition.opacity.duration.300>
                    <label class="block text-gray-700 font-semibold mb-1">Tanggal</label>
                    <input type="datetime-local" x-model="form.date" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-gray-800 focus:ring-2 focus:ring-[var(--primary)] focus:outline-none"
                        value="{{ now()->format('Y-m-d\TH:i') }}">
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div x-show="form.date" class="pt-4 border-t border-gray-200 mt-2">
                <button type="submit"
                    class="w-full px-6 py-3 text-sm font-medium rounded-lg bg-green-600 text-white hover:bg-green-700 shadow-md transition">
                    ✅ Simpan
                </button>
            </div>
        </form>
    </div>

    <script>
        function pengeluaranForm() {
            return {
                form: {
                    finance_type_id: '',
                    finance_category_id: '',
                    finance_account_id: '',
                    amountFormatted: '',
                    amount: 0,
                    description: '',
                    date: '{{ now()->format('Y-m-d\TH:i') }}',
                },

                formatRupiah() {
                    let numberString = this.form.amountFormatted.replace(/[^,\d]/g, '');
                    let split = numberString.split(',');
                    let sisa = split[0].length % 3;
                    let rupiah = split[0].substr(0, sisa);
                    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                    if (ribuan) {
                        let separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }

                    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                    this.form.amountFormatted = rupiah ? 'Rp ' + rupiah : '';
                    this.form.amount = parseInt(numberString || 0);
                },

                async submitForm() {
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]').content;
                        const response = await fetch("{{ route('transactions.store') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": token,
                            },
                            body: JSON.stringify(this.form),
                        });

                        if (!response.ok) throw await response.json();

                        alert('✅ Pengeluaran berhasil disimpan!');
                        this.resetForm();

                    } catch (err) {
                        alert('❌ Terjadi kesalahan. Periksa input atau koneksi Anda.');
                    }
                },

                resetForm() {
                    this.form = {
                        finance_type_id: '',
                        finance_category_id: '',
                        finance_account_id: '',
                        amountFormatted: '',
                        amount: 0,
                        description: '',
                        date: '{{ now()->format('Y-m-d\TH:i') }}',
                    };
                }
            };
        }
    </script>
</body>

</html>
