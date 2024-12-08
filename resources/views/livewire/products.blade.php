<div class="container mx-7 py-12">
    <h2 class="text-3xl font-bold text-center mb-8">Produk Terbaru</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

        @forelse ($products as $product)
            @livewire('product-item', ['product' => $product])
        @empty
            <h3 class="text-center text-xl font-bold text-slate-700">Tidak ada data produk</h3>
        @endforelse

        </div>
</div>
