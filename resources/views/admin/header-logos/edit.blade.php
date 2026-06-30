@extends('admin.layouts.app')

@section('title', 'Header Logos')
@section('page-title', 'Header Logos')
@section('page-description', 'Configure logo variants for desktop, mobile, sticky, dark, light, and favicon.')

@section('content')
<div class="card shadow-sm">
  <div class="card-body p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="h5 mb-1">Header Logos</h2>
        <p class="text-muted mb-0">Select the media assets used for header branding across device and theme modes.</p>
      </div>
      <a href="{{ route('admin.header.logos.edit') }}" class="btn btn-outline-secondary btn-sm">Refresh</a>
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

    <form method="POST" action="{{ route('admin.header.logos.update') }}">
      @csrf
      @method('PUT')

      <div class="row g-4">
        <div class="col-lg-6">
          <div class="mb-4">
            <label class="form-label" for="desktop_logo">Desktop Logo</label>
            <select id="desktop_logo" name="desktop_logo" class="form-select @error('desktop_logo') is-invalid @enderror">
              <option value="">Select desktop logo</option>
              @foreach($mediaOptions as $media)
                <option value="{{ $media->id }}" {{ old('desktop_logo', $headerLogo->desktop_logo) == $media->id ? 'selected' : '' }}>{{ $media->title ?: $media->original_name }}</option>
              @endforeach
            </select>
            @error('desktop_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-4">
            <label class="form-label" for="mobile_logo">Mobile Logo</label>
            <select id="mobile_logo" name="mobile_logo" class="form-select @error('mobile_logo') is-invalid @enderror">
              <option value="">Select mobile logo</option>
              @foreach($mediaOptions as $media)
                <option value="{{ $media->id }}" {{ old('mobile_logo', $headerLogo->mobile_logo) == $media->id ? 'selected' : '' }}>{{ $media->title ?: $media->original_name }}</option>
              @endforeach
            </select>
            @error('mobile_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-4">
            <label class="form-label" for="sticky_logo">Sticky Logo</label>
            <select id="sticky_logo" name="sticky_logo" class="form-select @error('sticky_logo') is-invalid @enderror">
              <option value="">Select sticky logo</option>
              @foreach($mediaOptions as $media)
                <option value="{{ $media->id }}" {{ old('sticky_logo', $headerLogo->sticky_logo) == $media->id ? 'selected' : '' }}>{{ $media->title ?: $media->original_name }}</option>
              @endforeach
            </select>
            @error('sticky_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="col-lg-6">
          <div class="mb-4">
            <label class="form-label" for="dark_logo">Dark Logo</label>
            <select id="dark_logo" name="dark_logo" class="form-select @error('dark_logo') is-invalid @enderror">
              <option value="">Select dark logo</option>
              @foreach($mediaOptions as $media)
                <option value="{{ $media->id }}" {{ old('dark_logo', $headerLogo->dark_logo) == $media->id ? 'selected' : '' }}>{{ $media->title ?: $media->original_name }}</option>
              @endforeach
            </select>
            @error('dark_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-4">
            <label class="form-label" for="light_logo">Light Logo</label>
            <select id="light_logo" name="light_logo" class="form-select @error('light_logo') is-invalid @enderror">
              <option value="">Select light logo</option>
              @foreach($mediaOptions as $media)
                <option value="{{ $media->id }}" {{ old('light_logo', $headerLogo->light_logo) == $media->id ? 'selected' : '' }}>{{ $media->title ?: $media->original_name }}</option>
              @endforeach
            </select>
            @error('light_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-4">
            <label class="form-label" for="favicon">Favicon</label>
            <select id="favicon" name="favicon" class="form-select @error('favicon') is-invalid @enderror">
              <option value="">Select favicon</option>
              @foreach($mediaOptions as $media)
                <option value="{{ $media->id }}" {{ old('favicon', $headerLogo->favicon) == $media->id ? 'selected' : '' }}>{{ $media->title ?: $media->original_name }}</option>
              @endforeach
            </select>
            @error('favicon')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-check form-switch">
            <input id="status" name="status" type="checkbox" class="form-check-input" value="1" {{ old('status', $headerLogo->status) ? 'checked' : '' }}>
            <label class="form-check-label" for="status">Logo configuration published</label>
          </div>
        </div>
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Save Logos</button>
        <button type="reset" class="btn btn-outline-secondary">Reset</button>
      </div>
    </form>
  </div>
</div>
@endsection
