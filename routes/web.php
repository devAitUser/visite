<?php

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('pdfview',[App\Http\Controllers\DevisController::class, 'pdf']);






/*** Model clients  * */

Route::resource('clients', App\Http\Controllers\ClientsController::class);
Route::get('/getclient',[App\Http\Controllers\ClientsController::class, 'get_client']);
Route::get('/clients/{id}/edit',[App\Http\Controllers\ClientsController::class, 'edit']);
Route::post('/clients/store',[App\Http\Controllers\ClientsController::class, 'store']);

Route::delete('/deleteclients/{id}',[App\Http\Controllers\ClientsController::class, 'destroy']);
Route::post('/updateclients/{id}',[App\Http\Controllers\ClientsController::class, 'update']);

Route::get('/client/{id}/edit',[App\Http\Controllers\ClientsController::class, 'edit']);

Route::get('/getclients',[App\Http\Controllers\ClientsController::class, 'get_clients']);






/*** Model Devis  * */

Route::resource('devis', App\Http\Controllers\DevisController::class);
Route::get('/getdevis',[App\Http\Controllers\DevisController::class, 'get_client']);

Route::post('/devis/store',[App\Http\Controllers\DevisController::class, 'store']);

Route::delete('/deletedevis/{id}',[App\Http\Controllers\DevisController::class, 'destroy']);
Route::post('/updatedevis',[App\Http\Controllers\DevisController::class, 'update']);

Route::get('/getdevis',[App\Http\Controllers\DevisController::class, 'getdevis']);

Route::get('/devis_pdf/{id}',[App\Http\Controllers\DevisController::class, 'pdf']);



 




Route::prefix('product')->group(function () {
  

    /*** Model product  * */

Route::resource('/', App\Http\Controllers\ProductController::class);
Route::get('/getproduct',[App\Http\Controllers\ProductController::class, 'get_product']);
Route::get('/{id}/edit',[App\Http\Controllers\ProductController::class, 'edit']);
Route::post('/store',[App\Http\Controllers\ProductController::class, 'store']);
Route::post('/store_img',[App\Http\Controllers\ProductController::class, 'stote_img']);
Route::delete('/remove_img/{id}',[App\Http\Controllers\ProductController::class, 'dropzoneRemove']);
Route::delete('/deleteproduct/{id}',[App\Http\Controllers\ProductController::class, 'destroy']);
Route::post('/updateproduct',[App\Http\Controllers\ProductController::class, 'update']);

Route::get('/getproduct',[App\Http\Controllers\ProductController::class, 'get_product']);

Route::post('/getproduct_data',[App\Http\Controllers\ProductController::class, 'get_data_product']);

Route::get('/type_product/{id}',[App\Http\Controllers\ProductController::class, 'type_product']);

Route::get('/search_product',[App\Http\Controllers\ProductController::class, 'search_product']);



   




/*** Model gategorie   * */

Route::resource('gategorie', App\Http\Controllers\GategorieController::class);

Route::post('/postgategorie',[App\Http\Controllers\GategorieController::class, 'store']);

Route::get('/getgategorie',[App\Http\Controllers\GategorieController::class, 'get_gategorie']);

Route::put('/updategategorie',[App\Http\Controllers\GategorieController::class, 'update']);

Route::delete('/deletegategorie/{id}',[App\Http\Controllers\GategorieController::class, 'destroy']);








});








/*** Model order   * */

Route::resource('order', App\Http\Controllers\OrderController::class);
Route::post('/getphone',[App\Http\Controllers\OrderController::class, 'get_phone_client']);
Route::get('/getorder',[App\Http\Controllers\OrderController::class, 'getorder']);
Route::get('/create_order_s',[App\Http\Controllers\OrderController::class, 'create_superviseur']);
Route::post('/validation_commande',[App\Http\Controllers\OrderController::class, 'validation_commande']);
Route::post('update_order', [App\Http\Controllers\OrderController::class, 'update']);
Route::post('/livre/{id}', [App\Http\Controllers\OrderController::class, 'livre']);
Route::delete('/deleteproduct/{id}',[App\Http\Controllers\OrderController::class, 'destroy']);


/*** Model utilisateurs permission  * */

Route::post('/permission_assigner', [App\Http\Controllers\PermissionsController::class, 'assignPermissions']);

Route::get('permission', [App\Http\Controllers\UserController::class, 'permissions'])->name('permission');

Route::get('users', [App\Http\Controllers\UserController::class, 'users'])->name('users');

Route::get('get_users', [App\Http\Controllers\UserController::class, 'get_users']);



Route::post('user_post', [App\Http\Controllers\UserController::class, 'create_user']);

Route::delete('/delete_user/{id}', [App\Http\Controllers\UserController::class, 'destroy']);

Route::get('/user/{id}/edit', [App\Http\Controllers\UserController::class, 'edit']);

Route::get('/user/{id}/edit_owner', [App\Http\Controllers\UserController::class, 'edit_owner'])->name('edit_owner');

Route::post('/update_user',[App\Http\Controllers\UserController::class, 'update']);


Route::get('permission_order', [App\Http\Controllers\UserController::class, 'permission_order'])->name('permission_order');


Route::get('permission', [App\Http\Controllers\UserController::class, 'permissions'])->name('permission');

/*** Model Role  * */

Route::resource('roles', App\Http\Controllers\RoleController::class);

Route::post('/postrole',[App\Http\Controllers\RoleController::class, 'store']);

Route::get('/getroles',[App\Http\Controllers\RoleController::class, 'get_roles']);

Route::put('/updaterole',[App\Http\Controllers\RoleController::class, 'update']);

Route::delete('/deleterole/{id}',[App\Http\Controllers\RoleController::class, 'destroy']);



/***  Model visites  * */
Route::get('visites', [App\Http\Controllers\VisitesController::class , 'index']);

Route::post('visites/action', [App\Http\Controllers\VisitesController::class, 'action']);

Route::get('visites/clients', [App\Http\Controllers\VisitesController::class, 'get_clients']);
















Auth::routes();
