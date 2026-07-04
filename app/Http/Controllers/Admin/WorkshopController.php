<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    public function index(Request $request)
    {
        $query = Workshop::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('address', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $workshops = $query->latest()->paginate(8)->withQueryString();

        $totalWorkshops = Workshop::count();
        $activeWorkshops = Workshop::where('status', 'activo')->count();
        $inactiveWorkshops = Workshop::where('status', 'inactivo')->count();

        return view('admin.workshops.index', compact(
            'workshops',
            'totalWorkshops',
            'activeWorkshops',
            'inactiveWorkshops'
        ));
    }

    public function create()
    {
        return view('admin.workshops.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'opening_hours' => 'nullable|string|max:255',
            'status' => 'required|in:activo,inactivo',
        ]);

        Workshop::create($request->only([
            'name',
            'address',
            'phone',
            'opening_hours',
            'status',
        ]));

        return redirect()
            ->route('admin.workshops.index')
            ->with('success', 'La sede o taller fue registrado correctamente.');
    }

    public function show(Workshop $workshop)
    {
        return view('admin.workshops.show', compact('workshop'));
    }

    public function edit(Workshop $workshop)
    {
        return view('admin.workshops.edit', compact('workshop'));
    }

    public function update(Request $request, Workshop $workshop)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'opening_hours' => 'nullable|string|max:255',
            'status' => 'required|in:activo,inactivo',
        ]);

        $workshop->update($request->only([
            'name',
            'address',
            'phone',
            'opening_hours',
            'status',
        ]));

        return redirect()
            ->route('admin.workshops.index')
            ->with('success', 'La sede o taller fue actualizado correctamente.');
    }
}