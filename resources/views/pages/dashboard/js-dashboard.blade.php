@if (isset($chartLabels))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('report-line-chart-rechive-hub').getContext('2d');
            const chartHeight = ctx.canvas.clientHeight || 300;

            // 🌈 Gradasi warna halus untuk area
            const gradientIncome = ctx.createLinearGradient(0, 0, 0, chartHeight);
            gradientIncome.addColorStop(0, 'rgba(28, 63, 170, 0.4)');
            gradientIncome.addColorStop(1, 'rgba(28, 63, 170, 0)');

            const gradientExpense = ctx.createLinearGradient(0, 0, 0, chartHeight);
            gradientExpense.addColorStop(0, 'rgba(220, 38, 38, 0.3)');
            gradientExpense.addColorStop(1, 'rgba(220, 38, 38, 0)');

            // 🪙 Format ke Rupiah
            const formatRupiah = (num) => {
                if (isNaN(num)) return 'Rp 0';
                return 'Rp ' + Number(num).toLocaleString('id-ID', {
                    minimumFractionDigits: 0
                });
            };

            // 📏 Format singkat untuk label sumbu-Y
            const formatSingkatID = (num) => {
                if (num >= 1000000000) return (num / 1000000000).toFixed(1).replace(/\.0$/, '') + ' Miliar';
                if (num >= 1000000) return (num / 1000000).toFixed(1).replace(/\.0$/, '') + ' Juta';
                if (num >= 1000) return (num / 1000).toFixed(1).replace(/\.0$/, '') + ' Ribu';
                return num.toString();
            };


            const chartData = {
                labels: @json($chartLabels),
                datasets: [{
                        label: 'Income',
                        data: @json($chartIncome),
                        borderWidth: 2,
                        borderColor: '#1C3FAA',
                        backgroundColor: gradientIncome,
                        tension: 0.35,
                        fill: true,
                        pointBackgroundColor: '#1C3FAA',
                        pointRadius: 3,
                        pointHoverRadius: 8,
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 2,
                        shadowColor: 'rgba(28,63,170,0.3)',
                        shadowBlur: 10,
                    },
                    {
                        label: 'Expense',
                        data: @json($chartExpense),
                        borderWidth: 2,
                        borderColor: '#DC2626',
                        backgroundColor: gradientExpense,
                        tension: 0.35,
                        fill: true,
                        pointBackgroundColor: '#DC2626',
                        pointRadius: 3,
                        pointHoverRadius: 8,
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 2,
                    }
                ]
            };

            new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(17,24,39,0.9)',
                        titleFontSize: 13,
                        titleFontStyle: '600',
                        bodyFontSize: 12,
                        cornerRadius: 8,
                        xPadding: 10,
                        yPadding: 10,
                        callbacks: {
                            label: function(tooltipItem) {
                                return formatRupiah(tooltipItem.yLabel);
                            }
                        }
                    },
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            fontColor: '#374151',
                            fontSize: 13,
                            fontStyle: '600',
                            boxWidth: 20,
                            padding: 15
                        }
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                fontColor: '#6B7280',
                                fontSize: 12,
                                autoSkipPadding: 10,
                            },
                            gridLines: {
                                display: false
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                fontColor: '#6B7280',
                                fontSize: 12,
                                maxTicksLimit: 5,
                                callback: function(value) {
                                    return formatSingkatID(
                                        value); // ✅ Gunakan format singkat (K, M)
                                }
                            },
                            gridLines: {
                                color: '#E5E7EB',
                                drawBorder: false
                            }
                        }]
                    }
                }
            });
        });
    </script>
@endif



