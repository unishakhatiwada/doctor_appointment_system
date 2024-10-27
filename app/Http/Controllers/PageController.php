<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('pages.show', compact('page'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:pages,slug|max:255',
            'content' => 'required',
            'date' => 'required|date',
        ]);

        Page::create($request->all());
        return back()->with('success', 'Page created successfully!');
    }
}
