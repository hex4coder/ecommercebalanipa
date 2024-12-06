<!-- Card Section -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Grid -->
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
        @foreach ($kategori as $kat)
        <!-- Card -->
        <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800"
            wire:navigate href="{{ "kategori/" . $kat->slug}}">
            <div class="p-4 md:p-5">
                <div class="flex justify-between items-center gap-x-3">
                    <div class="grow">
                        <div class="flex items-center gap-x-3">
                            <img class="size-[38px] rounded-full"
                                src="{{ asset('storage/' . $kat->gambar) }}"
                                alt="Avatar">
                            <div class="grow">
                                <h3
                                    class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:text-neutral-200">
                                    {{$kat->nama_kategori}}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div>
                        <svg class="shrink-0 size-5 text-gray-800 dark:text-neutral-200"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </div>
                </div>
            </div>
        </a>
        <!-- End Card -->

        @endforeach
    </div>
    <!-- End Grid -->
</div>
<!-- End Card Section -->
