<div class="grid grid-cols-1 gap-8 p-14 w-full bg-blue-50">
    <h1 class="text-2xl font-semibold text-slate-700">Belanjaan Anda!</h1>
    <div class="grid grid-cols-1 gap-4 md:gap-8 md:grid-cols-3">
        {{-- cart items --}}
        <div class="bg-white p-4 md:p-14 rounded-md shadow-md md:col-span-2 relative">
            @if ($totalBiaya > 0)
                <button wire:click='ClearCart'
                    class="bg-red-600 hover:bg-red-600 text-white px-2 py-1 rounded-md shadow-sm absolute top-4 right-4"><i
                        class='bx bxs-trash'></i>
                    Kosongkan!</button>
            @endif
            <table class="w-full border-spacing-2 table-auto">
                @if ($totalBiaya > 0)
                    <thead class="text-left">
                        <tr class="text-xs text-slate-600 hidden sm:table-row border-b border-b-slate-400">
                            <td>Produk</td>
                            <td>Harga</td>
                            <td>Jumlah</td>
                            <td>Total Harga</td>
                        </tr>
                    </thead>
                @endif
                <tbody>
                    @if ($items)
                        @foreach ($items as $item)
                            <tr
                                class="text-sm flex flex-col mt-7 sm:table-row border-b border-b-slate-400 sm:border-b-0">
                                <td data="produk :"
                                    class="before:sm:content-none before:content-[attr(data)] before:text-xs before:text-slate-400  before:capitalize before:block mb-1 text-xs font-semibold before:mr-2">
                                    {{ $item['name'] }}</td>
                                <td data="harga :"
                                    class=" before:sm:content-none  before:content-[attr(data)] before:text-xs before:text-slate-400  before:capitalize before:block mb-1 text-xs font-semibold before:mr-2">
                                    {{ Number::currency($item['price'], 'Rp. ', 'IDR') }}</td>
                                <td data="jumlah :"
                                    class="sm:items-center before:sm:content-none  before:content-[attr(data)] before:text-xs before:text-slate-400  before:capitalize before:block mb-3 text-xs font-semibold before:mr-2">
                                    <div class="flex items-center gap-4">
                                        <button wire:click='AddQty({{ $item['id'] }})'
                                            class="w-7 h-7 flex items-center justify-center hover:bg-blue-500 hover:shadow-lg transition-all p-1 rounded-full bg-blue-300 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </button>


                                        <span>{{ $item['quantity'] }}</span>


                                        <button wire:click='DecQty({{ $item['id'] }})'
                                            class="w-7 h-7 flex items-center justify-center hover:bg-amber-500 hover:shadow-lg transition-all p-1 rounded-full bg-amber-300 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                            </svg>
                                        </button>

                                    </div>
                                </td>
                                <td data="total harga :"
                                    class=" before:sm:content-none  before:content-[attr(data)] before:text-xs before:text-slate-400  before:capitalize before:block mb-1 text-xs font-semibold before:mr-2">
                                    {{ Number::currency($item['price'] * $item['quantity'], 'Rp. ', 'IDR') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <td colspan="4">
                            <div class="flex flex-col justify-center items-center gap-1 p-14">
                                <img class="w-60" src="{{ asset('img/empty-cart.svg') }}" alt="empty cart" />
                                <p class="mt-5 font-semibold text-slate-700">Keranjang kosong</p>
                                <p class="mb-7 text-xs text-slate-400">Belum ada item dikeranjang silahkan tambahkan
                                    produk
                                    kesini dengan membeli produk kami.</p>

                                <a wire:navigate href="{{ route('product.list') }}"
                                    class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                    Mulai Belanja!
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    @endif
                </tbody>
            </table>
            @if ($totalBiaya > 0)
                <p class="block mt-5 text-sm text-slate-600"> Total Biaya : <span
                        class="text-left font-semibold text-slate-700">
                        {{ Number::currency($totalBiaya, 'Rp. ', 'ID') }} </span></p>
            @endif
        </div>

        {{-- payment card --}}
        @if ($totalBiaya > 0)
            <div>
                <div class="bg-white p-4 rounded-md shadow-sm">
                    <h2>payments</h2>
                </div>
            </div>
        @endif
    </div>
    <style scoped>
        table tbody tr td {
            @apply block;
        }
    </style>
</div>
