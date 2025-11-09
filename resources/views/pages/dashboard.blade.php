    <div id="main-content" class="grid grid-cols-12 gap-6">
        {{-- Ini dibuka jika ingin menambahkan menu samping kanan --}}
        <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        General Report
                    </h2>
                    <a href="" class="ml-auto flex text-theme-1"> <i data-feather="refresh-ccw"
                            class="w-4 h-4 mr-3"></i>
                        Reload Data </a>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    {{-- 💰 Total Balance --}}
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
                                        <button id="toggleBalance"
                                            class="text-gray-600 hover:text-gray-800 focus:outline-none">
                                            <i data-feather="eye" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Default tersembunyi -->
                                <div id="balanceValue" class="text-3xl font-bold leading-8 mt-6 hidden">
                                    Rp{{ number_format($totalBalance ?? 0, 0, ',', '.') }}
                                </div>
                                <div id="balanceHidden" class="text-3xl font-bold leading-8 mt-6">
                                    ••••••••
                                </div>

                                <div class="text-base text-gray-600 mt-1">Total Balance</div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const toggleBtn = document.getElementById('toggleBalance');
                            const balanceValue = document.getElementById('balanceValue');
                            const balanceHidden = document.getElementById('balanceHidden');
                            let isVisible = false; // default false = saldo tersembunyi

                            toggleBtn.addEventListener('click', () => {
                                isVisible = !isVisible;

                                if (isVisible) {
                                    // Tampilkan saldo
                                    balanceValue.classList.remove('hidden');
                                    balanceHidden.classList.add('hidden');
                                    toggleBtn.innerHTML = '<i data-feather="eye-off" class="w-4 h-4"></i>';
                                } else {
                                    // Sembunyikan saldo
                                    balanceValue.classList.add('hidden');
                                    balanceHidden.classList.remove('hidden');
                                    toggleBtn.innerHTML = '<i data-feather="eye" class="w-4 h-4"></i>';
                                }

                                feather.replace(); // render ulang ikon feather
                            });
                        });
                    </script>



                    {{-- 📈 Income This Month --}}
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
                                    Rp{{ number_format($incomeMonth ?? 0, 0, ',', '.') }}
                                </div>
                                <div class="text-base text-gray-600 mt-1">Income This Month</div>
                            </div>
                        </div>
                    </div>

                    {{-- 📉 Expense This Month --}}
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex items-center">
                                    <i data-feather="trending-down" class="report-box__icon text-theme-6"></i>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-theme-6 tooltip cursor-pointer"
                                            title="Total expenses this month">
                                            -{{ $expenseGrowth ?? 0 }}% <i data-feather="chevron-down"
                                                class="w-4 h-4"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-bold leading-8 mt-6">
                                    Rp{{ number_format($expenseMonth ?? 0, 0, ',', '.') }}
                                </div>
                                <div class="text-base text-gray-600 mt-1">Expense This Month</div>
                            </div>
                        </div>
                    </div>

                    {{-- 🔄 Net Flow --}}
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex items-center">
                                    <i data-feather="bar-chart-2" class="report-box__icon text-theme-12"></i>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator {{ ($netFlow ?? 0) >= 0 ? 'bg-theme-9' : 'bg-theme-6' }} tooltip cursor-pointer"
                                            title="Net flow = Income - Expense">
                                            {{ ($netFlow ?? 0) >= 0 ? '+' : '' }}{{ $netFlowGrowth ?? 0 }}%
                                            <i data-feather="{{ ($netFlow ?? 0) >= 0 ? 'chevron-up' : 'chevron-down' }}"
                                                class="w-4 h-4"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-bold leading-8 mt-6">
                                    Rp{{ number_format($netFlow ?? 0, 0, ',', '.') }}
                                </div>
                                <div class="text-base text-gray-600 mt-1">Net Flow</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- END: General Report -->
            <!-- BEGIN: Sales Report -->
            <div class="col-span-12 lg:col-span-7 mt-8">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Monthly Expense Report
                    </h2>
                    {{-- <div class="sm:ml-auto mt-3 sm:mt-0 relative text-gray-700">
                        <i data-feather="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                        <input type="text" data-daterange="true" class="datepicker input w-full sm:w-56 box pl-10">
                    </div> --}}
                </div>
                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div class="flex flex-col xl:flex-row xl:items-center">
                        <div class="flex">
                            <div>
                                <div class="text-theme-20 text-lg xl:text-xl font-bold">
                                    Rp{{ number_format($expenseMonth ?? 0, 0, ',', '.') }}</div>
                                <div class="text-gray-600">This Month</div>
                            </div>
                            <div class="w-px h-12 border border-r border-dashed border-gray-300 mx-4 xl:mx-6">
                            </div>
                            <div>
                                <div class="text-gray-600 text-lg xl:text-xl font-medium">
                                    Rp{{ number_format($expenseLastMonth ?? 0, 0, ',', '.') }}
                                </div>
                                <div class="text-gray-600">Last Month</div>
                            </div>
                        </div>
                        {{-- <div class="dropdown relative xl:ml-auto mt-5 xl:mt-0">
                            <button
                                class="dropdown-toggle button font-normal border text-white relative flex items-center text-gray-700">
                                Filter by Category <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i>
                            </button>
                            <div class="dropdown-box mt-10 absolute w-40 top-0 xl:right-0 z-20">
                                <div class="dropdown-box__content box p-2 overflow-y-auto h-32"> <a href=""
                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">PC
                                        & Laptop</a> <a href=""
                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">Smartphone</a>
                                    <a href=""
                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">Electronic</a>
                                    <a href=""
                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">Photography</a>
                                    <a href=""
                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">Sport</a>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="report-chart">
                        <canvas id="report-line-chart-rechive-hub" height="250" class="mt-6"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-span-12 sm:col-span-6 lg:col-span-5 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Monthly Expense Categories
                    </h2>
                    {{-- <a href="" class="ml-auto text-theme-1 truncate">See all</a> --}}
                </div>
                <div class="intro-y box p-5 mt-5">
                    {{-- <canvas class="mt-3" id="report-pie-chart-rechive-hub" height="280"></canvas> --}}
                    <canvas id="report-pie-chart-rechive-hub" height="280"></canvas>
                    {{-- <div class="mt-8">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-theme-11 rounded-full mr-3"></div>
                            <span class="truncate">17 - 30 Years old</span>
                            <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden">
                            </div>
                            <span class="font-medium xl:ml-auto">62%</span>
                        </div>
                        <div class="flex items-center mt-4">
                            <div class="w-2 h-2 bg-theme-1 rounded-full mr-3"></div>
                            <span class="truncate">31 - 50 Years old</span>
                            <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden">
                            </div>
                            <span class="font-medium xl:ml-auto">33%</span>
                        </div>
                        <div class="flex items-center mt-4">
                            <div class="w-2 h-2 bg-theme-12 rounded-full mr-3"></div>
                            <span class="truncate">>= 50 Years old</span>
                            <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden">
                            </div>
                            <span class="font-medium xl:ml-auto">10%</span>
                        </div>
                    </div> --}}
                </div>
            </div>
            <!-- BEGIN: General Report -->
            <div class="col-span-12 grid grid-cols-12 gap-6 mt-8">
                <div class="col-span-12 sm:col-span-6 xxl:col-span-6 intro-y">
                    <div class="box p-5 zoom-in">
                        <div class="flex items-center">
                            <div class=" flex-none">
                                <div class="text-lg font-medium">Today's Expenses</div>
                                <div class="text-gray-800 mt-1">{{ $todayExpensesCount }} Transactions</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xxl:col-span-6 intro-y">
                    <div class="box p-5 zoom-in">
                        <div class="flex items-center">
                            <div class=" flex-none">
                                <div class="text-lg font-medium">Month's Expenses</div>
                                <div class="text-gray-800 mt-1">{{ $monthExpensesCount }} Transactions</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: General Report -->
            <div class="col-span-12 lg:col-span-12 mt-8">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Daily Transaction Report
                    </h2>
                </div>
                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div class="report-chart mt-10">
                        <canvas id="report-bar-chart-daily" height="250" class="mt-6"></canvas>
                    </div>
                </div>
                <div class="col-span-12 mt-6">
                    <div class="intro-y flex items-center h-10 mb-4">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200">
                            Monthly Expenses
                        </h2>
                    </div>

                    <!-- GRID 4x4 -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($monthlyExpensesData as $data)
                            <div
                                class="intro-y box p-5 text-center border border-slate-200 dark:border-darkmode-400 hover:shadow-md transition duration-200">
                                <div class="text-base font-semibold text-slate-800 dark:text-slate-100">
                                    {{ $data['month'] }}
                                </div>
                                <div class="text-gray-500 text-sm mt-2">
                                    {{ $data['count'] }} Transactions
                                </div>
                                <div class="text-lg font-bold text-theme-9 mt-3">
                                    Rp {{ number_format($data['amount'], 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


            </div>
            <div class="col-span-12 md:col-span-6 xl:col-span-4 xxl:col-span-12 mt-3">
                <div class="intro-x flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Biometric
                    </h2>
                </div>
                <div id="biometric-section" class="mt-6"></div>
            </div>
            <!-- END: Sales Report -->
            <!-- BEGIN: Weekly Top Seller -->
            {{-- <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Weekly Top Seller
                    </h2>
                    <a href="" class="ml-auto text-theme-1 truncate">See all</a>
                </div>
                <div class="intro-y box p-5 mt-5">
                    <canvas class="mt-3" id="report-pie-chart" height="280"></canvas>
                    <div class="mt-8">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-theme-11 rounded-full mr-3"></div>
                            <span class="truncate">17 - 30 Years old</span>
                            <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden">
                            </div>
                            <span class="font-medium xl:ml-auto">62%</span>
                        </div>
                        <div class="flex items-center mt-4">
                            <div class="w-2 h-2 bg-theme-1 rounded-full mr-3"></div>
                            <span class="truncate">31 - 50 Years old</span>
                            <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden">
                            </div>
                            <span class="font-medium xl:ml-auto">33%</span>
                        </div>
                        <div class="flex items-center mt-4">
                            <div class="w-2 h-2 bg-theme-12 rounded-full mr-3"></div>
                            <span class="truncate">>= 50 Years old</span>
                            <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden">
                            </div>
                            <span class="font-medium xl:ml-auto">10%</span>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- END: Weekly Top Seller -->
            <!-- BEGIN: Sales Report -->
            {{-- <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Sales Report
                    </h2>
                    <a href="" class="ml-auto text-theme-1 truncate">See all</a>
                </div>
                <div class="intro-y box p-5 mt-5">
                    <canvas class="mt-3" id="report-donut-chart" height="280"></canvas>
                    <div class="mt-8">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-theme-11 rounded-full mr-3"></div>
                            <span class="truncate">17 - 30 Years old</span>
                            <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden">
                            </div>
                            <span class="font-medium xl:ml-auto">62%</span>
                        </div>
                        <div class="flex items-center mt-4">
                            <div class="w-2 h-2 bg-theme-1 rounded-full mr-3"></div>
                            <span class="truncate">31 - 50 Years old</span>
                            <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden">
                            </div>
                            <span class="font-medium xl:ml-auto">33%</span>
                        </div>
                        <div class="flex items-center mt-4">
                            <div class="w-2 h-2 bg-theme-12 rounded-full mr-3"></div>
                            <span class="truncate">>= 50 Years old</span>
                            <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden">
                            </div>
                            <span class="font-medium xl:ml-auto">10%</span>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- END: Sales Report -->
            <!-- BEGIN: Official Store -->
            {{-- <div class="col-span-12 xl:col-span-8 mt-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Official Store
                    </h2>
                    <div class="sm:ml-auto mt-3 sm:mt-0 relative text-gray-700">
                        <i data-feather="map-pin" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                        <input type="text" class="input w-full sm:w-40 box pl-10" placeholder="Filter by city">
                    </div>
                </div>
                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div>250 Official stores in 21 countries, click the marker to see location details.</div>
                    <div class="report-maps mt-5 bg-gray-200 rounded-md" data-center="-6.2425342, 106.8626478"
                        data-sources="{{ asset('dist/json/location.json') }}"></div>
                </div>
            </div> --}}
            <!-- END: Official Store -->
            <!-- BEGIN: Weekly Best Sellers -->


            <!-- END: Weekly Best Sellers -->

        </div>
        <div class="col-span-12 xxl:col-span-3 xxl:border-l border-theme-5 -mb-10 pb-10">
            <div class="xxl:pl-6 grid grid-cols-12 gap-6">
                <div class="col-span-12 md:col-span-6 xl:col-span-4 xxl:col-span-12">
                    <h2 class="text-lg font-medium truncate mr-5 mt-6">
                        Today Total Expenses
                    </h2>
                    <div class="box p-5 zoom-in mt-3">
                        <div class="flex items-center">
                            <div class=" flex-none">
                                <div class="text-lg font-medium">
                                    Rp{{ number_format($todayExpensesTotal ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Button Sortcuts --}}
                <div class="col-span-12 md:col-span-6 xl:col-span-4 xxl:col-span-12">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Shortcuts
                    </h2>
                    <div class="grid grid-cols-3 gap-3 mt-3">
                        <a href="{{ route('finance.transaction.create') }}"
                            class="intro-x flex flex-col items-center justify-center px-3 py-5 bg-theme-1 text-white rounded-md">
                            <i data-feather="plus-circle" class="w-8 h-8 mb-2"></i>
                            <div class="text-center text-sm">Add Transaction</div>
                        </a>
                        <a href="{{ route('finance.account.index') }}"
                            class="intro-x flex flex-col items-center justify-center px-3 py-5 bg-theme-9 text-white rounded-md">
                            <i data-feather="credit-card" class="w-8 h-8 mb-2"></i>
                            <div class="text-center text-sm">Accounts</div>
                        </a>
                        <a href="{{ route('finance.category.index') }}"
                            class="intro-x flex flex-col items-center justify-center px-3 py-5 bg-theme-6 text-white rounded-md">
                            <i data-feather="tag" class="w-8 h-8 mb-2"></i>
                            <div class="text-center text-sm">Categories</div>
                        </a>
                    </div>
                </div>




                <!-- BEGIN: Transactions Nws -->
                <div class="col-span-12 md:col-span-6 xl:col-span-4 xxl:col-span-12 mt-3">
                    <div class="intro-x flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Last Transactions
                        </h2>
                    </div>
                    <div class="mt-5">
                        @foreach ($lastTransaction as $transaction)
                            <div class="intro-x">
                                <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                    <div class="w-12 h-10 flex-none image-fit rounded-md overflow-hidden">
                                        <img alt="Logo" src="{{ $transaction->financeAccount->logo }}">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">{{ $transaction->description }}</div>
                                        <div class="text-gray-600 text-xs">
                                            {{ $transaction->date ? \Carbon\Carbon::parse($transaction->date)->format('d M Y') : '-' }}
                                        </div>
                                    </div>
                                    <div
                                        class="{{ $transaction->financeType->name === 'income' ? 'text-theme-9' : 'text-theme-6' }}">
                                        @if ($transaction->financeType->name === 'income')
                                            + Rp{{ number_format($transaction->amount ?? 0, 0, ',', '.') }}
                                        @else
                                            - Rp{{ number_format($transaction->amount ?? 0, 0, ',', '.') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <a href="{{ route('finance.transaction.index') }}"
                            class="intro-x w-full block text-center rounded-md py-3 border border-dotted border-theme-15 text-theme-16">View
                            More</a>
                    </div>
                </div>
                <!-- END: Transactions -->
                <!-- BEGIN: Recent Activities -->
                {{-- <div class="col-span-12 md:col-span-6 xl:col-span-4 xxl:col-span-12 mt-3">
                    <div class="intro-x flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Recent Activities
                        </h2>
                        <a href="" class="ml-auto text-theme-1 truncate">See all</a>
                    </div>
                    <div class="report-timeline mt-5 relative">
                        <div class="intro-x relative flex items-center mb-3">
                            <div class="report-timeline__image">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Midone Tailwind HTML Admin Template"
                                        src="{{ asset('dist/images/profile-9.jpg') }}">
                                </div>
                            </div>
                            <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
                                <div class="flex items-center">
                                    <div class="font-medium">Johnny Depp</div>
                                    <div class="text-xs text-gray-500 ml-auto">07:00 PM</div>
                                </div>
                                <div class="text-gray-600 mt-1">Has joined the team</div>
                            </div>
                        </div>
                        <div class="intro-x relative flex items-center mb-3">
                            <div class="report-timeline__image">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Midone Tailwind HTML Admin Template"
                                        src="{{ asset('dist/images/profile-10.jpg') }}">
                                </div>
                            </div>
                            <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
                                <div class="flex items-center">
                                    <div class="font-medium">Brad Pitt</div>
                                    <div class="text-xs text-gray-500 ml-auto">07:00 PM</div>
                                </div>
                                <div class="text-gray-600">
                                    <div class="mt-1">Added 3 new photos</div>
                                    <div class="flex mt-2">
                                        <div class="tooltip w-8 h-8 image-fit mr-1 zoom-in"
                                            title="Apple MacBook Pro 13">
                                            <img alt="Midone Tailwind HTML Admin Template"
                                                class="rounded-md border border-white"
                                                src="{{ asset('dist/images/preview-8.jpg') }}">
                                        </div>
                                        <div class="tooltip w-8 h-8 image-fit mr-1 zoom-in" title="Dell XPS 13">
                                            <img alt="Midone Tailwind HTML Admin Template"
                                                class="rounded-md border border-white"
                                                src="{{ asset('dist/images/preview-14.jpg') }}">
                                        </div>
                                        <div class="tooltip w-8 h-8 image-fit mr-1 zoom-in" title="Oppo Find X2 Pro">
                                            <img alt="Midone Tailwind HTML Admin Template"
                                                class="rounded-md border border-white"
                                                src="{{ asset('dist/images/preview-5.jpg') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="intro-x text-gray-500 text-xs text-center my-4">12 November</div>
                        <div class="intro-x relative flex items-center mb-3">
                            <div class="report-timeline__image">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Midone Tailwind HTML Admin Template"
                                        src="{{ asset('dist/images/profile-4.jpg') }}">
                                </div>
                            </div>
                            <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
                                <div class="flex items-center">
                                    <div class="font-medium">Al Pacino</div>
                                    <div class="text-xs text-gray-500 ml-auto">07:00 PM</div>
                                </div>
                                <div class="text-gray-600 mt-1">Has changed <a class="text-theme-1"
                                        href="">Sony
                                        Master Series A9G</a> price and description</div>
                            </div>
                        </div>
                        <div class="intro-x relative flex items-center mb-3">
                            <div class="report-timeline__image">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Midone Tailwind HTML Admin Template"
                                        src="{{ asset('dist/images/profile-12.jpg') }}">
                                </div>
                            </div>
                            <div class="box px-5 py-3 ml-4 flex-1 zoom-in">
                                <div class="flex items-center">
                                    <div class="font-medium">Sylvester Stallone</div>
                                    <div class="text-xs text-gray-500 ml-auto">07:00 PM</div>
                                </div>
                                <div class="text-gray-600 mt-1">Has changed <a class="text-theme-1"
                                        href="">Sony
                                        Master Series A9G</a> description</div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- END: Recent Activities -->
                <!-- BEGIN: Important Notes -->
                <div
                    class="col-span-12 md:col-span-6 xl:col-span-12 xxl:col-span-12 xl:col-start-1 xl:row-start-1 xxl:col-start-auto xxl:row-start-auto mt-3">
                    <div class="intro-x flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-auto">
                            Important Notes
                        </h2>
                        <button data-carousel="important-notes" data-target="prev"
                            class="slick-navigator button px-2 border border-gray-400 flex items-center text-gray-700 mr-2">
                            <i data-feather="chevron-left" class="w-4 h-4"></i> </button>
                        <button data-carousel="important-notes" data-target="next"
                            class="slick-navigator button px-2 border border-gray-400 flex items-center text-gray-700">
                            <i data-feather="chevron-right" class="w-4 h-4"></i> </button>
                    </div>
                    <div class="mt-5 intro-x">
                        <div class="slick-carousel box zoom-in" id="important-notes">
                            <div class="p-5">
                                <div class="text-base font-medium truncate">Lorem Ipsum is simply dummy text
                                </div>
                                <div class="text-gray-500 mt-1">20 Hours ago</div>
                                <div class="text-gray-600 text-justify mt-1">Lorem Ipsum is simply dummy text
                                    of the printing and typesetting industry. Lorem Ipsum has been the
                                    industry's standard dummy text ever since the 1500s.</div>
                                <div class="font-medium flex mt-5">
                                    <button type="button" class="button button--sm bg-gray-200 text-gray-600">View
                                        Notes</button>
                                    <button type="button"
                                        class="button button--sm border border-gray-300 text-gray-600 ml-auto">Dismiss</button>
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="font-medium truncate">Lorem Ipsum is simply dummy text</div>
                                <div class="text-gray-500 mt-1">20 Hours ago</div>
                                <div class="text-gray-600 text-justify mt-1">Lorem Ipsum is simply dummy text
                                    of the printing and typesetting industry. Lorem Ipsum has been the
                                    industry's standard dummy text ever since the 1500s.</div>
                                <div class="font-medium flex mt-5">
                                    <button type="button" class="button button--sm bg-gray-200 text-gray-600">View
                                        Notes</button>
                                    <button type="button"
                                        class="button button--sm border border-gray-300 text-gray-600 ml-auto">Dismiss</button>
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="font-medium truncate">Lorem Ipsum is simply dummy text</div>
                                <div class="text-gray-500 mt-1">20 Hours ago</div>
                                <div class="text-gray-600 text-justify mt-1">Lorem Ipsum is simply dummy text
                                    of the printing and typesetting industry. Lorem Ipsum has been the
                                    industry's standard dummy text ever since the 1500s.</div>
                                <div class="font-medium flex mt-5">
                                    <button type="button" class="button button--sm bg-gray-200 text-gray-600">View
                                        Notes</button>
                                    <button type="button"
                                        class="button button--sm border border-gray-300 text-gray-600 ml-auto">Dismiss</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Important Notes -->
                <!-- BEGIN: Schedules -->
                <div
                    class="col-span-12 md:col-span-6 xl:col-span-4 xxl:col-span-12 xl:col-start-1 xl:row-start-2 xxl:col-start-auto xxl:row-start-auto mt-3">
                    <div class="intro-x flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Schedules
                        </h2>
                        <a href="" class="ml-auto text-theme-1 truncate flex items-center"> <i
                                data-feather="plus" class="w-4 h-4 mr-1"></i> Add New Schedules </a>
                    </div>
                    <div class="mt-5">
                        <div class="intro-x box">
                            <div class="p-5">
                                <div class="flex">
                                    <i data-feather="chevron-left" class="w-5 h-5 text-gray-600"></i>
                                    <div class="font-medium mx-auto">April</div>
                                    <i data-feather="chevron-right" class="w-5 h-5 text-gray-600"></i>
                                </div>
                                <div class="grid grid-cols-7 gap-4 mt-5 text-center">
                                    <div class="font-medium">Su</div>
                                    <div class="font-medium">Mo</div>
                                    <div class="font-medium">Tu</div>
                                    <div class="font-medium">We</div>
                                    <div class="font-medium">Th</div>
                                    <div class="font-medium">Fr</div>
                                    <div class="font-medium">Sa</div>
                                    <div class="py-1 rounded relative text-gray-600">29</div>
                                    <div class="py-1 rounded relative text-gray-600">30</div>
                                    <div class="py-1 rounded relative text-gray-600">31</div>
                                    <div class="py-1 rounded relative">1</div>
                                    <div class="py-1 rounded relative">2</div>
                                    <div class="py-1 rounded relative">3</div>
                                    <div class="py-1 rounded relative">4</div>
                                    <div class="py-1 rounded relative">5</div>
                                    <div class="py-1 bg-theme-18 rounded relative">6</div>
                                    <div class="py-1 rounded relative">7</div>
                                    <div class="py-1 bg-theme-1 text-white rounded relative">8</div>
                                    <div class="py-1 rounded relative">9</div>
                                    <div class="py-1 rounded relative">10</div>
                                    <div class="py-1 rounded relative">11</div>
                                    <div class="py-1 rounded relative">12</div>
                                    <div class="py-1 rounded relative">13</div>
                                    <div class="py-1 rounded relative">14</div>
                                    <div class="py-1 rounded relative">15</div>
                                    <div class="py-1 rounded relative">16</div>
                                    <div class="py-1 rounded relative">17</div>
                                    <div class="py-1 rounded relative">18</div>
                                    <div class="py-1 rounded relative">19</div>
                                    <div class="py-1 rounded relative">20</div>
                                    <div class="py-1 rounded relative">21</div>
                                    <div class="py-1 rounded relative">22</div>
                                    <div class="py-1 bg-theme-17 rounded relative">23</div>
                                    <div class="py-1 rounded relative">24</div>
                                    <div class="py-1 rounded relative">25</div>
                                    <div class="py-1 rounded relative">26</div>
                                    <div class="py-1 bg-theme-14 rounded relative">27</div>
                                    <div class="py-1 rounded relative">28</div>
                                    <div class="py-1 rounded relative">29</div>
                                    <div class="py-1 rounded relative">30</div>
                                    <div class="py-1 rounded relative text-gray-600">1</div>
                                    <div class="py-1 rounded relative text-gray-600">2</div>
                                    <div class="py-1 rounded relative text-gray-600">3</div>
                                    <div class="py-1 rounded relative text-gray-600">4</div>
                                    <div class="py-1 rounded relative text-gray-600">5</div>
                                    <div class="py-1 rounded relative text-gray-600">6</div>
                                    <div class="py-1 rounded relative text-gray-600">7</div>
                                    <div class="py-1 rounded relative text-gray-600">8</div>
                                    <div class="py-1 rounded relative text-gray-600">9</div>
                                </div>
                            </div>
                            <div class="border-t border-gray-200 p-5">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-theme-11 rounded-full mr-3"></div>
                                    <span class="truncate">UI/UX Workshop</span>
                                    <div
                                        class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden">
                                    </div>
                                    <span class="font-medium xl:ml-auto">23th</span>
                                </div>
                                <div class="flex items-center mt-4">
                                    <div class="w-2 h-2 bg-theme-1 rounded-full mr-3"></div>
                                    <span class="truncate">VueJs Frontend Development</span>
                                    <div
                                        class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden">
                                    </div>
                                    <span class="font-medium xl:ml-auto">10th</span>
                                </div>
                                <div class="flex items-center mt-4">
                                    <div class="w-2 h-2 bg-theme-12 rounded-full mr-3"></div>
                                    <span class="truncate">Laravel Rest API</span>
                                    <div
                                        class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden">
                                    </div>
                                    <span class="font-medium xl:ml-auto">31th</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Schedules -->
            </div>
        </div>
    </div>

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
                            clip: false,
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
                            clip: false,
                        }
                    ]
                };

                const shadowLine = {
                    id: 'shadowLine',
                    beforeDatasetsDraw(chart) {
                        const {
                            ctx
                        } = chart;
                        chart.data.datasets.forEach((dataset, i) => {
                            const meta = chart.getDatasetMeta(i);
                            if (!meta.hidden) {
                                ctx.save();
                                ctx.shadowColor = dataset.shadowColor || 'transparent';
                                ctx.shadowBlur = dataset.shadowBlur || 0;
                                ctx.shadowOffsetX = 0;
                                ctx.shadowOffsetY = 4;
                            }
                        });
                    },
                    afterDatasetsDraw(chart) {
                        chart.ctx.restore();
                    }
                };

                new Chart(ctx, {
                    type: 'line',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        animations: {
                            tension: {
                                duration: 1500,
                                easing: 'easeOutQuart',
                                from: 0.5,
                                to: 0.35,
                                loop: false
                            },
                            y: {
                                duration: 1200,
                                easing: 'easeOutCubic'
                            },
                            opacity: {
                                duration: 1200,
                                easing: 'easeOutCubic',
                                from: 0,
                                to: 1
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    color: '#374151',
                                    font: {
                                        size: 13,
                                        weight: '600'
                                    },
                                    boxWidth: 20,
                                    padding: 15
                                }
                            },
                            tooltip: {
                                usePointStyle: true,
                                backgroundColor: 'rgba(17,24,39,0.9)',
                                titleFont: {
                                    size: 13,
                                    weight: '600'
                                },
                                bodyFont: {
                                    size: 12
                                },
                                cornerRadius: 8,
                                padding: 10,
                                displayColors: false,
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return numeral(tooltipItem.parsed.y).format('$0,0.00');

                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: '#6B7280',
                                    font: {
                                        size: 12
                                    },
                                    maxRotation: 0,
                                    autoSkipPadding: 10
                                },
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '#6B7280',
                                    font: {
                                        size: 12
                                    },
                                    maxTicksLimit: 5, // ✅ Diubah menjadi maksimal 5 tick
                                    callback: function(value) {
                                        // ✅ Disederhanakan: 'value' sudah berupa angka
                                        return formatRupiah(value);
                                    }
                                },
                                grid: {
                                    color: '#E5E7EB',
                                    drawBorder: false
                                }
                            }
                        }
                    },
                    plugins: [shadowLine]
                });
            });
        </script>
    @endif


    @if (isset($barLabels))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctxBar = document.getElementById('report-bar-chart-daily').getContext('2d');
                const chartHeight = ctxBar.canvas.clientHeight || 300;

                // 🌈 Gradasi warna batang
                const gradientIncomeBar = ctxBar.createLinearGradient(0, 0, 0, chartHeight);
                gradientIncomeBar.addColorStop(0, 'rgba(28, 63, 170, 0.9)');
                gradientIncomeBar.addColorStop(1, 'rgba(28, 63, 170, 0.3)');

                const gradientExpenseBar = ctxBar.createLinearGradient(0, 0, 0, chartHeight);
                gradientExpenseBar.addColorStop(0, 'rgba(220, 38, 38, 0.85)');
                gradientExpenseBar.addColorStop(1, 'rgba(220, 38, 38, 0.3)');

                // 🪙 Format ke Rupiah
                const formatRupiah = (num) => {
                    if (isNaN(num)) return 'Rp 0';
                    return 'Rp ' + Number(num).toLocaleString('id-ID', {
                        minimumFractionDigits: 0
                    });
                };

                const barData = {
                    labels: @json($barLabels),
                    datasets: [{
                            label: 'Income',
                            data: @json($barIncome),
                            backgroundColor: gradientIncomeBar,
                            borderRadius: 6,
                            borderSkipped: false,
                            barThickness: 10,
                        },
                        {
                            label: 'Expense',
                            data: @json($barExpense),
                            backgroundColor: gradientExpenseBar,
                            borderRadius: 6,
                            borderSkipped: false,
                            barThickness: 10,
                        }
                    ]
                };

                new Chart(ctxBar, {
                    type: 'bar',
                    data: barData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        animations: {
                            y: {
                                duration: 1000,
                                easing: 'easeOutCubic'
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    color: '#374151',
                                    font: {
                                        size: 13,
                                        weight: '600'
                                    },
                                    boxWidth: 20,
                                    padding: 15
                                }
                            },
                            tooltip: {
                                usePointStyle: true,
                                backgroundColor: 'rgba(17,24,39,0.9)',
                                titleFont: {
                                    size: 13,
                                    weight: '600'
                                },
                                bodyFont: {
                                    size: 12
                                },
                                cornerRadius: 8,
                                padding: 10,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        const value = Number(context.parsed.y || 0);
                                        return `${context.dataset.label}: ${formatRupiah(value)}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                stacked: false,
                                ticks: {
                                    color: '#6B7280',
                                    font: {
                                        size: 11
                                    },
                                    maxRotation: 0,
                                    autoSkip: true,
                                    autoSkipPadding: 6
                                },
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '#6B7280',
                                    font: {
                                        size: 12
                                    },
                                    callback: function(value) {
                                        return formatRupiah(value);
                                    }
                                },
                                grid: {
                                    color: '#E5E7EB',
                                    drawBorder: false
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endif


    @if (isset($expenseLabels) && count($expenseLabels) > 0)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const pieLabels = @json($expenseLabels);
                const pieData = @json($expenseData);
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

                // --- PERBAIKAN FORMAT RUPIAH ---
                const rupiahFormatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });

                const formatRupiah = (num) => {
                    if (isNaN(num)) return 'Rp 0';
                    return rupiahFormatter.format(num);
                };
                // --- SELESAI PERBAIKAN ---

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
                            animateScale: true,
                            duration: 1200,
                            easing: 'easeOutCubic'
                        },
                        plugins: {
                            title: {
                                // --- 1. JUDUL CHART (SUDAH DI-HIDDEN) ---
                                display: false,
                                text: 'Ringkasan Pengeluaran Bulanan',
                                font: {
                                    size: 18,
                                    weight: '600'
                                },
                                color: '#1C3FAA',
                                padding: {
                                    top: 10,
                                    bottom: 20
                                }
                            },
                            legend: {
                                // --- 2. LEGEND (DI-HIDDEN SESUAI PERMINTAAN BARU) ---
                                display: false, // <-- DIUBAH MENJADI FALSE
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 16,
                                    color: '#374151',
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(17,24,39,0.9)',
                                titleFont: {
                                    size: 13,
                                    weight: '600'
                                },
                                bodyFont: {
                                    size: 12
                                },
                                cornerRadius: 8,
                                padding: 10,
                                displayColors: true,
                                callbacks: {
                                    label: (context) => {
                                        const value = context.raw || 0;
                                        // --- 3. FORMAT RUPIAH (SUDAH DIPERBAIKI) ---
                                        return `${context.label}: ${formatRupiah(value)}`;
                                    }
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
