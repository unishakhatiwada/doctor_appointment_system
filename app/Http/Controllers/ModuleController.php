<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::orderBy('title', 'asc')->get();
        return view('menu.module.index', compact('modules'));
    }

    public function create():View
    {
        return view('menu.module.create');
    }

    public function store(Request $request):RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:modules,slug|max:255',
        ]);

        Module::create($request->all());

        return back()->with('success', 'Module created successfully!');
    }

    public function edit(Module $module): View
    {
        return view('menu.module.create', compact('module'));
    }

    public function update(Request $request, Module $module):RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:modules,slug|max:255',
        ]);

        $module->update($request->all());

        return redirect()->route('admin.modules.index')->with('success', 'Module updated successfully.');
    }

    public function destroy(Module $module):RedirectResponse
    {
        $module->delete();

        return redirect()->route('admin.modules.index')->with('success', 'Module deleted successfully.');
    }
}
