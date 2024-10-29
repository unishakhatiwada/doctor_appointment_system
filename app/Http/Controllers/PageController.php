<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index():View
    {
        $pages = Page::orderBy('title', 'asc')->get();
        return view('menu.pages.index', compact('pages'));
    }

    public function create():View
    {
        return view('menu.pages.create');
    }

    public function store(Request $request): RedirectResponse
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

    public function edit(Page $page): View
    {
        return view('menu.pages.create', compact('page'));
    }
    public function show($id): View
    {
        // Find the page by ID or return a 404 if not found
        $page = Page::findOrFail($id);

        // Pass the page data to a Blade view
        return view('menu.pages.show', compact('page'));
    }
    public function update(Request $request, Page $page):RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'published_at' => 'nullable|date',
        ]);

        $page->update($request->all());

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page):RedirectResponse
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }
}
