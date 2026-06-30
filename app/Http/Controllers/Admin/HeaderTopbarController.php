<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeaderTopbarRequest;
use App\Models\HeaderTopbar;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HeaderTopbarController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('admin.header.topbars.edit');
    }

    public function edit(): View
    {
        $headerTopbar = HeaderTopbar::firstOrCreate([]);

        return view('admin.header-topbars.edit', compact('headerTopbar'));
    }

    public function update(HeaderTopbarRequest $request): RedirectResponse
    {
        $headerTopbar = HeaderTopbar::firstOrCreate([]);
        $data = $request->validated();

        $data['status'] = $request->boolean('status');

        $headerTopbar->update($data);

        return redirect()->route('admin.header.topbars.edit')->with('success', 'Header top bar settings updated successfully.');
    }
}
