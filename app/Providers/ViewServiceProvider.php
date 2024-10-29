<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\MenuItem;

class ViewServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }

    public function boot()
    {
        // Make $menuItems available to all views
        View::composer('*', function ($view) {
            // Fetch the menu items with their children
            $menuItems = MenuItem::whereNull('parent_id')->with('children')->orderBy('order')->get();
            $view->with('menuItems', $menuItems);
        });
    }
}
