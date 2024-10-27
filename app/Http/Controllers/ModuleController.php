<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function show($slug)
    {
        $module = Module::where('slug', $slug)->firstOrFail();
        return view('modules.show', compact('module'));
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
}
