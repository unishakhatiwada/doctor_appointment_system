<?php

namespace App\Providers;

use App\Helpers\MenuHelper;
use Illuminate\Support\Facades\Cache;
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
        View::share('menuHierarchy', MenuHelper::getMenuHierarchy());
    }

}
