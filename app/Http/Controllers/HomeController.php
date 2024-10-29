<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch top-level menu items with nested children
        $menuItems = MenuItem::whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();

        return view('home', compact('menuItems'));
    }
}
