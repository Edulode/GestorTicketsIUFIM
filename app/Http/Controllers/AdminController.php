<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Usuario;
use App\Models\Area;
use App\Models\Status;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

    // CRUD de Administradores
    public function adminIndex()
    {
        $administradores = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.administradores.index', compact('administradores'));
    }

    public function adminCreate()
    {
        return view('admin.administradores.create');
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.administradores.index')->with('success', 'Administrador creado exitosamente.');
    }

    public function adminShow(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.administradores.show', compact('user'));
    }

    public function adminEdit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.administradores.edit', compact('user'));
    }

    public function adminUpdate(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.administradores.index')->with('success', 'Administrador actualizado exitosamente.');
    }

    public function adminDestroy(string $id)
    {
        $user = User::findOrFail($id);
        
        // Prevenir eliminación si es el único administrador
        if (User::count() <= 1) {
            return redirect()->route('admin.administradores.index')->with('error', 'No se puede eliminar el único administrador del sistema.');
        }

        $user->delete();
        return redirect()->route('admin.administradores.index')->with('success', 'Administrador eliminado exitosamente.');
    }
}