@if (isset($barLabels))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctxBar = document.getElementById('report-bar-chart-daily').getContext('2d');
            const chartHeight = ctxBar.canvas.clientHeight || 400;

            // 🌈 Gradasi untuk line mode
            const gradientIncome = ctxBar.createLinearGradient(0, 0, 0, chartHeight);
            gradientIncome.addColorStop(0, 'rgba(28, 63, 170, 0.4)');
            gradientIncome.addColorStop(1, 'rgba(28, 63, 170, 0)');


            const gradientExpense = ctxBar.createLinearGradient(0, 0, 0, chartHeight);
            gradientExpense.addColorStop(0, 'rgba(220, 38, 38, 0.3)');
            gradientExpense.addColorStop(1, 'rgba(220, 38, 38, 0)');

            // 🎨 Warna solid untuk bar mode
            const solidIncome = '#1C3FAA';
            const solidExpense = '#DC2626';

            // 🪙 Format Rupiah
            const formatRupiah = (num) => {
                if (num === null || num === undefined || isNaN(num)) return 'Rp 0';
                const number = parseFloat(num);
                return 'Rp ' + number.toLocaleString('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
            };

            // 🔢 Format singkat (Ribu / Juta / Miliar)
            const formatSingkatID = (num) => {
                if (num >= 1_000_000_000) return (num / 1_000_000_000).toFixed(1).replace(/\.0$/, '') +
                    ' Miliar';
                if (num >= 1_000_000) return (num / 1_000_000).toFixed(1).replace(/\.0$/, '') + ' Juta';
                if (num >= 1_000) return (num / 1_000).toFixed(1).replace(/\.0$/, '') + ' Ribu';
                return num.toString();
            };

            let currentType = 'bar';

            // 📊 Data awal
            const chartData = {
                labels: @json($barLabels),
                datasets: [{
                        label: 'Income',
                        data: @json($barIncome),
                        backgroundColor: solidIncome,
                        borderColor: solidIncome,
                        borderWidth: 0,
                        pointBackgroundColor: '#1C3FAA',
                        pointRadius: 3,
                        fill: true,
                        tension: 0.35,
                    },
                    {
                        label: 'Expense',
                        data: @json($barExpense),
                        backgroundColor: solidExpense,
                        borderColor: solidExpense,
                        borderWidth: 0,
                        pointBackgroundColor: '#DC2626',
                        pointRadius: 3,
                        fill: true,
                        tension: 0.35,
                    }
                ]
            };

            // ⚙️ Opsi chart
            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                tooltips: {
                    enabled: true,
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(17, 24, 39, 0.95)',
                    titleFontSize: 14,
                    titleFontStyle: 'bold',
                    bodyFontSize: 13,
                    cornerRadius: 8,
                    xPadding: 14,
                    yPadding: 14,
                    displayColors: true,
                    callbacks: {
                        title: function(tooltipItems) {
                            return '📅 ' + tooltipItems[0].xLabel;
                        },
                        label: function(tooltipItem, data) {
                            const datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                            const value = tooltipItem.yLabel || 0;
                            const icon = datasetLabel === 'Income' ? '💰' : '💸';
                            return `${icon} ${datasetLabel}: ${formatRupiah(value)}`;
                        }
                    }
                },
                legend: {
                    display: true,
                    position: 'top',
                    align: 'end',
                    labels: {
                        fontColor: '#1F2937',
                        fontSize: 14,
                        fontStyle: '600',
                        boxWidth: 20,
                        boxHeight: 12,
                        padding: 15,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            fontColor: '#6B7280',
                            fontSize: 12,
                            autoSkip: true,
                            autoSkipPadding: 10
                        },
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontColor: '#6B7280',
                            fontSize: 11,
                            maxTicksLimit: 6,
                            padding: 10,
                            callback: (value) => formatSingkatID(value)
                        },
                        gridLines: {
                            color: 'rgba(229, 231, 235, 0.8)',
                            drawBorder: false
                        }
                    }]
                },
                layout: {
                    padding: {
                        top: 10,
                        bottom: 10
                    }
                }
            };

            // 🧩 Inisialisasi chart pertama (bar)
            let currentChart = new Chart(ctxBar, {
                type: currentType,
                data: chartData,
                options: chartOptions
            });

            // 🔁 Fungsi toggle chart
            function switchChart(newType) {
                if (currentType === newType) return;
                currentType = newType;

                chartData.datasets.forEach(ds => {
                    if (newType === 'line') {
                        // Line mode → gradasi + border
                        ds.borderWidth = 2;
                        ds.fill = true;
                        ds.backgroundColor = ds.label === 'Income' ? gradientIncome : gradientExpense;
                        ds.borderColor = ds.label === 'Income' ? '#1C3FAA' : '#DC2626';
                    } else {
                        // Bar mode → warna solid
                        ds.borderWidth = 0;
                        ds.fill = true;
                        ds.backgroundColor = ds.label === 'Income' ? solidIncome : solidExpense;
                        ds.borderColor = ds.label === 'Income' ? solidIncome : solidExpense;
                    }
                });

                currentChart.destroy();
                currentChart = new Chart(ctxBar, {
                    type: newType,
                    data: chartData,
                    options: chartOptions
                });
            }

            // 🎚️ Tombol toggle
            const barBtn = document.getElementById('barChartBtn');
            const lineBtn = document.getElementById('lineChartBtn');

            barBtn.addEventListener('click', () => {
                barBtn.classList.replace('bg-transparent', 'bg-blue-600');
                barBtn.classList.replace('text-gray-700', 'text-white');
                lineBtn.classList.replace('bg-blue-600', 'bg-transparent');
                lineBtn.classList.replace('text-white', 'text-gray-700');
                switchChart('bar');
            });

            lineBtn.addEventListener('click', () => {
                lineBtn.classList.replace('bg-transparent', 'bg-blue-600');
                lineBtn.classList.replace('text-gray-700', 'text-white');
                barBtn.classList.replace('bg-blue-600', 'bg-transparent');
                barBtn.classList.replace('text-white', 'text-gray-700');
                switchChart('line');
            });
        });
    </script>
