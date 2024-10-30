<?php

namespace App\Providers;

use App\Helpers\MenuHelper;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot()
    {
        View::share('menuHierarchy', MenuHelper::getMenuHierarchy());
    }
}
