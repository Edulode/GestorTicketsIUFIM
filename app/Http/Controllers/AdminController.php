<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Subarea;
use App\Models\Usuario;
use App\Models\Ciclo;
use App\Models\Tipo;
use App\Models\Asunto;
use App\Models\TipoSolicitud;
use App\Models\CategoriaServicio;
use App\Models\Status;
use App\Models\Tecnico;
use App\Models\Ticket;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with links to all CRUD operations
     */
    public function index()
    {
        // Obtener contadores de cada tabla para mostrar estadísticas
        $stats = [
            'areas' => Area::count(),
            'subareas' => Subarea::count(),
            'usuarios' => Usuario::count(),
            'ciclos' => Ciclo::count(),
            'tipos' => Tipo::count(),
            'asuntos' => Asunto::count(),
            'tipo_solicitudes' => TipoSolicitud::count(),
            'categoria_servicios' => CategoriaServicio::count(),
            'statuses' => Status::count(),
            'tecnicos' => Tecnico::count(),
            'tickets' => Ticket::count()
        ];

        return view('admin.index', compact('stats'));
    }

    /**
     * Show system statistics and health
     */
    public function dashboard()
    {
        $recentTickets = Ticket::with(['usuario', 'area', 'status'])
                               ->orderBy('created_at', 'desc')
                               ->limit(5)
                               ->get();

        $ticketsByStatus = [
            'pendientes' => Ticket::whereHas('status', function($q) {
                $q->where('status', 'Pendiente');
            })->count(),
            'resueltos' => Ticket::whereHas('status', function($q) {
                $q->where('status', 'Resuelto');
            })->count()
        ];

        $ticketsByArea = Area::withCount('tickets')->get();

        return view('admin.dashboard', compact('recentTickets', 'ticketsByStatus', 'ticketsByArea'));
    }
}