@endif






@if (isset($expenseLabels) && count($expenseLabels) > 0)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pieLabels = @json($expenseLabels);
            const pieData = @json($expenseData).map(v => Number(v)); // pastikan angka
            const pieColors = @json($expenseColors);
            const chartElement = document.getElementById('report-pie-chart-rechive-hub');

            if (!chartElement || !pieLabels?.length || !pieData?.length) {
                console.warn('❌ Pie chart tidak dibuat karena data atau elemen tidak valid.');
                return;
            }

            chartElement.style.width = '100%';
            chartElement.style.height = '325px';
            chartElement.style.maxHeight = '400px';

            const ctxPie = chartElement.getContext('2d');

            // --- FORMAT RUPIAH UNTUK INDONESIA ---
            const rupiahFormatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            const formatRupiah = (num) => {
                const val = Number(num);
                if (isNaN(val)) return 'Rp 0';
                return rupiahFormatter.format(val);
            };

            new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: pieLabels,
                    datasets: [{
                        data: pieData,
                        backgroundColor: pieColors,
                        hoverBackgroundColor: pieColors.map(c => c.replace('0.8', '1')),
                        borderWidth: 4,
                        borderColor: '#fff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        animateRotate: true,
                        animateScale: true
                    },

                    tooltips: {
                        backgroundColor: 'rgba(17,24,39,0.9)',
                        titleFontSize: 13,
                        titleFontStyle: '600',
                        bodyFontSize: 12,
                        cornerRadius: 8,
                        xPadding: 10,
                        yPadding: 10,
                        displayColors: true,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                const label = data.labels[tooltipItem.index] || '';
                                const value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem
                                    .index] || 0;
                                return label + ': ' + formatRupiah(value);
                            }
                        }
                    }
                }
            });
        });
    </script>
@endif

