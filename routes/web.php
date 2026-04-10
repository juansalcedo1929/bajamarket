<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\DirectorioController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductorController as AdminProductorController;
use App\Http\Controllers\Admin\ProductoController as AdminProductoController;
use App\Http\Controllers\Admin\CategoriaController as AdminCategoriaController;
use Illuminate\Support\Facades\Route;

// Ruta principal - Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Catálogo de productos
Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo.index');
Route::get('/catalogo/categoria/{categoria:slug}', [CatalogoController::class, 'categoria'])->name('catalogo.categoria');

// Producto individual
Route::get('/producto/{producto:slug}', [ProductoController::class, 'show'])->name('producto.show');

// Directorio de productores
Route::get('/directorio', [DirectorioController::class, 'index'])->name('directorio.index');
Route::get('/directorio/{productor:slug}', [DirectorioController::class, 'show'])->name('directorio.show');

// Registro de productor
Route::get('/registro', [DirectorioController::class, 'create'])->name('registro.create');
Route::post('/registro', [DirectorioController::class, 'store'])->name('registro.store');

// Contacto
Route::post('/contacto', [ContactoController::class, 'send'])->name('contacto.send');

// Ruta para servir imágenes de storage
Route::get('/storage-image/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath)) {
        abort(404);
    }
    return response()->file($fullPath);
})->where('path', '.*')->name('storage.image');

// Ruta dashboard para compatibilidad con Laravel Breeze
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard')->middleware('auth');

// Panel de Administración
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Productores - con parámetro personalizado
    Route::resource('productores', AdminProductorController::class)->parameters([
        'productores' => 'productor'
    ]);
    
    Route::post('productores/{productor}/aprobar', [AdminProductorController::class, 'aprobar'])->name('productores.aprobar');
    Route::post('productores/{productor}/rechazar', [AdminProductorController::class, 'rechazar'])->name('productores.rechazar');
    
    // Productos - con parámetro personalizado
    Route::resource('productos', AdminProductoController::class)->parameters([
        'productos' => 'producto'
    ]);
    
    // Categorías - con parámetro personalizado
    Route::resource('categorias', AdminCategoriaController::class)->parameters([
        'categorias' => 'categoria'
    ]);
});

// Rutas de autenticación
require __DIR__.'/auth.php';