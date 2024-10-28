<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::orderBy('title', 'asc')->get();
        return view('menu.modals.module.index', compact('modules'));
    }

    public function create()
    {
        return view('menu.modals.module.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:modules,slug|max:255',
        ]);

        Module::create($request->all());

        return back()->with('success', 'Module created successfully!');
    }

    public function edit(Module $module)
    {
        return view('menu.modals.module.create', compact('module'));
    }

    public function update(Request $request, Module $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:modules,slug|max:255',
        ]);

        $module->update($request->all());

        return redirect()->route('module.index')->with('success', 'Module updated successfully.');
    }

    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()->route('module.index')->with('success', 'Module deleted successfully.');
    }
}
