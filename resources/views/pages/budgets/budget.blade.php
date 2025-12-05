<!-- Header -->
<div class="intro-y">
    <h2 class="text-xl font-bold mt-10 tracking-wide">Budget Overview</h2>
</div>

<div class="grid grid-cols-12 gap-6 mt-6">

    <!-- SUMMARY (sticky on lg) -->
    <div class="col-span-12 lg:col-span-4">
        <div
            class="p-6 rounded-2xl shadow-lg bg-gradient-to-br from-theme-1 to-theme-1/80 text-white relative overflow-hidden lg:sticky lg:top-6">
            <!-- decorative -->
            <div class="absolute right-4 top-4 opacity-10">
                <svg class="w-24 h-24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M11 11V3"></path>
                    <path d="M20 21V11"></path>
                    <path d="M3 21V7"></path>
                </svg>
            </div>

            <div class="text-2xl font-bold mb-1 leading-tight">January 2025</div>
            <div class="text-white/80 text-xs mb-5">Currency: <span class="font-medium">IDR</span></div>

            <div class="grid grid-cols-2 gap-3 mb-3 text-sm">
                <div>
                    <div class="text-xs text-white/80">Total Budget</div>
                    <div class="text-lg font-semibold">Rp10.000.000</div>
                </div>
                <div class="text-right">
                    <div class="text-xs text-white/80">Utilization</div>
                    <div class="text-lg font-semibold">42%</div>
                </div>
            </div>

            <div class="space-y-2 text-sm">
                <div class="flex justify-between text-white/90">
                    <span>Used</span>
                    <span class="font-semibold text-red-200">Rp4.200.000</span>
                </div>
                <div class="flex justify-between text-white/90">
                    <span>Remaining</span>
                    <span class="font-semibold text-green-200">Rp5.800.000</span>
                </div>
            </div>

            <!-- Progress with mini sparkline (SVG) -->
            <div class="mt-5">
                <div class="w-full h-3 rounded-full bg-white/20 overflow-hidden">
                    <div class="h-3 bg-white rounded-full" style="width: 42%"></div>
                </div>

                <div class="mt-2 flex items-center justify-between text-xs text-white/80">
                    <div>42% used</div>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded-full bg-white/10 text-xs">Active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CATEGORIES -->
    <div class="col-span-12 lg:col-span-8">
        <div class="p-6 rounded-2xl shadow-md bg-white">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold">Budget Categories</h3>
                <div class="flex items-center gap-3">
                    <button
                        class="px-4 py-2 rounded-xl bg-theme-1 text-white font-medium shadow hover:shadow-md transition">+
                        Add Category</button>
                    <select class="text-sm border rounded px-3 py-2">
                        <option>All</option>
                        <option>Personal</option>
                        <option>Business</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <!-- category card -->
                <div class="col-span-12 sm:col-span-6 xl:col-span-4">
                    <div
                        class="p-5 rounded-2xl border border-gray-100 bg-white shadow-sm hover:shadow-lg transition flex flex-col h-full">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-theme-1/10 flex items-center justify-center">
                                <img src="https://cdn-icons-png.flaticon.com/512/1170/1170678.png"
                                    class="w-6 h-6 opacity-90" />
                            </div>
                            <div>
                                <div class="font-semibold text-base">Food & Drinks</div>
                                <div class="text-xs text-gray-500">Monthly limit</div>
                            </div>
                            <div class="ml-auto text-xs px-2 py-1 rounded-full bg-gray-50 text-gray-600">Threshold: 80%
                            </div>
                        </div>

                        <div class="mt-4 flex flex-col gap-2">
                            <div class="flex justify-between text-xs text-gray-600">
                                <span>Allocated</span>
                                <span class="font-semibold text-theme-1">Rp2.000.000</span>
                            </div>
                            <div class="flex justify-between text-xs text-gray-600">
                                <span>Used</span>
                                <span class="font-semibold text-theme-6">Rp750.000</span>
                            </div>

                            <!-- progress + percent badge -->
                            <div class="mt-2 flex items-center gap-3">
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-2 rounded-full"
                                        style="width:37%; background:linear-gradient(90deg,#06b6d4,#34d399)"></div>
                                </div>
                                <div class="text-xs text-gray-500">37%</div>
                            </div>
                        </div>

                        <div class="mt-5 flex justify-between items-center">
                            <div class="text-xs text-gray-500">Last updated 3d</div>
                            <div class="flex items-center gap-3">
                                <button class="text-indigo-600 text-sm hover:underline">Edit</button>
                                <button class="text-rose-500 text-sm hover:underline">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- duplicate card -->
                <div class="col-span-12 sm:col-span-6 xl:col-span-4">
                    <div
                        class="p-5 rounded-2xl border border-gray-100 bg-white shadow-sm hover:shadow-lg transition flex flex-col h-full">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                                <img src="https://cdn-icons-png.flaticon.com/512/1998/1998611.png"
                                    class="w-7 h-7 opacity-90" />
                            </div>
                            <div>
                                <div class="font-semibold text-base">Transportation</div>
                                <div class="text-xs text-gray-500">Monthly limit</div>
                            </div>
                            <div class="ml-auto text-xs px-2 py-1 rounded-full bg-gray-50 text-gray-600">Threshold: 70%
                            </div>
                        </div>

                        <div class="mt-4 flex flex-col gap-2">
                            <div class="flex justify-between text-xs text-gray-600">
                                <span>Allocated</span>
                                <span class="font-semibold text-theme-1">Rp1.200.000</span>
                            </div>
                            <div class="flex justify-between text-xs text-gray-600">
                                <span>Used</span>
                                <span class="font-semibold text-theme-6">Rp500.000</span>
                            </div>

                            <div class="mt-2 flex items-center gap-3">
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-2 rounded-full"
                                        style="width:41%; background:linear-gradient(90deg,#f97316,#f59e0b)"></div>
                                </div>
                                <div class="text-xs text-gray-500">41%</div>
                            </div>
                        </div>

                        <div class="mt-5 flex justify-between items-center">
                            <div class="text-xs text-gray-500">Last updated 1w</div>
                            <div class="flex items-center gap-3">
                                <button class="text-indigo-600 text-sm hover:underline">Edit</button>
                                <button class="text-rose-500 text-sm hover:underline">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty / add more -->
                <div class="col-span-12 sm:col-span-6 xl:col-span-4">
                    <div
                        class="p-5 rounded-2xl border-2 border-dashed border-gray-200 bg-white h-full flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-gray-600">No more categories</div>
                            <button
                                class="mt-3 inline-flex items-center gap-2 px-3 py-2 bg-theme-1 text-white rounded-lg text-sm">Create
                                new category</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
