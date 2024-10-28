<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('title', 'asc')->get();
        return view('menu.modals.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('menu.modals.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'slug' => 'required|string|max:255|unique:pages',
            'date' => 'required|date',
        ]);

        Page::create($request->all());

        return back()->with('success', 'Page created successfully!');
    }

    public function edit(Page $page)
    {
        return view('menu.modals.pages.create', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'published_at' => 'nullable|date',
        ]);

        $page->update($request->all());

        return redirect()->route('page.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('page.index')->with('success', 'Page deleted successfully.');
    }
}
