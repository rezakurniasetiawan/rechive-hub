  <h2 class="intro-y text-lg font-medium mt-10">
      Finance Category
  </h2>
  <div class="grid grid-cols-12 gap-6 mt-5">
      <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
          <a href="{{ route('finance.category.create') }}" class="button text-white bg-theme-1 shadow-md mr-2">Add Finance
              Category</a>
          <div class="dropdown relative">
              <button class="dropdown-toggle button px-2 box text-gray-700">
                  <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i>
                  </span>
              </button>
              <div class="dropdown-box mt-10 absolute w-40 top-0 left-0 z-20">
                  <div class="dropdown-box__content box p-2">
                      <a href=""
                          class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                          <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print </a>
                      <a href=""
                          class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                          <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </a>
                      <a href=""
                          class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                          <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to PDF </a>
                  </div>
              </div>
          </div>
          <div class="hidden md:block mx-auto text-gray-600">Showing 1 to 10 of 150 entries</div>
          <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
              <div class="w-56 relative text-gray-700">
                  <input type="text" class="input w-56 box pr-10 placeholder-theme-13" placeholder="Search...">
                  <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
              </div>
          </div>
      </div> <!-- BEGIN: Data List -->
      <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
          <table class="table table-report -mt-2">
              <thead>
                  <tr>
                      <th class="whitespace-no-wrap">Name</th>
                      <th class="text-center whitespace-no-wrap">Color</th>
                      <th class="text-center whitespace-no-wrap">Type</th>
                      <th class="text-center whitespace-no-wrap">Actions</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($data as $item)
                      <tr class="intro-x cursor-pointer hover:bg-gray-50 transition"
                          onclick="toggleSub({{ $item->id }})">
                          <!-- Name -->
                          <td>
                              <a href="#" class="font-medium whitespace-no-wrap">
                                  {{ $item->name }}
                              </a>
                          </td>

                          <!-- Color -->
                          <td class="text-center">
                              <div class="flex items-center justify-center">
                                  <span class="w-5 h-5 rounded-full" style="background-color: {{ $item->color }};">
                                  </span>
                              </div>
                          </td>

                          <!-- Type (improved UI: colored badge with icon) -->
                          <td class="text-center">
                              @php
                                  $type = strtolower($item->financeType->name ?? '');
                                  if ($type === 'income') {
                                      $badgeBg = 'bg-green-100';
                                      $badgeText = 'text-green-800';
                                      $icon = 'trending-up';
                                  } elseif ($type === 'expense') {
                                      $badgeBg = 'bg-red-100';
                                      $badgeText = 'text-red-800';
                                      $icon = 'trending-down';
                                  } elseif ($type === 'transfer') {
                                      $badgeBg = 'bg-blue-100';
                                      $badgeText = 'text-blue-800';
                                      $icon = 'shuffle';
                                  } elseif ($type === 'withdraw') {
                                      $badgeBg = 'bg-yellow-100';
                                      $badgeText = 'text-yellow-800';
                                      $icon = 'arrow-down';
                                  } elseif ($type === 'deposit') {
                                      $badgeBg = 'bg-indigo-100';
                                      $badgeText = 'text-indigo-800';
                                      $icon = 'arrow-up';
                                  } else {
                                      $badgeBg = 'bg-gray-100';
                                      $badgeText = 'text-gray-800';
                                      $icon = 'tag';
                              } @endphp
                              <div class="flex items-center justify-center">
                                  <span
                                      class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $badgeBg }} {{ $badgeText }}"
                                      title="{{ ucfirst($item->financeType->name ?? '') }}">
                                      <i data-feather="{{ $icon }}" class="w-4 h-4 mr-2"></i>
                                      {{ ucfirst($item->financeType->name ?? '') }}
                                  </span>
                              </div>
                          </td>

                          <!-- Actions -->
                          <td class="table-report__action w-56">
                              <div class="flex justify-center items-center">

                                  <!-- 🔵 Sub Category -->


                                  <a class="flex items-center mr-3 text-indigo-600"
                                      href="{{ route('finance.category.sub.index', $item->id) }}"
                                      onclick="event.stopPropagation();">
                                      <i data-feather="layers" class="w-4 h-4 mr-1"></i> Sub
                                  </a>

                                  <a class="flex items-center mr-3 text-blue-600"
                                      href="{{ route('finance.category.update', ['id' => $item->id]) }}"
                                      onclick="event.stopPropagation();">
                                      <i data-feather="edit" class="w-4 h-4 mr-1"></i> Edit
                                  </a>

                                  <button onclick="event.stopPropagation(); openDeleteModal({{ $item->id }})"
                                      class="flex items-center text-theme-6 tooltip cursor-pointer" title="Delete">
                                      <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                  </button>


                              </div>
                          </td>

                      </tr>
                      <tr id="sub-row-{{ $item->id }}" class="hidden">
                          <td colspan="4" class="p-0">

                              <div class="p-5 bg-gray-50 border-l-4" style="border-color: {{ $item->color }}">

                                  <div class="flex items-center justify-between mb-4">
                                      <div class="font-semibold text-gray-700 text-lg flex items-center">
                                          <i data-feather="layers" class="w-5 h-5 mr-2 text-indigo-600"></i>
                                          Sub Categories — <span
                                              class="text-indigo-600 ml-1">{{ $item->name }}</span>
                                      </div>

                                      <a href="{{ route('finance.category.sub.create', $item->id) }}"
                                          class="inline-flex items-center text-sm px-3 py-1 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 transition">
                                          <i data-feather="plus" class="w-4 h-4 mr-1"></i> Add Sub Category
                                      </a>
                                  </div>

                                  @if ($item->financeSubCategories->count())
                                      <div class="space-y-3">
                                          @foreach ($item->financeSubCategories as $sub)
                                              <div
                                                  class="flex items-center justify-between bg-white p-3 rounded-lg shadow border border-gray-200">

                                                  <!-- Sub Info -->
                                                  <div class="flex items-center">
                                                      <span class="w-4 h-4 rounded-full mr-2 border"
                                                          style="background: {{ $sub->color }}"></span>
                                                      <span
                                                          class="font-medium text-gray-800">{{ $sub->name }}</span>
                                                  </div>

                                                  <!-- Actions -->
                                                  <div class="flex items-center space-x-4">

                                                      <a href="{{ route('finance.category.sub.update', [$item->id, $sub->id]) }}"
                                                          class="text-blue-600 text-sm flex items-center hover:text-blue-800 transition">
                                                          <i data-feather="edit" class="w-4 h-4 mr-1"></i> Edit
                                                      </a>

                                                      <form
                                                          action="{{ route('finance.category.sub.destroy', [$item->id, $sub->id]) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Delete this sub category?')">
                                                          @csrf @method('DELETE')
                                                          <button
                                                              class="text-red-600 text-sm flex items-center hover:text-red-800 transition">
                                                              <i data-feather="trash" class="w-4 h-4 mr-1"></i> Delete
                                                          </button>
                                                      </form>

                                                  </div>
                                              </div>
                                          @endforeach
                                      </div>
                                  @else
                                      <div class="text-gray-500 text-sm italic py-3">
                                          No sub categories found.
                                      </div>
                                  @endif
                              </div>

                          </td>
                      </tr>
                  @endforeach
              </tbody>

          </table>
      </div>
      <!-- END: Data List -->
      <!-- BEGIN: Pagination -->
      <!-- END: Pagination -->
  </div>
  <!-- BEGIN: Delete Confirmation Modal -->
  <div class="modal" id="delete-confirmation-modal">
      <div class="modal__content">
          <form id="deleteForm" method="POST" action="">
              @csrf
              @method('DELETE')

              <div class="p-5 text-center">
                  <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                  <div class="text-2xl font-semibold mt-5">Are you sure?</div>
                  <div class="text-gray-600 mt-2 text-sm">
                      Do you really want to delete this transaction?<br>This action cannot be undone.
                  </div>
              </div>

              <div class="px-5 pb-8 text-center">

                  <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">
                      Cancel
                  </button>

                  <button type="submit" class="button w-24 bg-theme-6 text-white">
                      Delete
                  </button>
              </div>
          </form>
      </div>
  </div>
  <!-- END: Delete Confirmation Modal -->


  <script>
      function openDeleteModal(id) {
          const form = document.getElementById('deleteForm');
          const baseUrl = "{{ url('finance/category/delete') }}";
          form.action = baseUrl + "/" + id;

          $('#delete-confirmation-modal').modal('show'); // ← gunakan ini
      }
  </script>


  <script>
      function toggleSub(id) {
          const row = document.getElementById('sub-row-' + id);

          if (row.classList.contains('hidden')) {
              row.classList.remove('hidden');
              row.style.opacity = 0;
              row.style.height = "0px";

              setTimeout(() => {
                  row.style.transition = "all 0.3s ease";
                  row.style.opacity = 1;
                  row.style.height = "auto";
              }, 10);
          } else {
              row.style.transition = "all 0.3s ease";
              row.style.opacity = 0;
              row.style.height = "0px";

              setTimeout(() => {
                  row.classList.add('hidden');
              }, 300);
          }
      }
  </script>
