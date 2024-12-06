<div class="container mx-7 py-12">
    <h2 class="text-3xl font-bold text-center mb-8">Produk Terbaru</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

        @forelse ($products as $product)

        {{-- card --}}
        <a wire:navigate href="{{route('product.detail', [
            'id' => $product->id,
        ])}}" class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all cursor-pointer">
            <img src="{{asset('storage/' . $product->thumbnail)}}" alt="{{$product->nama}}" class="rounded-t-lg w-full h-[400px]">
            <div class="p-6">
                <h5 class="text-gray-900 text-xl font-medium mb-2">{{$product->nama}} <span class="inline text-right w-full mb-8 text-xs text-blue-600 font-bold p-1 rounded-full">{{$product->kategori->nama_kategori}}</span></h5>

                <p class="text-gray-700">{{$product->short_desc()}}</p>
                <p class="text-gray-900 font-bold">Rp. {{$product->harga}}</p>
                <button class="mt-5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Tambah ke Keranjang
                </button>
            </div>
        </a>
        {{-- end card --}}
        @empty
            <h3 class="text-center text-xl font-bold text-slate-700">Tidak ada data produk</h3>
        @endforelse

        </div>
</div>
