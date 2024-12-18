<x-filament-panels::page>
    {{-- cart items --}}

    @if (count($cartItems) > 0)
    <a href="{{route('keranjang.index')}}"
        class="inline-block text-sm text-blue-500 underline underline-offset-4 transition hover:text-blue-600">
        <i class='bx bx-left-arrow-alt'></i> Kembali ke Keranjang Belanja
    </a>
        
    @endif

    @if (count($cartItems) == 0)
        <div class="w-full flex flex-col items-center justify-center">

            <div class="flex items-center justify-center bg-white rounded-lg shadow-lg p-11 flex-col lg:w-[30rem]">
                <img class="h-[10rem] mb-5" src="{{asset('img/empty-cart.svg')}}" alt="cart empty">
                <p class="text-xs font-semibold">Empty</p>
                <p class="text-xs mt-1 text-slate-400">Keranjang belanja kosong</p>
                <a href="{{route('product.list')}}" type="button" class="mt-5 py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    <i class='bx bx-shopping-bag' ></i> Belanja dulu
                  </a>
            </div>
        </div>
    @else
    
        <div class="grid grid-cols-1">
            <section>
                <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
                    <div class="mx-auto max-w-3xl">
                        <header class="text-center">
                            <h1 class="text-xl font-bold text-gray-900 sm:text-3xl">Cek Kembali</h1>
                        </header>
    
                        <div class="mt-8">
                            <ul class="space-y-4">
                                @foreach ($data['detail'] as $item)
                                <li class="flex items-center gap-4">
                                    <img src="https://images.unsplash.com/photo-1618354691373-d851c5c3a990?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=830&q=80"
                                        alt="" class="size-16 rounded object-cover" />
    
                                    <div>
                                        <h3 class="text-sm text-gray-900">{{$item['name']}}</h3>
    
                                        <dl class="mt-0.5 space-y-px text-[10px] text-gray-600">
                                            <div>
                                                <dt class="inline">Size:</dt>
                                                <dd class="inline">{{$item['ukuran']}}</dd>
                                            </div>
    
                                            <div>
                                                {{-- <dt class="inline">Harga:</dt> --}}
                                                <dd class="inline">{{Number::currency($item['harga'], 'Rp.', 'IDR')}}</dd>
                                            </div>
    
                                            <div>
                                                <dt class="inline">Total Harga:</dt>
                                                <dd class="inline">{{Number::currency($item['total'], 'Rp.', 'IDR')}}</dd>
                                            </div>
                                        </dl>
                                    </div>
    
                                    <div class="flex flex-1 items-center justify-end gap-2">
                                        <input type="number" min="1" value="{{$item['jumlah']}}" id="Line1Qty" disabled
                                            class="h-8 w-12 rounded border-gray-200 bg-gray-50 p-0 text-center text-xs text-gray-600 [-moz-appearance:_textfield] focus:outline-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none" />
    
                                        {{-- <button class="text-gray-600 transition hover:text-red-600">
                                            <span class="sr-only">Remove item</span>
    
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button> --}}
                                    </div>
                                </li>
                                @endforeach
    
                            </ul>
    
                            <div class="mt-8 flex justify-end border-t border-gray-100 pt-8">
                                <div class="w-screen max-w-lg space-y-4">
                                    <dl class="space-y-0.5 text-sm text-gray-700">
                                        <div class="flex justify-between items-center mb-4">
                                            <p class="text-sm text-slate-500">Kode Promo</p>
                                            <div class='flex flex-col gap-2'>
                                                <div class="relative">
                                                    <label for="Search" class="sr-only"> Kode </label>
    
                                                    <input wire:model='code' type="text" id="Kode"
                                                        placeholder="Masukkan kode disini..."
                                                        class="w-full rounded-md border-gray-200 py-2.5 pe-10 shadow-sm sm:text-sm" />
    
                                                    <span class="absolute inset-y-0 end-0 grid w-10 place-content-center">
                                                        <button wire:click='checkCode' type="button"
                                                            class="text-gray-600 hover:text-gray-700">
                                                            <span class="sr-only">Kode</span>
    
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                                class="size-5 text-blue-600">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                            </svg>
    
    
                                                        </button>
                                                    </span>
                                                </div>
                                                @if(session()->has('code_error'))
                                                <span
                                                    class="w-full text-right text-red-500 text-xs font-semibold">{{session('code_error')}}</span>
                                                @elseif (session()->has('code_success'))
                                                <span
                                                    class="w-full text-right text-green-500 text-xs font-semibold">{{session('code_success')}}</span>
    
                                                @endif
    
                                            </div>
                                        </div>
    
                                        <div class="flex justify-between">
                                            <dt>Total Harga Produk</dt>
                                            <dd>{{Number::currency($data['total_harga_produk'], 'Rp.', 'IDR')}}</dd>
                                        </div>
    
                                        <div class="flex justify-between">
                                            <dt>Biaya Pengiriman</dt>
                                            <dd class="text-xs font-semibold text-blue-500">Sesuai kesepakatan</dd>
                                        </div>
    
                                        <div class="flex justify-between">
                                            <dt>Diskon</dt>
                                            <dd>{{Number::currency($data['total_diskon'], 'Rp.', 'IDR')}}</dd>
                                        </div>
    
                                        <div class="flex justify-between !text-base font-medium">
                                            <dt>Total Bayar</dt>
                                            <dd>{{Number::currency($data['total_bayar'], 'Rp.', 'IDR')}}</dd>
                                        </div>
                                    </dl>
    
                                    @if (session()->has('code_success'))
                                    <div class="flex justify-end">
                                        <span
                                            class="inline-flex items-center justify-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-indigo-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
    
    
                                            <p class="whitespace-nowrap text-xs">Diskon dipakai.</p>
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    
    
    
            <form wire:submit="checkout">
                {{$this->form}}
    
                @if (session()->has('error'))
                <div class="mt-7 bg-red-50 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500"
                    role="alert" tabindex="-1" aria-labelledby="hs-with-list-label">
                    <div class="flex">
                        <div class="shrink-0">
                            <svg class="shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m15 9-6 6"></path>
                                <path d="m9 9 6 6"></path>
                            </svg>
                        </div>
                        <div class="ms-4">
                            <h3 id="hs-with-list-label" class="text-sm font-semibold">
                                Terjadi kesalahan saat pendaftaran.
                            </h3>
                            <div class="mt-2 text-sm text-red-700 dark:text-red-400">
                                <ul class="list-disc space-y-1 ps-5">
                                    <li>
                                        {{session('error')}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
    
                @endif
    
    
                <div class="mt-7">
                    <label for="Option3"
                        class="flex cursor-pointer items-start gap-4 rounded-lg border border-gray-200 p-4 transition hover:bg-gray-50">
                        <div class="flex items-center">
                            &#8203;
                            <input type="checkbox" wire:model='acc' class="size-4 rounded border-gray-300"/>
                        </div>
    
                        <div>
                            <strong class="text-pretty font-medium text-gray-900"> Setujui Pesanan </strong>
    
                            <p class="mt-1 text-pretty text-sm text-gray-700">
                                Saya telah mengecek belanjaan dan mengisi data dengan benar.
                            </p>
                        </div>
                    </label>
                </div>
    
                <button type="submit"
                    class="my-7 w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    Buat Pesanan
                </button>
    
            </form>
    
        </div>
        
    @endif


</x-filament-panels::page>
