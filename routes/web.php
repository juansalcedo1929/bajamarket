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
use Illuminate\Support\Facades\Artisan;

// ============================================
// RUTA TEMPORAL PARA CONFIGURAR STORAGE EN RAILWAY
// ============================================
Route::get('/setup-storage', function () {
    Artisan::call('storage:link');
    Artisan::call('optimize:clear');
    
    return response()->json([
        'success' => true,
        'message' => '✅ Storage link creado y caché limpiada.',
        'storage_path' => public_path('storage'),
        'link' => '<a href="/">Ir al sitio</a>'
    ]);
});

// ============================================
// RUTA DE DIAGNÓSTICO PARA VER ARCHIVOS EN STORAGE
// ============================================
Route::get('/check-storage', function () {
    $productosPath = storage_path('app/public/productos');
    $productoresPath = storage_path('app/public/productores');
    
    return response()->json([
        'storage_app_public_exists' => is_dir(storage_path('app/public')),
        'productos_exists' => is_dir($productosPath),
        'productos_files' => is_dir($productosPath) ? array_values(array_diff(scandir($productosPath), ['.', '..'])) : [],
        'productores_exists' => is_dir($productoresPath),
        'productores_files' => is_dir($productoresPath) ? array_values(array_diff(scandir($productoresPath), ['.', '..'])) : [],
        'public_storage_exists' => is_dir(public_path('storage')),
    ]);
});

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

// Ruta para servir imágenes de storage (SIN middleware)
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

// Rutas de autenticación (Laravel Breeze)
require __DIR__.'/auth.php';