  <div class="col-span-12 lg:col-span-12 mt-8">
      <div class="intro-y block sm:flex items-center h-10">
          <h2 class="text-lg font-medium truncate mr-5">
              Daily Transaction Report
          </h2>

          <!-- 🔘 Toggle Chart Type -->
          <div class="ml-auto flex items-center space-x-3">
              <div class="inline-flex rounded-lg border border-gray-200 bg-white p-1 shadow-sm">
                  <button id="barChartBtn"
                      class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-semibold transition-all duration-200 ease-in-out hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                      <i data-feather="bar-chart-2" class="w-4 h-4 inline-block mr-1.5"></i>
                      Bar
                  </button>
                  <button id="lineChartBtn"
                      class="px-4 py-2 bg-transparent text-gray-700 rounded-md text-sm font-semibold transition-all duration-200 ease-in-out hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-1">
                      <i data-feather="trending-up" class="w-4 h-4 inline-block mr-1.5"></i>
                      Line
                  </button>
              </div>
          </div>
      </div>
      <div class="intro-y box p-5 mt-12 sm:mt-5">
          <div class="report-chart mt-10">
              <canvas id="report-bar-chart-daily" height="325" class="mt-6"></canvas>
          </div>
      </div>
      <div class="col-span-12 mt-6">
          <div class="intro-y flex items-center h-10 mb-4">
              <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200">
                  Annual Report
              </h2>
          </div>

          <!-- GRID 4x4 -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
              @foreach ($monthlyExpensesData as $data)
                  @php
                      $netFlow = ($data['income_amount'] ?? 0) - ($data['expense_amount'] ?? $data['amount']);
                      $isProfit = $netFlow >= 0;
                  @endphp
                  <div
                      class="intro-y box p-5 border border-slate-200 dark:border-darkmode-400 hover:shadow-lg transition duration-300 rounded-xl">
                      <!-- Header with Icon and Month -->
                      <div class="flex items-center justify-between mb-4">
                          <div class="flex items-center space-x-2">
                              <div
                                  class="w-10 h-10 flex items-center justify-center {{ $isProfit ? 'bg-green-100' : 'bg-red-100' }} rounded-full">
                                  <i data-feather="{{ $isProfit ? 'trending-up' : 'trending-down' }}"
                                      class="w-5 h-5 {{ $isProfit ? 'text-green-600' : 'text-red-600' }}"></i>
                              </div>
                              <div class="text-base font-semibold text-slate-800 dark:text-slate-100">
                                  {{ $data['month'] }}
                              </div>
                          </div>
                      </div>

                      <!-- Expense Section -->
                      <div class="mb-4 pb-4 border-b border-slate-200 dark:border-darkmode-400">
                          <div class="flex items-center justify-between mb-2">
                              <span class="text-xs text-gray-500 flex items-center">
                                  <i data-feather="arrow-down-circle" class="w-3 h-3 mr-1 text-red-500"></i>
                                  Expense
                              </span>
                              <span class="text-xs text-gray-500">
                                  {{ $data['expense_count'] ?? $data['count'] }} Transactions
                              </span>
                          </div>
                          <div class="text-lg font-bold text-red-600">
                              Rp {{ number_format($data['expense_amount'] ?? $data['amount'], 0, ',', '.') }}
                          </div>
                      </div>

                      <!-- Income Section -->
                      <div>
                          <div class="flex items-center justify-between mb-2">
                              <span class="text-xs text-gray-500 flex items-center">
                                  <i data-feather="arrow-up-circle" class="w-3 h-3 mr-1 text-green-500"></i>
                                  Income
                              </span>
                              <span class="text-xs text-gray-500">
                                  {{ $data['income_count'] ?? 0 }} Transactions
                              </span>
                          </div>
                          <div class="text-lg font-bold text-green-600">
                              Rp {{ number_format($data['income_amount'] ?? 0, 0, ',', '.') }}
                          </div>
                      </div>

                      <!-- Net Flow Indicator -->
                      <div class="mt-4 pt-4 border-t border-slate-200 dark:border-darkmode-400">
                          <div class="flex items-center justify-between">
                              <span class="text-xs text-gray-500 flex items-center">
                                  <i data-feather="bar-chart-2" class="w-3 h-3 mr-1"></i>
                                  Net Flow
                              </span>
                              <span class="text-sm font-semibold {{ $isProfit ? 'text-green-600' : 'text-red-600' }}">
                                  {{ $isProfit ? '+' : '' }}Rp
                                  {{ number_format(abs($netFlow), 0, ',', '.') }}
                              </span>
                          </div>
                      </div>
                  </div>
              @endforeach
          </div>
      </div>


  </div>
