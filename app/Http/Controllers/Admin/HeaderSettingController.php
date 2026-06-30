<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeaderSettingRequest;
use App\Models\HeaderLogo;
use App\Models\HeaderSetting;
use App\Models\HeaderTopbar;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HeaderSettingController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('admin.header.settings.edit');
    }

    public function edit(): View
    {
        $headerSetting = HeaderSetting::getCached();
        $headerTopbar = HeaderTopbar::firstOrCreate([]);
        $headerLogo = HeaderLogo::with(['desktopLogo', 'mobileLogo', 'stickyLogo', 'darkLogo', 'lightLogo', 'faviconLogo'])->firstOrCreate([]);
        $mediaOptions = Media::orderBy('created_at', 'desc')->get();

        return view('admin.header-settings.edit', compact('headerSetting', 'headerTopbar', 'headerLogo', 'mediaOptions'));
    }

    public function update(HeaderSettingRequest $request): RedirectResponse
    {
        $headerSetting = HeaderSetting::getCached();
        $data = $request->validated();

        $data['sticky_header'] = $request->boolean('sticky_header');
        $data['transparent_header'] = $request->boolean('transparent_header');
        $data['topbar_enabled'] = $request->boolean('topbar_enabled');
        $data['navbar_enabled'] = $request->boolean('navbar_enabled');
        $data['search_enabled'] = $request->boolean('search_enabled');
        $data['cta_button_enabled'] = $request->boolean('cta_button_enabled');
        $data['mobile_menu_enabled'] = $request->boolean('mobile_menu_enabled');
        $data['status'] = $request->boolean('status');

        $headerSetting->update($data);
        HeaderSetting::clearCache();

        return redirect()->route('admin.header.settings.edit')->with('success', 'Header settings updated successfully.');
    }
}
