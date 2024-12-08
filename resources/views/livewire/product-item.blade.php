<li>
    <a href="{{route('product.detail', ['id' => $product->id])}}" class="group block overflow-hidden">
        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt=""
            class="h-[300px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[350px]" />

        <div class="relative bg-white pt-3">
            <h3 class="text-xs text-gray-700 group-hover:underline group-hover:underline-offset-4">
                {{$product->nama}}
            </h3>

            <p class="mt-2">
                <span class="sr-only"> Harga </span>

                <span class="tracking-wider text-gray-900"> {{Number::currency($product->harga, 'Rp. ', 'ID')}} </span>
            </p>
        </div>
    </a>

    <!--
  Heads up! 👋

  This component comes with some `rtl` classes. Please remove them if they are not needed in your project.
-->

    <!-- Base -->

    <button wire:click='AddToCart'
        class="mt-5 inline-flex items-center gap-2 rounded border border-blue-600 bg-blue-600 px-8 py-3 text-white hover:bg-transparent hover:text-blue-600 focus:outline-none focus:ring active:text-blue-500 transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
        </svg>

        <span wire:loading.remove class="text-sm font-medium"> Masukkan Keranjang </span>
        <span wire:loading class="text-sm font-medium italic"> Memasukkan... </span>


    </button>
</li>
