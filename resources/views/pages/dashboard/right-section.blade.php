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
               <a href="" class="ml-auto text-theme-1 truncate flex items-center"> <i data-feather="plus"
                       class="w-4 h-4 mr-1"></i> Add New Schedules </a>
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
                           <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden">
                           </div>
                           <span class="font-medium xl:ml-auto">23th</span>
                       </div>
                       <div class="flex items-center mt-4">
                           <div class="w-2 h-2 bg-theme-1 rounded-full mr-3"></div>
                           <span class="truncate">VueJs Frontend Development</span>
                           <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden">
                           </div>
                           <span class="font-medium xl:ml-auto">10th</span>
                       </div>
                       <div class="flex items-center mt-4">
                           <div class="w-2 h-2 bg-theme-12 rounded-full mr-3"></div>
                           <span class="truncate">Laravel Rest API</span>
                           <div class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden">
                           </div>
                           <span class="font-medium xl:ml-auto">31th</span>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <!-- END: Schedules -->
   </div>
