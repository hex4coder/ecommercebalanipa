<div
  class="relative w-screen max-w-sm border bg-white rounded-lg shadow-lg px-4 py-8 sm:px-6 lg:px-8"
  aria-modal="true"
  role="dialog"
  tabindex="-1"
>
  <div class="mt-4 space-y-6">
    <ul class="space-y-4">

        @foreach ($cartItems as $item)
        <li class="flex items-center gap-4">
          <img
            src="{{$this->GetImageUrl($item['id'])}}"
            alt="product image"
            class="size-16 rounded object-cover"
          />

          <div>
            <h3 class="text-sm text-slate-900">{{$item['name']}}</h3>

            <dl class="mt-0.5 space-y-px text-[10px] text-slate-600">
              <div>
                <dt class="inline">Harga:</dt>
                <dd class="inline">{{Number::currency($item['price'], 'Rp.', 'IDR')}}</dd>
              </div>

              <div>
                <dt class="inline">Jumlah:</dt>
                <dd class="inline">{{$item['quantity']}}</dd>
              </div>
            </dl>
          </div>
        </li>

        @endforeach

      {{-- <li class="flex items-center gap-4">
        <img
          src="https://images.unsplash.com/photo-1618354691373-d851c5c3a990?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=830&q=80"
          alt=""
          class="size-16 rounded object-cover"
        />

        <div>
          <h3 class="text-sm text-slate-900">Basic Tee 6-Pack</h3>

          <dl class="mt-0.5 space-y-px text-[10px] text-slate-600">
            <div>
              <dt class="inline">Size:</dt>
              <dd class="inline">XXS</dd>
            </div>

            <div>
              <dt class="inline">Color:</dt>
              <dd class="inline">White</dd>
            </div>
          </dl>
        </div>
      </li>

      <li class="flex items-center gap-4">
        <img
          src="https://images.unsplash.com/photo-1618354691373-d851c5c3a990?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=830&q=80"
          alt=""
          class="size-16 rounded object-cover"
        />

        <div>
          <h3 class="text-sm text-slate-900">Basic Tee 6-Pack</h3>

          <dl class="mt-0.5 space-y-px text-[10px] text-slate-600">
            <div>
              <dt class="inline">Size:</dt>
              <dd class="inline">XXS</dd>
            </div>

            <div>
              <dt class="inline">Color:</dt>
              <dd class="inline">White</dd>
            </div>
          </dl>
        </div>
      </li> --}}
    </ul>

    <div class="my-5 font-semibold text-slate-700 text-sm w-full text-right">Total : {{Number::currency($this->GetTotal(), 'Rp. ', 'IDR')}}</div>

    <div class="space-y-4 text-center">
      <a
        href="{{route('filament.customer.resources.pesanan-saya.index')}}"
        class="block rounded border border-blue-600 px-5 py-3 text-sm text-blue-600 transition hover:ring-1 hover:ring-blue-400"
      >
        Lihat Pesanan Saya
      </a>

      <a
        href="{{route('filament.customer.pages.checkout')}}"
        class="block rounded bg-blue-700 px-5 py-3 text-sm text-blue-100 transition hover:bg-blue-600"
      >
        Checkout
      </a>

      <a
        wire:navigate
        href="{{route('product.list')}}"
        class="inline-block text-sm text-blue-500 underline underline-offset-4 transition hover:text-blue-600"
      >
        Lanjut belanja
      </a>
    </div>
  </div>
</div>