<script>
    document.addEventListener("DOMContentLoaded", checkBiometric);

    async function checkBiometric() {
        try {
            const res = await fetch('/webauthn/check-registration');
            const data = await res.json();
            const section = document.getElementById('biometric-section');

            if (data.registered) {
                section.innerHTML = `
               <div class="intro-x mt-8 p-6 bg-white border border-success/30 rounded-2xl shadow-sm text-center transition-all">
                    <div class="flex flex-col items-center space-y-3">
                        <div class="text-green-600 text-4xl">✅</div>
                        <p class="text-green-700 font-semibold text-lg">
                            Biometrik sudah terdaftar
                        </p>
                        <p class="text-gray-600 text-sm">
                            Kamu dapat memperbarui data biometrik kapan saja.
                        </p>
                        <button id="register-bio"
                            class="btn btn-outline-primary mt-4 px-6 py-2 rounded-xl border-2 border-primary text-primary hover:bg-primary hover:text-white transition">
                            🔄 Perbarui Biometrik
                        </button>
                    </div>
                </div>
            `;
            } else {
                section.innerHTML = `
                <div class="intro-x mt-8 text-center">
                    <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm">
                        <div class="flex flex-col items-center space-y-3">
                            <div class="text-4xl text-primary">🔐</div>
                            <p class="text-gray-700 font-medium">
                                Belum ada biometrik terdaftar
                            </p>
                            <p class="text-gray-500 text-sm">
                                Daftarkan sidik jari atau face ID untuk login cepat & aman.
                            </p>
                            <button id="register-bio"
                                class="btn btn-primary mt-4 px-6 py-2 rounded-xl shadow-md hover:shadow-lg transition">
                                ✳️ Daftarkan Biometrik
                            </button>
                        </div>
                    </div>
                </div>
            `;
            }

            attachRegisterEvent();
        } catch (err) {
            console.error("Gagal memeriksa status biometrik:", err);
        }
    }

    function attachRegisterEvent() {
        const btn = document.getElementById('register-bio');
        if (!btn) return;

        btn.addEventListener('click', async () => {
            if (!window.PublicKeyCredential) {
                return alert("Browser ini tidak mendukung autentikasi biometrik / WebAuthn.");
            }

            try {
                btn.disabled = true;
                btn.classList.add('opacity-70', 'cursor-not-allowed');
                btn.textContent = "Memproses...";

                const res = await fetch('/webauthn/register-challenge');
                const {
                    challenge,
                    user
                } = await res.json();

                const publicKey = {
                    challenge: Uint8Array.from(atob(challenge), c => c.charCodeAt(0)),
                    rp: {
                        name: "RechiveHub",
                        id: window.location.hostname,
                    },
                    user: {
                        id: Uint8Array.from(atob(user.id), c => c.charCodeAt(0)),
                        name: user.name,
                        displayName: user.displayName,
                    },
                    pubKeyCredParams: [{
                            type: "public-key",
                            alg: -7
                        }, // ES256
                        {
                            type: "public-key",
                            alg: -257
                        }, // RS256
                    ],
                    authenticatorSelection: {
                        userVerification: "preferred",
                        authenticatorAttachment: "platform",
                    },
                    timeout: 60000,
                    attestation: "none",
                };

                const credential = await navigator.credentials.create({
                    publicKey
                });

                const body = {
                    id: credential.id,
                    rawId: btoa(String.fromCharCode(...new Uint8Array(credential.rawId))),
                    response: {
                        attestationObject: btoa(String.fromCharCode(...new Uint8Array(credential
                            .response.attestationObject))),
                        clientDataJSON: btoa(String.fromCharCode(...new Uint8Array(credential.response
                            .clientDataJSON))),
                    },
                    type: credential.type,
                };

                const saveRes = await fetch('/webauthn/register-credential', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify(body),
                });

                if (!saveRes.ok) throw new Error("Gagal menyimpan credential");
                alert('✅ Biometrik berhasil didaftarkan!');
                checkBiometric();

            } catch (err) {
                console.error("❌ Error registrasi biometrik:", err);
                if (err.name === "SecurityError") {
                    alert("Domain tidak valid. Gunakan HTTPS atau 'localhost'.");
                } else if (err.name === "NotAllowedError") {
                    alert("Aksi dibatalkan atau perangkat tidak mendukung biometrik.");
                } else {
                    alert("Terjadi kesalahan: " + err.message);
                }
            } finally {
                btn.disabled = false;
                btn.classList.remove('opacity-70', 'cursor-not-allowed');
                btn.textContent = "Daftarkan Biometrik";
            }
        });
    }
</script>
