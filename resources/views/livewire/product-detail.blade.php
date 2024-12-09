<div class="flex flex-col gap-2">
    <h1 class="mt-10 text-center text-2xl text-slate-600">Detail Produk</h1>
    <div class="mt-2">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full h-full p-5 sm:p-10">
            {{-- caresoul --}}
            <div class="grid grid-cols-1">
                <img src="{{asset('storage/' . $currentImage)}}" alt="thumbnail product"
                    class="object-contain w-full h-[350px] rounded-lg md:h-[450px] transition-all hover:shadow-none hover:scale-105 hover:translate-y-4 hover:object-cover">

                {{-- tampilan daftar gambar product --}}


            </div>
            {{-- end caresoul --}}
            <div class="mt-7 sm:mt-0 flex flex-col gap-4">
                <h1 class="text-2xl font-bold">{{$product->nama}}</h1>
                <p class="text-xs text-slate-400">by : <span
                        class="text-slate-700 font-semibold">{{$product->brand->name}}</span></p>
                <p class="font-bold text-slate-700">
                    {{Number::currency($product->harga, 'Rp. ', 'ID')}}
                </p>
                <p class="text-sm text-slate-500">{{$product->deskripsi}}</p>
                <div class="flex flex-wrap gap-1 flex-column sm:flex-row">
                    <p class="text-sm font-semibold">Ukuran : </p>
                    <p class="text-sm text-slate-600">{{$product->ukuran()}}</p>
                </div>

                @if (count($product->foto_produk) > 0)
                <div class="flex flex-wrap gap-1 flex-column sm:flex-row">
                    <p class="text-sm font-semibold">Foto Produk : </p>
                    <p class="text-sm text-slate-600">{{count($product->foto_produk)}} foto.</p>
                </div>
                <div class="flex gap-2 w-full mt-4 items-center justify-center">
                    @foreach ($product->foto_produk as $item)
                        <button wire:target="ChangeCurrentImage({{$item->id}})" wire:click="ChangeCurrentImage({{$item->id}})" >
                            <img src="{{asset('storage/' . $item->foto)}}" alt="foto produk" class="object-cover w-[80px] h-[80px] rounded-full transition-all hover:scale-150 cursor-pointer hover:translate-x-3 hover:shadow-xl" />

                        </button>
                    @endforeach
                </div>
                @endif

                <button wire:click='AddToCart'
                    class="mt-5 inline-flex justify-center items-center gap-2 rounded border border-blue-600 bg-blue-600 px-8 py-3 text-white hover:bg-transparent hover:text-blue-600 focus:outline-none focus:ring active:text-blue-500 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>

                    <span wire:target="AddToCart" wire:loading.remove class="text-sm font-medium"> Masukkan Keranjang </span>
                    <span wire:target="AddToCart" wire:loading class="text-sm font-medium italic"> Memasukkan... </span>


                </button>
            </div>
        </div>
    </div>
</div>
