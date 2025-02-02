<?php

use App\Filament\CustomerPanel\Resources\CustomerResource;
use App\Http\Controllers\InvoiceController;
use App\Http\Middleware\CustomerMiddleware;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Brands;
use App\Livewire\Categories;
use App\Livewire\KeranjangBelanja;
use App\Livewire\LandingPage;
use App\Livewire\ProductDetail;
use App\Livewire\Products;
use App\Models\Brand;
use App\Models\Kategori;
use Illuminate\Support\Facades\Route;


// test invoice
// Route::get('/invoice/{orderId}', [InvoiceController::class, 'download'])->name('invoice.download');


Route::get('/', LandingPage::class)->name('landing');
Route::get('/login', Login::class)->name('auth.login')->middleware(['guest']);
Route::get('/register', Register::class)->name('auth.register')->middleware(['guest']);


// customer panel
// Route::prefix('customer-panel')->group(function() {
//     Route::get('/', CustomerResource::class);
//     // Route::get('/pesanan', PesananCustomerResource::class);
//     // Route::get('/profile', ProfileCustomerResource::class);
// })->middleware(['auth', CustomerMiddleware::class]);

// products detail
Route::prefix('product')->group(function() {
    Route::get('/', Products::class)->name('product.list');
    Route::get('/detail/{id}', ProductDetail::class)->name('product.detail');
});


// brands
Route::prefix('brand')->group(function() {
    Route::get('/', Brands::class)->name('brand.index');
    Route::get('/{slug}', function($slug){
        // cari brand berdasarkan slug
        $brand = Brand::query()->where('slug', $slug)->first();
        if($brand) {
            // redirect to product with brand filter
            return redirect('/product?selectedBrand[0]=' . $brand->id);
        }
    });
});

// kategori
Route::prefix('kategori')->group(function() {
    Route::get('/', Categories::class)->name('categories.index');;
    Route::get('/{slug}', function($slug) {
        // cari kategori dengan slug
        $kat = Kategori::query()->where('slug', $slug)->first();
        if($kat) {
            return redirect('/product?selectedCategories[0]=' . $kat->id);
        }
    });
});

// cart / keranjang belanja
Route::prefix('keranjang')->group(function() {
    Route::get('/', KeranjangBelanja::class)->name('keranjang.index');
    Route::get('/detail', function() {})->name('keranjang.detail');
});
// require __DIR__.'/auth.php';
