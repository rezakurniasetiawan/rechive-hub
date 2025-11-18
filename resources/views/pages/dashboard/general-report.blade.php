 <div class="col-span-12 mt-8">
     <div class="intro-y flex items-center h-10">
         <h2 class="text-lg font-medium truncate mr-5">
             General Report
         </h2>
         <a href="" class="ml-auto flex text-theme-1"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i>
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
                             <button id="toggleBalance" class="text-gray-600 hover:text-gray-800 focus:outline-none">
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
                                 -{{ $expenseGrowth ?? 0 }}% <i data-feather="chevron-down" class="w-4 h-4"></i>
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
