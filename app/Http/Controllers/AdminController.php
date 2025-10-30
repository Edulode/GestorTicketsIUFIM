<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Usuario;
use App\Models\Area;
use App\Models\Status;

class AdminController extends Controller
{
    public function index()
    {
        // Estadísticas básicas para el panel de administración
        $totalTickets = Ticket::count();
        $ticketsPendientes = Ticket::whereHas('status', function($query) {
            $query->where('status', 'Pendiente');
        })->count();
        $ticketsResueltos = Ticket::whereHas('status', function($query) {
            $query->where('status', 'Resuelto');
        })->count();
        $totalUsuarios = Usuario::count();
        $totalAreas = Area::count();

        return view('admin.index', compact(
            'totalTickets',
            'ticketsPendientes', 
            'ticketsResueltos',
            'totalUsuarios',
            'totalAreas'
        ));
    }

    public function dashboard()
    {
        return redirect()->route('admin.index');
    }
}
