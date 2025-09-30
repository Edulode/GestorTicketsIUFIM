<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\CategoriaServicioController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\SubareaController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\TipoSolicitudController;
use App\Models\Usuario;
use App\Models\Ticket;
use App\Models\Area;
use App\Models\CategoriaServicio;
use App\Models\Ciclo;
use App\Models\Subarea;
use App\Models\Tecnico;
use Aps\Models\TipoSolicitud;

Route::get('/dashboard', function () {
    return redirect()->route('tickets.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Ruta pública para crear tickets
Route::get('/', [TicketController::class, 'create'])->name('tickets.create');
Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create.form');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

// API para obtener datos de usuario
Route::get('/api/usuario/{id}', function($id) {
    $usuario = \App\Models\Usuario::with('area')->find($id);
    return response()->json($usuario);
})->name('api.usuario');

// API para obtener tickets con filtros (AJAX)
Route::get('/api/tickets', [TicketController::class, 'getTicketsAjax'])->name('api.tickets');

// Rutas protegidas para gestión de tickets
Route::middleware(['auth'])->group(function() {
    Route::get('/mis-tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::patch('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::get('/tickets/{ticket}/completar', [TicketController::class, 'showComplete'])->name('tickets.showComplete');
    Route::patch('/tickets/{ticket}/completar', [TicketController::class, 'complete'])->name('tickets.complete');
    Route::patch('/tickets/{ticket}/resolved', [TicketController::class, 'markAsResolved'])->name('tickets.markAsResolved');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas de administración
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Rutas de recursos para cada tabla
    Route::resource('usuarios', UsuariosController::class);
    Route::resource('areas', AreasController::class);
    Route::resource('categorias-servicio', CategoriaServicioController::class);
    Route::resource('ciclos', CicloController::class);
    Route::resource('subareas', SubareaController::class);
    Route::resource('tecnicos', TecnicoController::class);
    Route::resource('tipos_solicitud', TipoSolicitudController::class);
    
    // Necesitamos crear estos controladores/rutas para las tablas faltantes
    Route::get('/asuntos', function() { return redirect()->route('admin.index')->with('info', 'Módulo de Asuntos en desarrollo'); })->name('asuntos.index');
    Route::get('/asuntos/create', function() { return redirect()->route('admin.index')->with('info', 'Módulo de Asuntos en desarrollo'); })->name('asuntos.create');
    Route::get('/statuses', function() { return redirect()->route('admin.index')->with('info', 'Módulo de Estados en desarrollo'); })->name('statuses.index');
    Route::get('/statuses/create', function() { return redirect()->route('admin.index')->with('info', 'Módulo de Estados en desarrollo'); })->name('statuses.create');
});

require __DIR__.'/auth.php';
