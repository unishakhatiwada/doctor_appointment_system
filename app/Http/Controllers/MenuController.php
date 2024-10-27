<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Models\MenuItem;
use App\Models\Module;
use App\Models\Page;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::whereNull('parent_id')
            ->with(['children', 'typeItem']) // Eager load children and typeItem relationships
            ->orderBy('order')
            ->get();

        return view('menu.index', compact('menuItems'));
    }

    public function create()
    {
        $menuItems = MenuItem::all();
        $modules = Module::all();
        $pages = Page::all();

        return view('menu.form', compact('menuItems', 'modules', 'pages'));
    }

    public function store(MenuRequest $request)
    {
        MenuItem::create($request->validated());

        return redirect()->route('menus.index')->with('success', 'Menu item created successfully.');
    }


    public function edit(MenuItem $menuItem)
    {
        $menuItems = MenuItem::all();
        $modules = Module::all();
        $pages = Page::all();

        return view('admin.menu.form', compact('menuItem', 'menuItems', 'modules', 'pages'));
    }

    public function update(MenuRequest $request, MenuItem $menuItem)
    {
        $menuItem->update($request->validated());

        return redirect()->route('admin.menu.index')->with('success', 'Menu item updated successfully.');
    }

}
