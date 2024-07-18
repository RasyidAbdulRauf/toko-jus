<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::redirect('/', '/login');
Route::get('/', 'FrontendController@home')->name('home');
Route::get('/shop', 'FrontendController@shop')->name('shop');
Route::get('/detail', 'FrontendController@showDetail')->name('show.detail');
Route::get('/detail/{id}', 'FrontendController@detail')->name('detail');
Route::get('/shop', 'FrontendController@search')->name('search');
Route::get('/cart', 'FrontendController@cart')->name('shopping.cart');


Route::get('/shop/{id}', 'CartController@addtoCart')->name('addto.cart');
Route::patch('/update-cart', 'CartController@updateCart')->name('update.cart');
Route::delete('/delete-cart/{id}', 'CartController@deleteCart')->name('delete.cart');


// Route::get('/home', function () {
//     if (session('status')) {
//         return redirect()->route('admin.home')->with('status', session('status'));
//     }

//     return redirect()->route('admin.home');
// });

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Product
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::post('products/media', 'ProductController@storeMedia')->name('products.storeMedia');
    Route::post('products/ckmedia', 'ProductController@storeCKEditorImages')->name('products.storeCKEditorImages');
    Route::resource('products', 'ProductController');

});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
