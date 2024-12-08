<?php

use App\Helpers\CartHelper;
use App\Livewire\Brands;
use App\Livewire\Categories;
use App\Livewire\LandingPage;
use App\Livewire\Products;
use App\Models\Brand;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Support\Facades\Route;



Route::get('/', LandingPage::class)->name('landing');

Route::prefix('product')->group(function() {
    Route::get('/', Products::class)->name('product.list');
    Route::get('/detail/{id}', function($id) {
        // id product
        $product = Produk::find($id);
        if($product) {
            dd($product);
        }
    })->name('product.detail');
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
    Route::get('/', function() {
        CartHelper::clearCart();
        return redirect()->back();
    })->name('keranjang.index');
    Route::get('/detail', function() {})->name('keranjang.detail');
});
require __DIR__.'/auth.php';
