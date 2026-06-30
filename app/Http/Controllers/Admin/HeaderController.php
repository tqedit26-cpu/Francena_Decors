<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HeaderController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('admin.header.settings.edit');
    }

    public function edit(): View
    {
        return redirect()->route('admin.header.settings.edit');
    }
}
