<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('artisan', function () {
    Artisan::call('clear-compiled');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
});

Auth::routes();

Route::view('/', 'auth.login');

Route::middleware(['auth'])->group(function () {
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('home', 'HomeController@index')->name('home');
    Route::post('import-product', 'Catalog\ProductController@import')->name('import-product');
    Route::post('import-temporal', 'Catalog\TempProductController@import')->name('import-temporal');

    Route::group(['as' => 'configurations.', 'prefix' => 'configurations', 'namespace' => 'Configuration'], function(){
        Route::resource('store-shop', 'StoreShopController');
        Route::resource('type-change', 'TypeChangeController');
        Route::resource('section-web', 'SectionWebController');
        Route::resource('segment', 'SegmentController');
        Route::resource('tag', 'TagController');
        Route::resource('user', 'UserController');
    });

    Route::group(['as' => 'catalogs.', 'prefix' => 'catalogs', 'namespace' => 'Catalog'], function(){
        Route::resource('category', 'CategoryController');
        Route::resource('subcategory', 'SubcategoryController');
        Route::resource('mark', 'MarkController');
        Route::resource('unit', 'UnitController');
        Route::resource('currency', 'CurrencyController');
        Route::resource('feature-value', 'FeatureValueController');
        Route::resource('feature', 'FeatureController');
        Route::resource('value', 'ValueController');
        Route::resource('product', 'ProductController');
        Route::resource('arts', 'ArtController');
        Route::resource('arts-type', 'ArtTypeController');
        Route::resource('section', 'SectionController');
        Route::resource('wholesaler', 'WholesalerController');

        Route::resource('temp', 'TempProductController');
    });
    
    Route::group(['as' => 'lists.', 'prefix' => 'lists'], function() {
        Route::get('list-section-web', 'Configuration\SectionWebController@list')->name('list-section-web');
        Route::get('list-segment', 'Configuration\SegmentController@list')->name('list-segment');
        Route::get('list-tag', 'Configuration\TagController@list')->name('list-tag');
        Route::get('list-store-shop', 'Configuration\StoreShopController@list')->name('list-store-shop');
        Route::get('list-type-change', 'Configuration\TypeChangeController@list')->name('list-type-change');
        Route::get('list-user', 'Configuration\UserController@list')->name('list-user');

        Route::get('list-category', 'Catalog\CategoryController@list')->name('list-category');
        Route::get('list-subcategory', 'Catalog\SubcategoryController@list')->name('list-subcategory');
        Route::get('list-mark', 'Catalog\MarkController@list')->name('list-mark');
        Route::get('list-unit', 'Catalog\UnitController@list')->name('list-unit');
        Route::get('list-currency', 'Catalog\CurrencyController@list')->name('list-currency');
        Route::get('list-feature', 'Catalog\FeatureController@list')->name('list-feature');
        Route::get('list-value', 'Catalog\ValueController@list')->name('list-value');
        Route::get('list-feature-value', 'Catalog\FeatureValueController@list')->name('list-feature-value');
        Route::get('list-wholesaler', 'Catalog\WholesalerController@list')->name('list-wholesaler');
        
        // Route::get('list-product', 'Catalog\ProductController@list')->name('list-product');
        Route::get('list-product-store', 'Catalog\ProductController@list_store')->name('list-product-store');
        Route::get('list-product-arts', 'Catalog\ArtController@list')->name('list-product-arts');
        Route::get('list-arts-type', 'Catalog\ArtTypeController@list')->name('list-arts-type');
        Route::get('list-section', 'Catalog\SectionController@list')->name('list-section');
        
        // temporal
        Route::get('list-temporal', 'Catalog\TempProductController@list')->name('list-temporal');
    });

    Route::group(['as' => 'channels.', 'prefix' => 'channels'], function() {
        Route::get('store_okc', 'Catalog\ProductController@viewStoreOkc')->name('store_okc');
        Route::get('list_okc', 'Catalog\ProductController@viewListOkc')->name('list_okc');
        Route::get('list-product-okc', 'Catalog\ProductController@list_store_okc')->name('list-product-okc');
        Route::post('stock-store', 'Catalog\ProductController@stockStore')->name('stock-store');

        Route::get('export-excel', 'Catalog\ProductController@export')->name('export-excel');
        Route::get('section-product', 'Configuration\SectionWebController@viewSectionOkc')->name('section-product');
        Route::post('load-section-product', 'Configuration\SectionWebController@loadSection')->name('load-section-product');
        Route::post('add-section-product', 'Configuration\SectionWebController@addSection')->name('add-section-product');
        
    });

    Route::group(['as' => 'ajax.', 'prefix' => 'ajax'], function() {
        Route::post('load-price-product', 'Catalog\ProductController@loadPriceProduct')->name('load-price-product');
        Route::post('load-element', 'Catalog\ProductController@loadElements')->name('load-element');
        Route::post('load-value', 'Catalog\ProductController@loadValue')->name('load-value');
        Route::post('load-images-banner', 'Catalog\ArtController@saveImageBanner')->name('load-images-banner');
        Route::post('load-images-product', 'Catalog\ArtController@saveImageProduct')->name('load-images-product');
        Route::post('load-arts', 'Catalog\ArtController@show')->name('load-arts');
        Route::post('delete-arts', 'Catalog\ArtController@delete')->name('delete-arts');
        Route::post('delete-specification', 'Catalog\ProductController@deleteSpecification')->name('delete-specification');
        Route::post('generate-sku', 'Catalog\ProductController@generateCode')->name('generate-sku');
        Route::post('update-product-value', 'Catalog\ProductController@updateValues')->name('update-product-value');
        Route::post('update-product-price', 'Catalog\ProductController@updatePrices')->name('update-product-price');

        Route::post('load-product-variant', 'Catalog\ProductController@loadVariant')->name('load-product-variant');
        Route::post('load-product-combo', 'Catalog\ProductController@loadCombo')->name('load-product-combo');
        Route::post('load-product-stock', 'Catalog\ProductController@loadStockWeb')->name('load-product-stock');
        Route::post('segment-store', 'Catalog\ProductController@segmentStore')->name('segment-store');
        Route::post('tag-store', 'Catalog\ProductController@tagStore')->name('tag-store');
        Route::post('section-store', 'Catalog\ProductController@sectionStore')->name('section-store');
        Route::post('combo-store', 'Catalog\ProductController@comboStore')->name('combo-store');

        Route::post('data-intcomex-list', 'Intcomex\IntcomexController@dataList')->name('data-intcomex-list');
        Route::post('filter-products', 'Catalog\ProductController@createFilter')->name('filter-products');

        Route::post('change-password', 'Configuration\UserController@changePassword')->name('change-password');
        Route::post('new-password', 'Configuration\UserController@newPassword')->name('new-password');
    });

    Route::group(['as' => 'intcomex.', 'prefix' => 'intcomex', 'namespace' => 'Intcomex'], function() {
        Route::get('lista', 'IntcomexController@lista')->name('lista');
        Route::get('pending', 'IntcomexController@pending')->name('pending');
        Route::post('data-lista', 'IntcomexController@dataLista')->name('data-lista');
        Route::post('data-lista-pending', 'IntcomexController@dataListaPending')->name('data-lista-pending');
        Route::post('actualizar-lista', 'IntcomexController@getCatalog')->name('actualizar-lista');
        Route::post('actualizar-precio', 'IntcomexController@getPrice')->name('actualizar-precio');
        Route::post('actualizar-stock', 'IntcomexController@getStock')->name('actualizar-stock');

        Route::post('translate-catalog', 'IntcomexController@getNewCatalog')->name('translate-catalog');
        Route::post('consult-part_number', 'IntcomexController@getPartNumber')->name('consult-part_number');
        Route::post('load-date-download', 'IntcomexController@getDatesDownload')->name('load-date-download');
    });
    
    Route::group(['as' => 'test.', 'prefix' => 'test'], function() {
        Route::get('/test/{type}', 'Intcomex\IntcomexController@testDownload')->name('test');
        Route::get('/pruebas', 'Catalog\ProductController@loadDataEspec'); //pruebas
        Route::get('/pruebas-images', 'Catalog\ProductController@existProduct'); //pruebas
        Route::get('/pruebas-rename', 'Catalog\ProductController@renameFilesProd'); //pruebas
    });
});
