@extends('admin.layouts.app')

@section('title', 'Header Settings')
@section('page-title', 'Header Settings')
@section('page-description', 'Manage the website header display, behavior, and CTA configuration.')

@section('content')
<div class="card shadow-sm">
  <div class="card-body p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="h5 mb-1">Header Settings</h2>
        <p class="text-muted mb-0">Configure the header behavior used across the entire site.</p>
      </div>
      <a href="{{ route('admin.header.settings.edit') }}" class="btn btn-outline-secondary btn-sm">Refresh</a>
    </div>

    <ul class="nav nav-tabs mb-4">
      <li class="nav-item">
        <a class="nav-link {{ Route::is('admin.header.settings.*') ? 'active' : '' }}" href="{{ route('admin.header.settings.edit') }}">General</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Route::is('admin.header.topbars.*') ? 'active' : '' }}" href="{{ route('admin.header.topbars.edit') }}">Top Bar</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Route::is('admin.header.logos.*') ? 'active' : '' }}" href="{{ route('admin.header.logos.edit') }}">Logos</a>
      </li>
    </ul>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.header.settings.update') }}">
      @csrf
      @method('PUT')

      <div class="row g-4">
        <div class="col-lg-6">
          <div class="card border-light shadow-sm p-4 mb-4">
            <h3 class="h6 mb-3">General</h3>
            <div class="mb-3">
              <label class="form-label" for="header_style">Header Style</label>
              <select id="header_style" name="header_style" class="form-select @error('header_style') is-invalid @enderror" required>
                <option value="default" {{ old('header_style', $headerSetting->header_style) === 'default' ? 'selected' : '' }}>Default</option>
                <option value="compact" {{ old('header_style', $headerSetting->header_style) === 'compact' ? 'selected' : '' }}>Compact</option>
                <option value="centered" {{ old('header_style', $headerSetting->header_style) === 'centered' ? 'selected' : '' }}>Centered</option>
              </select>
              @error('header_style')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label" for="sticky_header">Sticky Header</label>
                <div class="form-check form-switch">
                  <input id="sticky_header" name="sticky_header" type="checkbox" class="form-check-input" value="1" {{ old('sticky_header', $headerSetting->sticky_header) ? 'checked' : '' }}>
                  <label class="form-check-label" for="sticky_header">Enabled</label>
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="transparent_header">Transparent Header</label>
                <div class="form-check form-switch">
                  <input id="transparent_header" name="transparent_header" type="checkbox" class="form-check-input" value="1" {{ old('transparent_header', $headerSetting->transparent_header) ? 'checked' : '' }}>
                  <label class="form-check-label" for="transparent_header">Enabled</label>
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="navbar_enabled">Enable Navbar</label>
                <div class="form-check form-switch">
                  <input id="navbar_enabled" name="navbar_enabled" type="checkbox" class="form-check-input" value="1" {{ old('navbar_enabled', $headerSetting->navbar_enabled) ? 'checked' : '' }}>
                  <label class="form-check-label" for="navbar_enabled">Enabled</label>
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="mobile_menu_enabled">Enable Mobile Menu</label>
                <div class="form-check form-switch">
                  <input id="mobile_menu_enabled" name="mobile_menu_enabled" type="checkbox" class="form-check-input" value="1" {{ old('mobile_menu_enabled', $headerSetting->mobile_menu_enabled) ? 'checked' : '' }}>
                  <label class="form-check-label" for="mobile_menu_enabled">Enabled</label>
                </div>
              </div>
            </div>
          </div>

          <div class="card border-light shadow-sm p-4 mb-4">
            <h3 class="h6 mb-3">Call To Action</h3>
            <div class="mb-3">
              <label class="form-label" for="cta_button_enabled">Enable CTA Button</label>
              <div class="form-check form-switch">
                <input id="cta_button_enabled" name="cta_button_enabled" type="checkbox" class="form-check-input" value="1" {{ old('cta_button_enabled', $headerSetting->cta_button_enabled) ? 'checked' : '' }}>
                <label class="form-check-label" for="cta_button_enabled">Enabled</label>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label" for="cta_button_text">Button Text</label>
              <input id="cta_button_text" name="cta_button_text" type="text" class="form-control @error('cta_button_text') is-invalid @enderror" value="{{ old('cta_button_text', $headerSetting->cta_button_text) }}" maxlength="191">
              @error('cta_button_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="cta_button_url">Button URL</label>
              <input id="cta_button_url" name="cta_button_url" type="url" class="form-control @error('cta_button_url') is-invalid @enderror" value="{{ old('cta_button_url', $headerSetting->cta_button_url) }}" maxlength="500">
              @error('cta_button_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="cta_button_target">Button Target</label>
              <select id="cta_button_target" name="cta_button_target" class="form-select @error('cta_button_target') is-invalid @enderror">
                <option value="_self" {{ old('cta_button_target', $headerSetting->cta_button_target) === '_self' ? 'selected' : '' }}>Same Window</option>
                <option value="_blank" {{ old('cta_button_target', $headerSetting->cta_button_target) === '_blank' ? 'selected' : '' }}>New Window</option>
              </select>
              @error('cta_button_target')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card border-light shadow-sm p-4 mb-4">
            <h3 class="h6 mb-3">Top Bar</h3>
            <div class="mb-3">
              <label class="form-label" for="topbar_enabled">Enable Top Bar</label>
              <div class="form-check form-switch">
                <input id="topbar_enabled" name="topbar_enabled" type="checkbox" class="form-check-input" value="1" {{ old('topbar_enabled', $headerSetting->topbar_enabled) ? 'checked' : '' }}>
                <label class="form-check-label" for="topbar_enabled">Enabled</label>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label" for="search_enabled">Enable Search</label>
              <div class="form-check form-switch">
                <input id="search_enabled" name="search_enabled" type="checkbox" class="form-check-input" value="1" {{ old('search_enabled', $headerSetting->search_enabled) ? 'checked' : '' }}>
                <label class="form-check-label" for="search_enabled">Enabled</label>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label" for="status">Header Status</label>
              <div class="form-check form-switch">
                <input id="status" name="status" type="checkbox" class="form-check-input" value="1" {{ old('status', $headerSetting->status) ? 'checked' : '' }}>
                <label class="form-check-label" for="status">Published</label>
              </div>
            </div>
          </div>

          <div class="card border-light shadow-sm p-4 mb-4">
            <h3 class="h6 mb-3">Preview</h3>
            <div class="border rounded p-3 bg-white">
              <div class="mb-3">
                <strong>Desktop Preview</strong>
                <div class="border rounded mt-2 p-3 bg-light">
                  <p class="small mb-1 text-muted">Header style: {{ old('header_style', $headerSetting->header_style) }}</p>
                  <p class="small mb-0 text-muted">Sticky: {{ old('sticky_header', $headerSetting->sticky_header) ? 'Yes' : 'No' }}</p>
                  <p class="small mb-0 text-muted">Transparent: {{ old('transparent_header', $headerSetting->transparent_header) ? 'Yes' : 'No' }}</p>
                </div>
              </div>
              <div>
                <strong>Mobile Preview</strong>
                <div class="border rounded mt-2 p-3 bg-light">
                  <p class="small mb-1 text-muted">Mobile menu: {{ old('mobile_menu_enabled', $headerSetting->mobile_menu_enabled) ? 'Enabled' : 'Disabled' }}</p>
                  <p class="small mb-0 text-muted">CTA: {{ old('cta_button_enabled', $headerSetting->cta_button_enabled) ? 'Visible' : 'Hidden' }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Save Header Settings</button>
        <button type="reset" class="btn btn-outline-secondary">Reset</button>
      </div>
    </form>
  </div>
</div>
@endsection
