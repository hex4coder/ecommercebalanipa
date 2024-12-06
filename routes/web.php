<?php

use App\Livewire\Brands;
use App\Livewire\Categories;
use App\Livewire\LandingPage;
use App\Livewire\Products;
use App\Models\Brand;
use App\Models\Kategori;
use Illuminate\Support\Facades\Route;



Route::get('/', LandingPage::class)->name('landing');
Route::get('products', Products::class)->name('products.list');


// brands
Route::prefix('brand')->group(function() {
    Route::get('/', Brands::class)->name('brand.index');
    Route::get('/{slug}', function($slug){
        // cari brand berdasarkan slug
        $brand = Brand::query()->where('slug', $slug)->first();
        if($brand) {
            // redirect to product with brand filter
            return redirect('/products?selectedBrand[0]=' . $brand->id);
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
            return redirect('/products?selectedCategories[0]=' . $kat->id);
        }
    });
});
require __DIR__.'/auth.php';
