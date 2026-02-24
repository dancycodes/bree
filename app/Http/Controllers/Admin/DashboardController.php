<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(): mixed
    {
        return gale()->view('admin.dashboard', [], web: true);
    }
}
