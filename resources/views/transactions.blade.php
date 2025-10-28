<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Catatan Keuangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- 🎉 SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        html,
        body {
            height: 100%;
            background: #f8fafc;
            overflow: hidden;
        }

        .step {
            display: none;
            height: calc(100vh - 12rem);
            overflow-y: auto;
            opacity: 0;
            transform: translateX(40px);
            transition: all 0.5s ease;
        }

        .step.active {
            display: block;
            opacity: 1;
            transform: translateX(0);
        }

        .num-button {
            background-color: #1C3FAA;
            color: white;
            border-radius: 1rem;
            width: 100%;
            font-size: 1.5rem;
            font-weight: 600;
            transition: transform 0.1s;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .num-button:active {
            transform: scale(0.95);
        }

        .bottom-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: white;
            border-top: 1px solid #e5e7eb;
            padding: 1rem;
            box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.05);
            z-index: 50;
        }

        .stepper-dot.active {
            background-color: #1C3FAA;
            transform: scale(1.2);
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 100;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            text-align: center;
            max-width: 320px;
            animation: zoomIn 0.4s ease;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#4F46E5',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#EF4444',
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                html: `
                    <ul style="text-align:left; margin-left:20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                confirmButtonColor: '#F59E0B',
            });
        </script>
    @endif
</head>

<body class="flex flex-col h-full">

    <!-- HEADER -->
    <header
        class="p-5 bg-gradient-to-r from-[#1C3FAA] to-[#1e4ccf] text-white text-center font text-xl shadow-md sticky top-0 z-40">
        <span class="text-lg">ReChive<span class="font-bold">Hub</span></span> - Transaction
    </header>

    <!-- STEPPER -->
    <div class="px-6 py-4 bg-white border-b border-gray-200 shadow-sm">
        <div class="flex items-center justify-between relative">
            <div id="progress-bar" class="absolute top-1/2 left-0 h-1 bg-[#1C3FAA] transition-all duration-500"
                style="width: 0%;"></div>
            <div class="flex justify-between w-full">
                <div class="stepper-dot w-4 h-4 rounded-full bg-gray-300 relative z-10"></div>
                <div class="stepper-dot w-4 h-4 rounded-full bg-gray-300 relative z-10"></div>
                <div class="stepper-dot w-4 h-4 rounded-full bg-gray-300 relative z-10"></div>
                <div class="stepper-dot w-4 h-4 rounded-full bg-gray-300 relative z-10"></div>
                <div class="stepper-dot w-4 h-4 rounded-full bg-gray-300 relative z-10"></div>
            </div>
        </div>
        <div class="flex justify-between mt-2 text-xs text-gray-500">
            <span>Jenis</span><span>Kategori</span><span>Akun</span><span>Jumlah</span><span>Deskripsi</span>
        </div>
    </div>

    <!-- FORM UTAMA -->
    <form id="transactionForm" class="flex-1 relative p-6 space-y-6" method="POST"
        action="{{ route('transactions.store') }}">
        @csrf

        <!-- Step 1 -->
        <div id="step1" class="step active fade-in">
            <h2 class="text-lg font-semibold mb-6 text-gray-700 text-center">Pilih Jenis Transaksi</h2>
            <div class="grid grid-cols-2 gap-5">
                @foreach ($financeTypes as $type)
                    <div class="cursor-pointer border rounded-2xl p-6 text-center bg-white shadow-md hover:shadow-xl hover:border-[#1C3FAA] transition transform hover:-translate-y-1"
                        data-type="{{ strtolower($type->label) }}" data-id="{{ $type->id }}">
                        <div class="text-5xl mb-3">
                            @if (Str::contains(strtolower($type->label), 'income'))
                                💰
                            @elseif (Str::contains(strtolower($type->label), 'expense'))
                                💸
                            @else
                                🔄
                            @endif
                        </div>
                        <p class="font-semibold text-gray-700">{{ $type->label }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Step 2 -->
        <div id="step2" class="step">
            <h2 class="text-lg font-semibold mb-6 text-gray-700 text-center">Pilih Kategori</h2>
            <div id="categoryButtons" class="grid grid-cols-2 gap-4">
                @foreach ($financeCategories as $category)
                    <button type="button"
                        class="category-btn border rounded-xl py-4 bg-white hover:bg-[#1C3FAA] hover:text-white shadow font-medium transition"
                        data-id="{{ $category->id }}">
                        {{ $category->label ?? $category->name }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Step 3 -->
        <div id="step3" class="step">
            <h2 class="text-lg font-semibold mb-6 text-gray-700 text-center">Pilih Akun Keuangan</h2>
            <div id="accountButtons" class="space-y-4">
                @foreach ($financeAccounts as $account)
                    <button type="button"
                        class="account-btn w-full border rounded-xl py-4 bg-white shadow hover:bg-[#1C3FAA] hover:text-white transition"
                        data-id="{{ $account->id }}">
                        @if ($account->logo)
                            <img src="{{ $account->logo }}" alt="{{ $account->fullname }}"
                                class="inline-block w-6 h-6 mr-2 rounded-full object-cover">
                        @endif
                        {{ $account->bank_name ?? $account->name }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Step 4 -->
        <div id="step4" class="step">
            <h2 class="text-lg font-semibold mb-6 text-gray-700 text-center">Masukkan Jumlah</h2>
            <input id="amountInput" type="text" readonly placeholder="Rp 0"
                class="w-full border rounded-2xl p-4 text-2xl text-center mb-4 focus:ring-[#1C3FAA] focus:border-[#1C3FAA]" />
            <div class="grid grid-cols-3 gap-2 mb-6">
                @for ($i = 1; $i <= 9; $i++)
                    <button type="button" class="num-button py-6 text-xl">{{ $i }}</button>
                @endfor
                <button type="button" class="num-button col-span-2 py-6 text-xl">0</button>
                <button type="button" id="clearAmount"
                    class="bg-red-500 text-white rounded-2xl font-bold text-lg px-0 py-6 w-full">C</button>
            </div>
        </div>

        <!-- Step 5 -->
        <div id="step5" class="step">
            <h2 class="text-lg font-semibold mb-6 text-gray-700 text-center">Deskripsi</h2>
            <textarea id="descInput" rows="3" placeholder="Contoh: Beli kopi di Starbucks"
                class="w-full border rounded-2xl p-4 text-gray-700 shadow focus:ring-[#1C3FAA] focus:border-[#1C3FAA]"></textarea>
        </div>

        <!-- Hidden Inputs -->
        <input type="hidden" name="finance_type_id" id="finance_type_id">
        <input type="hidden" name="finance_category_id" id="finance_category_id">
        <input type="hidden" name="finance_account_id" id="finance_account_id">
        <input type="hidden" name="amount" id="amountHidden">
        <input type="hidden" name="description" id="descriptionHidden">
        <input type="hidden" name="date" id="dateHidden" value="{{ date('Y-m-d H:i:s') }}">

        <!-- BOTTOM -->
        <div class="bottom-bar">
            <button type="button" id="nextBtn"
                class="w-full bg-[#1C3FAA] text-white py-3 rounded-xl font-semibold text-lg shadow-md hover:opacity-90 transition">
                Lanjut
            </button>
        </div>
    </form>


    <!-- MODAL -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <div class="text-5xl mb-3">🎉</div>
            <h3 class="font-bold text-lg mb-2">Transaksi Tersimpan!</h3>
            <p class="text-sm text-gray-600 mb-4">Data keuanganmu berhasil disimpan.</p>
            <button id="closeModal"
                class="bg-[#1C3FAA] text-white py-2 px-6 rounded-lg font-semibold shadow hover:opacity-90">Tutup</button>
        </div>
    </div>

    <script>
        const steps = ["step1", "step2", "step3", "step4", "step5"];
        let currentStep = 0;
        const nextBtn = document.getElementById("nextBtn");
        const dots = document.querySelectorAll(".stepper-dot");
        const progressBar = document.getElementById("progress-bar");
        const modal = document.getElementById("successModal");

        // Stepper visual
        function updateStepper() {
            dots.forEach((dot, i) => dot.classList.toggle("active", i <= currentStep));
            progressBar.style.width = `${(currentStep / (steps.length - 1)) * 100}%`;
        }

        function showStep(index) {
            steps.forEach((id, i) => {
                const el = document.getElementById(id);
                el.classList.toggle("active", i === index);
            });
            nextBtn.innerText = index === steps.length - 1 ? "Simpan Transaksi" : "Lanjut";
            updateStepper();
        }

        // Step 1: pilih tipe transaksi
        document.querySelectorAll("[data-type]").forEach(el => {
            el.addEventListener("click", () => {
                document.getElementById("finance_type_id").value = el.dataset.id; // ← gunakan ID dari DB
                nextStep();
            });
        });

        // Step 2: pilih kategori
        document.querySelectorAll(".category-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                document.getElementById("finance_category_id").value = btn.dataset.id;
                nextStep();
            });
        });

        // Step 3: pilih akun
        document.querySelectorAll(".account-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                document.getElementById("finance_account_id").value = btn.dataset.id;
                nextStep();
            });
        });

        // Step 4: input jumlah
        const amountInput = document.getElementById("amountInput");
        document.querySelectorAll(".num-button").forEach(btn => {
            btn.addEventListener("click", () => {
                amountInput.value = (amountInput.value + btn.innerText).replace(/^0+/, '');
            });
        });
        document.getElementById("clearAmount").onclick = () => (amountInput.value = "");

        function nextStep() {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            } else {
                submitTransaction();
            }
        }

        async function submitTransaction() {
            // set hidden fields
            const cleanAmount = amountInput.value.replace(/[^\d]/g, ''); // hanya angka
            document.getElementById("amountHidden").value = cleanAmount;
            document.getElementById("descriptionHidden").value = document.getElementById("descInput").value.trim();

            const form = document.getElementById("transactionForm");
            const formData = new FormData(form);
            // print for debugging
            console.log("Submitting:", Object.fromEntries(formData.entries()));

            try {
                const res = await fetch(form.action, {
                    method: "POST",
                    headers: {
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData,
                });

                console.log("Response status:", res.status);

                if (res.ok) {
                    modal.classList.add("active");
                } else {
                    const errorText = await res.text();
                    console.error("Error:", errorText);
                    alert("❌ Gagal menyimpan transaksi!\nPeriksa konsol untuk detail.");
                }
            } catch (e) {
                console.error(e);
                alert("Terjadi kesalahan koneksi.");
            }
        }

        document.getElementById("closeModal").onclick = () => {
            modal.classList.remove("active");
            currentStep = 0;
            showStep(currentStep);
            document.getElementById("transactionForm").reset();
            document.getElementById("amountInput").value = "";
        };

        nextBtn.onclick = nextStep;
        showStep(currentStep);
    </script>

</body>

</html>
