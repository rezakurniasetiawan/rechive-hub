<div class="intro-y mt-5">

    <div class="intro-y flex items-center mt-8">
        <a href="{{ route('finance.category.index') }}"
            class="button text-white bg-theme-1 shadow-md mr-2 inline-flex items-center" aria-label="Back">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>

        <h2 class="text-lg font-medium mr-auto">
            {{ $category->name }}
        </h2>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('finance.category.sub.create', $category->id) }}"
            class="button text-white bg-theme-1 shadow-md mr-2 pt-2">
            Add Sub Category
        </a>
    </div>

    <div class="mt-5">
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-no-wrap">Name</th>
                        <th class="text-center whitespace-no-wrap">Color</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subs as $item)
                        <tr class="intro-x">
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

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        {{-- <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Color</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subs as $sub)
                    <tr>
                        <td>{{ $sub->name }}</td>
                        <td>
                            <span
                                style="background: {{ $sub->color }}; padding:5px 10px; border-radius:5px; color:white;">
                                {{ $sub->color }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('category.sub.update', [$category->id, $sub->id]) }}"
                                class="btn btn-warning">Edit</a>

                            <form action="{{ route('category.sub.destroy', [$category->id, $sub->id]) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger"
                                    onclick="return confirm('Delete this sub category?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}
    </div>
</div>
