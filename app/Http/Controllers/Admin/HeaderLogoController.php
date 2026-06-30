<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeaderLogoRequest;
use App\Models\HeaderLogo;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HeaderLogoController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('admin.header.logos.edit');
    }

    public function edit(): View
    {
        $headerLogo = HeaderLogo::firstOrCreate([]);
        $mediaOptions = Media::orderBy('created_at', 'desc')->get();

        return view('admin.header-logos.edit', compact('headerLogo', 'mediaOptions'));
    }

    public function update(HeaderLogoRequest $request): RedirectResponse
    {
        $headerLogo = HeaderLogo::firstOrCreate([]);
        $data = $request->validated();

        $headerLogo->update($data);

        return redirect()->route('admin.header.logos.edit')->with('success', 'Header logos updated successfully.');
    }
}
