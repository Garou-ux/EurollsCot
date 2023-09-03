<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CotizacionesController;

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
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
Route::post('/users', [UserController::class, 'store'])->middleware(['auth', 'verified'])->name('users.store');
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

#cotizaciones
Route::get('/cotizaciones',[CotizacionesController::class, 'index'])->middleware(['auth', 'verified'])->name('cotizaciones.list');

require __DIR__.'/auth.php';
