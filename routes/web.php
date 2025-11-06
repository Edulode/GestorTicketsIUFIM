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
use App\Http\Controllers\SubareasController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\TipoSolicitudController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\AdminController;
use App\Models\Usuario;
use App\Models\Ticket;
use App\Models\Area;
use App\Models\CategoriaServicio;
use App\Models\Subarea;
use App\Models\Tecnico;

Route::get('/dashboard', function () {
    return redirect()->route('tickets.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

Route::middleware(['auth'])->get('/mis-tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::middleware(['auth'])->get('/api/tickets', [TicketController::class, 'apiIndex'])->name('api.tickets');
Route::middleware(['auth'])->get('/api/tipos-solicitud/{categoria_id}', [TicketController::class, 'getTiposSolicitudPorCategoria'])->name('api.tipos-solicitud');
Route::middleware(['auth'])->get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
Route::middleware(['auth'])->patch('/tickets/{ticket}/resolved', [TicketController::class, 'markAsResolved'])->name('tickets.markAsResolved');
Route::middleware(['auth'])->delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
Route::middleware(['auth'])->patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas de administración
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // CRUD de Administradores
    Route::get('/admin/administradores', [AdminController::class, 'adminIndex'])->name('admin.administradores.index');
    Route::get('/admin/administradores/create', [AdminController::class, 'adminCreate'])->name('admin.administradores.create');
    Route::post('/admin/administradores', [AdminController::class, 'adminStore'])->name('admin.administradores.store');
    Route::get('/admin/administradores/{id}', [AdminController::class, 'adminShow'])->name('admin.administradores.show');
    Route::get('/admin/administradores/{id}/edit', [AdminController::class, 'adminEdit'])->name('admin.administradores.edit');
    Route::put('/admin/administradores/{id}', [AdminController::class, 'adminUpdate'])->name('admin.administradores.update');
    Route::delete('/admin/administradores/{id}', [AdminController::class, 'adminDestroy'])->name('admin.administradores.destroy');
    
    Route::resource('usuarios', UsuariosController::class);
    Route::resource('areas', AreasController::class);
    Route::resource('categorias-servicio', CategoriaServicioController::class);
    
    // Rutas especiales para ciclos (solo index y show, ya que son automáticos)
    Route::get('ciclos', [CicloController::class, 'index'])->name('ciclos.index');
    Route::get('ciclos/{codigo}', [CicloController::class, 'show'])->name('ciclos.show');
    
    // APIs para ciclos
    Route::get('/api/ciclo-actual', [CicloController::class, 'getCicloActual'])->name('api.ciclo-actual');
    Route::get('/api/todos-ciclos', [CicloController::class, 'getTodosCiclos'])->name('api.todos-ciclos');
    
    Route::resource('subareas', SubareasController::class);
    Route::resource('tecnicos', TecnicoController::class);
    Route::resource('tipos_solicitud', TipoSolicitudController::class);
    
    // Rutas de reportes
    Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/datos', [ReportesController::class, 'obtenerDatos'])->name('reportes.datos');
    Route::get('/reportes/exportar', [ReportesController::class, 'exportar'])->name('reportes.exportar');
    
    // Rutas adicionales para tickets
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::patch('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::get('/tickets/{ticket}/completar', [TicketController::class, 'completar'])->name('tickets.completado');
    Route::patch('/tickets/{ticket}/completar', [TicketController::class, 'completarTicket'])->name('tickets.completar');
});

require __DIR__.'/auth.php';
