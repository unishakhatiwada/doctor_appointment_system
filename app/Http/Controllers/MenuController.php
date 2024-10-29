<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Models\MenuItem;
use App\Models\Module;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index()
    {
        // Fetch top-level menu items with all descendant children
        $menuItems = MenuItem::whereNull('parent_id')
            ->with('children')
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

    public function edit($id): View
    {

        $menuItem = MenuItem::findOrFail($id);
        $menuItems = MenuItem::all();
        $modules = Module::all();
        $pages = Page::all();

        return view('menu.form', compact('menuItem', 'menuItems', 'modules', 'pages'));
    }

    public function update(MenuRequest $request, $id): RedirectResponse
    {
        $menuItem = MenuItem::findOrFail($id);

        $menuItem->fill($request->validated())->save();

        return redirect()->route('menus.index')->with('success', 'Menu item updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->delete();

        return redirect()->route('menus.index')->with('success', 'Menu item deleted successfully.');
    }
}
