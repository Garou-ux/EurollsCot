<?php

use App\Models\User;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CotizacionesController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\OpcionController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    $userId = auth()->id();
    $user = User::find($userId);
    // dd($user, 'aaa');
    return view('dashboard')->with('user', $user);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    $userId = auth()->id();
    $user = User::find($userId);
    // dd($user, 'mmm');
    return view('dashboard')->with('user', $user);
})->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->middleware(['auth', 'verified'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->middleware(['auth', 'verified'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->middleware(['auth', 'verified'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/catalogos', [CatalogosController::class, 'list'])->middleware(['auth', 'verified'])->name('catalogos.list');
});


Route::get('/catalogos',[CatalogosController::class, 'list'])->middleware(['auth', 'verified'])->name('catalogos.list');
Route::get('/users', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->middleware(['auth', 'verified'])->name('users.create');
Route::post('/users/storeds', [UserController::class, 'storeds'])->middleware(['auth', 'verified'])->name('users.storeds');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->middleware(['auth', 'verified'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->middleware(['auth', 'verified'])->name('users.update');


Route::get('storage/{filename}', function ($filename) {
    $path = storage_path('app/public/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->where('filename', '.*');

#productos
Route::get('products', [ProductsController::class, 'index'])->middleware(['auth', 'verified'])->name('products.index');
Route::post('products', [ProductsController::class, 'store'])->middleware(['auth', 'verified'])->name('products.store');
Route::post('products/destroy', [ProductsController::class, 'destroy'])->middleware(['auth', 'verified'])->name('products.destroy');
Route::get('products/getproductsforcotizacion', [ProductsController::class, 'getproductsforcotizacion'])->middleware(['auth', 'verified'])->name('products.cotizacion');

#cotizaciones
Route::get('/cotizaciones',[CotizacionesController::class, 'index'])->middleware(['auth', 'verified'])->name('cotizaciones.list');
Route::get('/cotizaciones/create', [CotizacionesController::class, 'create'])->middleware(['auth', 'verified'])->name('cotizaciones.create');
Route::post('/cotizaciones/store', [CotizacionesController::class, 'store'])->middleware(['auth', 'verified'])->name('cotizaciones.store');
Route::post('/cotizaciones/destroy', [CotizacionesController::class, 'destroy'])->middleware(['auth', 'verified'])->name('cotizaciones.destroy');
// Route::post('/cotizaciones/edit', [CotizacionesController::class, 'edit'])->middleware(['auth', 'verified'])->name('cotizaciones.edit');
Route::get('/cotizaciones/{cotizacion_id}/edit', [CotizacionesController::class, 'indexEdit'])->middleware(['auth', 'verified'])->name('cotizaciones.edit');
Route::post('/cotizaciones/getCotizacionDetails', [CotizacionesController::class, 'getCotizacionDetails'])->middleware(['auth', 'verified'])->name('cotizaciones.details');
Route::post('/cotizaciones/update', [CotizacionesController::class, 'update'])->middleware(['auth', 'verified'])->name('cotizaciones.update');
Route::post('cotizaciones/pdf', [CotizacionesController::class, 'getCotizacionPDF'])->middleware(['auth', 'verified'])->name('cotizaciones.pdf');
Route::post('cotizaciones/options', [CotizacionesController::class, 'cotizacionesOptions'])->middleware(['auth', 'verified'])->name('cotizaciones.options');
Route::post('cotizaciones/emails', [CotizacionesController::class, 'cotizacionesEmail'])->middleware(['auth', 'verified'])->name('cotizaciones.email');
Route::post('cotizaciones/enviarPDFPorCorreo', [CotizacionesController::class,'enviarPDFPorCorreo'])->name('cotizaciones.sendEmail');

#clientes
Route::get('clientes', [ClientesController::class, 'index'])->middleware(['auth', 'verified'])->name('clientes.index');
Route::post('clientes', [ClientesController::class, 'store'])->middleware(['auth', 'verified'])->name('clientes.store');
Route::post('clientes/destroy', [ClientesController::class, 'destroy'])->middleware(['auth', 'verified'])->name('clientes.destroy');
Route::get('clientes/getclientesforcotizacion', [ClientesController::class, 'getclientesforcotizacion'])->middleware(['auth', 'verified'])->name('clientes.cotizacion');
Route::post('clientes/saveClienteEmail', [ClientesController::class, 'saveClienteEmail'])->middleware(['auth', 'verified'])->name('clientes.saveClienteEmail');


Route::post('/guardar-opcion', [OpcionController::class, 'guardarOpcion']);


require __DIR__.'/auth.php';
