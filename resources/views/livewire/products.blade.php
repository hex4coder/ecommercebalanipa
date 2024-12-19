<!--
  Heads up! 👋

  This component comes with some `rtl` classes. Please remove them if they are not needed in your project.

  Plugins:
    - @tailwindcss/forms
-->

<section>
    <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <header>
            <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">Daftar Produk</h2>

            <p class="mt-4 max-w-md text-gray-500">
                Dengan membeli produk kami, Anda tidak hanya mendapatkan barang yang unik, tetapi juga mendukung ekonomi
                lokal dan pelestarian lingkungan. Mari bersama-sama wujudkan Indonesia yang lebih mandiri dan berdaya
                saing!
            </p>
        </header>

        <div class="mt-8 block lg:hidden">
            <button
                class="flex cursor-pointer items-center gap-2 border-b border-gray-400 pb-1 text-gray-900 transition hover:border-gray-600">
                <span class="text-sm font-medium"> Filters & Sorting </span>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4 rtl:rotate-180">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>

        <div class="mt-4 lg:mt-8 lg:grid lg:grid-cols-4 lg:items-start lg:gap-8">
           
            <div class="lg:col-span-3">
                <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">



                    @forelse ($products as $product)
                        @livewire('product-item', [
                            'product' => $product
                        ])
                    @empty
                        <div class="w-full lg:col-span-3 sm:col-span-2 min-h-[10rem] flex justify-center items-center gap-6 flex-col">
                            <img class="w-[10rem]" src="{{asset('img/empty-product.svg')}}" alt="empty product image" />
                            <h3 class="text-sm text-slate-700">Belum ada produk.</h3>
                        </div>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</section>
