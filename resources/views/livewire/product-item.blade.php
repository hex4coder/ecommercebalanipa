<a wire:navigate href="{{route('product.detail', [
            'id' => $product->id,
        ])}}" class="group relative block overflow-hidden rounded-lg transition-shadow hover:shadow-lg">


    @livewire('components.love-color-toggle-button', [
        'is_popular' => $product->is_popular
    ])


    <img src="{{asset('storage/' . $product->thumbnail)}}" alt=""
        class="h-64 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72" />

    <div class="relative border border-slate-100 bg-white p-6">
        <span class="whitespace-nowrap rounded-full bg-yellow-400 px-3 py-1.5 text-xs font-medium">
            {{$product->kategori->nama_kategori}} </span>


        <div class="flex justify-between flex-wrap mt-4">
            <h3 class="text-lg font-medium text-slate-900">{{$product->nama}}</h3>
            <p class="text-xs text-black">Diproduksi oleh <span class="font-semibold">{{$product->brand->name}}</span></p>
        </div>

        <p class="mt-1.5 text-sm text-slate-700">Rp. {{$product->harga}}</p>

        <form class="mt-4">
            <button
                class="block w-full rounded bg-blue-400 text-white p-4 text-sm font-medium transition hover:scale-105">
                Add to Cart
            </button>
        </form>
    </div>
</a>
