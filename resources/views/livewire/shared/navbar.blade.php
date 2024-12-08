<header class="sticky top-0 left-0 flex flex-wrap md:justify-start md:flex-nowrap z-50 w-full bg-blue-600">
  <nav class="relative max-w-[66rem] w-full md:flex md:items-center md:justify-between md:gap-3 mx-auto px-4 sm:px-6 lg:px-8 py-2">
    <!-- Logo w/ Collapse Button -->
    <div class="flex items-center justify-between">
      <a wire:navigate href="{{ route('landing') }}" class="flex-none font-semibold text-xl text-white focus:outline-none focus:opacity-80" aria-label="Brand">
        {{config('app.name', 'LaravelWire')}}
      </a>

      <!-- Collapse Button -->
      <div class="md:hidden">
        <button type="button" class="hs-collapse-toggle relative size-9 flex justify-center items-center text-sm font-semibold rounded-lg border border-white/50 text-white hover:bg-white/10 focus:outline-none focus:bg-white/10 disabled:opacity-50 disabled:pointer-events-none" id="hs-base-header-collapse" aria-expanded="false" aria-controls="hs-base-header" aria-label="Toggle navigation" data-hs-collapse="#hs-base-header">
          <svg class="hs-collapse-open:hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
          <svg class="hs-collapse-open:block shrink-0 hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
          <span class="sr-only">Toggle navigation</span>
        </button>
      </div>
      <!-- End Collapse Button -->
    </div>
    <!-- End Logo w/ Collapse Button -->

    <!-- Collapse -->
    <div id="hs-base-header" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:block" aria-labelledby="hs-base-header-collapse">
      <div class="overflow-hidden overflow-y-auto max-h-[75vh] [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
        <div class="py-2 md:py-0 flex flex-col md:flex-row md:items-center md:justify-end gap-0.5 md:gap-1">
          <a wire:navigate href="{{route('landing')}}" class="p-2 flex items-center text-sm focus:outline-none focus:text-white {{request()->is('/') ? 'text-white font-semibold' : 'text-white/80'}}" aria-current="page">
            <svg class="shrink-0 size-4 me-3 md:me-2 block md:hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
            Beranda
          </a>

          <a wire:navigate href="{{route('brand.index')}}" class="p-2 flex items-center text-sm hover:text-white focus:outline-none focus:text-white {{request()->is('brand*') ? 'text-white font-semibold' : 'text-white/80'}}">
            <svg class="shrink-0 size-4 me-3 md:me-2 block md:hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Merek
          </a>

          <a wire:navigate href="{{route('categories.index')}}" class="p-2 flex items-center text-sm hover:text-white focus:outline-none focus:text-white {{request()->is('kategori*') ? 'text-white font-semibold' : 'text-white/80'}}">
            <svg class="shrink-0 size-4 me-3 md:me-2 block md:hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12h.01"/><path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><path d="M22 13a18.15 18.15 0 0 1-20 0"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
            Kategori
          </a>

          <a wire:navigate href="{{route('product.list')}}" class="p-2 flex items-center text-sm hover:text-white focus:outline-none focus:text-white {{request()->is('product*') ? 'text-white font-semibold' : 'text-white/80'}}">
            <svg class="shrink-0 size-4 me-3 md:me-2 block md:hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
            Produk
          </a>

          {{-- halaman cart --}}
          <a wire:navigate href="{{route('keranjang.index')}}" class="p-2 flex items-center text-sm hover:text-white focus:outline-none focus:text-white {{request()->is('keranjang*') ? 'text-white font-semibold' : 'text-white/80'}}">
            <svg class="shrink-0 size-4 me-3 md:me-2 block md:hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
            Keranjang Belanja @livewire('cart.total-item-badge')
          </a>


          {{-- jika belum terautentikasi muncuklkan ini --}}
          <!-- Button Group -->
          <div class="relative flex flex-wrap items-center gap-x-1.5 md:ps-2.5 mt-1 md:mt-0 md:ms-1.5 before:block before:absolute before:top-1/2 before:-start-px before:w-px before:h-4 before:bg-white/30 before:-translate-y-1/2">
            <a wire:navigate class="p-2 w-full flex items-center text-sm hover:text-white focus:outline-none focus:text-white {{request()->is('login*') ? 'text-white font-semibold' : 'text-white/80'}}">
              <svg class="shrink-0 size-4 me-3 md:me-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              Log in
            </a>
          </div>
          <!-- End Button Group -->


          {{-- jika sudah munculkan ini --}}
          {{-- berisi avatar user, profile user, dan halaman checkout --}}
        </div>
      </div>
    </div>
    <!-- End Collapse -->
  </nav>
</header>
