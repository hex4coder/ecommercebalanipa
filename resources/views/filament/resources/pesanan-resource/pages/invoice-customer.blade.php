<x-filament-panels::page>
<!-- Invoice -->
<div class="max-w-[90%] px-4 sm:px-6 lg:px-8 mx-auto my-4 sm:my-10">
    <div class="sm:w-11/12 lg:w-3/4 mx-auto">
      <!-- Card -->
      <div class="flex flex-col p-4 sm:p-10 bg-white shadow-md rounded-xl dark:bg-neutral-800">
        <!-- Grid -->
        <div class="flex justify-between">
          <div>
            <img src="{{ asset('img/logo.png') }}" alt="" class="w-12">
  
            <h1 class="mt-2 text-lg md:text-xl font-semibold text-blue-600 dark:text-white">E-Commerce SMKN Balanipa.</h1>
          </div>
          <!-- Col -->
  
          <div class="text-end">
            <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 dark:text-neutral-200">Invoice #</h2>
            <span class="mt-1 block text-gray-500 dark:text-neutral-500">Order ID {{$order->id}}</span>
  
            <address class="mt-4 not-italic text-nvalid value for 'pull.rebase': '='gray-800 dark:text-neutral-200">
                Jl. Bulu Dua <br>Desa Tammangalle <br>Kec. Balanipa
            </address>
          </div>
          <!-- Col -->
        </div>
        <!-- End Grid -->
  
        <!-- Grid -->
        <div class="mt-8 grid sm:grid-cols-2 gap-3">
          <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Dikirim ke:</h3>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">{{$order->user->name}}</h3>
            <address class="mt-2 not-italic text-gray-500 dark:text-neutral-500">
              {{$order->user->full_address()}}
            </address>
          </div>
          <!-- Col -->
  
          <div class="sm:text-end space-y-2">
            <!-- Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
              <dl class="grid sm:grid-cols-5 gap-x-3">
                <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Tanggal Pemesanan:</dt>
                <dd class="col-span-2 text-gray-500 dark:text-neutral-500">{{date('d/m/Y',strtotime($order->tanggal))}}</dd>
              </dl>
              <dl class="grid sm:grid-cols-5 gap-x-3">
                <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Status Pesanan:</dt>
                <dd class="col-span-2 capitalize text-gray-500 dark:text-neutral-500">{{$order->status}}</dd>
              </dl>
            </div>
            <!-- End Grid -->
          </div>
          <!-- Col -->
        </div>
        <!-- End Grid -->
  
        <!-- Table -->
        <div class="mt-6">
          <div class="border border-gray-200 p-4 rounded-lg space-y-4 dark:border-neutral-700">
            <div class="hidden sm:grid sm:grid-cols-5">
              <div class="sm:col-span-2 text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Produk</div>
              <div class="text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Jumlah</div>
              <div class="text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Harga</div>
              <div class="text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Total</div>
            </div>

            @foreach ($order->detail as $item)
                
                <div class="hidden sm:block border-b border-gray-200 dark:border-neutral-700"></div>
    
                <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                <div class="col-span-full sm:col-span-2">
                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Produk</h5>
                    <p class="font-medium text-gray-800 dark:text-neutral-200">{{$this->get_product_info($item->produk_id)}}</p>
                </div>
                <div>
                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Jumlah</h5>
                    <p class="text-gray-800 dark:text-neutral-200">{{$item->jumlah}}</p>
                </div>
                <div>
                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Harga</h5>
                    <p class="text-gray-800 dark:text-neutral-200">{{Number::currency($item->harga, 'Rp.', 'ID')}}</p>
                </div>
                <div>
                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Total</h5>
                    <p class="sm:text-end text-gray-800 dark:text-neutral-200">{{Number::currency($item->total, 'Rp.', 'ID')}}</p>
                </div>
                </div>
            @endforeach
  
          </div>
        </div>
        <!-- End Table -->
  
        <!-- Flex -->
        <div class="mt-8 flex sm:justify-end">
          <div class="w-full max-w-2xl sm:text-end space-y-2">
            <!-- Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
              <dl class="grid sm:grid-cols-5 gap-x-3">
                <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Subtotal:</dt>
                <dd class="col-span-2 text-gray-500 dark:text-neutral-500">{{Number::currency($order->total_harga_produk, 'Rp.', 'ID')}}</dd>
              </dl>
  
              <dl class="grid sm:grid-cols-5 gap-x-3">
                <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Diskon:</dt>
                <dd class="col-span-2 text-gray-500 dark:text-neutral-500">{{Number::currency($order->total_diskon, 'Rp.', 'ID')}}</dd>
              </dl>
  
              <dl class="grid sm:grid-cols-5 gap-x-3">
                <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Total Bayar:</dt>
                <dd class="col-span-2 text-gray-500 dark:text-neutral-500">{{Number::currency($order->total_bayar, 'Rp.', 'ID')}}</dd>
              </dl>
            </div>
            <!-- End Grid -->
          </div>
        </div>
        <!-- End Flex -->
  
        <div class="mt-8 sm:mt-12">
          <h4 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Terima kasih!</h4>
          <p class="text-gray-500 dark:text-neutral-500">Jika ada pertanyaan mengenai pesanan anda, silahkan hubungi kami pada kontak berikut:</p>
          <div class="mt-2">
            <p class="block text-sm font-medium text-gray-800 dark:text-neutral-200">Darwis, S.Kom</p>
            <p class="block text-sm font-medium text-gray-800 dark:text-neutral-200">+62 853-9909-9029</p>
          </div>
        </div>
  
        <p class="mt-5 text-sm text-gray-500 dark:text-neutral-500">© 2024 E-Commerce SMKN Balanipa.</p>
      </div>
      <!-- End Card -->
  
      <!-- Buttons -->
      <div class="mt-6 flex justify-end gap-x-3 print:hidden">
        {{-- <button wire:click='download_invoice' class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="#">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
          Invoice PDF
        </button> --}}
        {{-- <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" href="#">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
          Print
        </a> --}}
      </div>
      <!-- End Buttons -->
    </div>
  </div>
  <!-- End Invoice -->
</x-filament-panels::page>
