@extends('admin.layouts.app')

@section('title', 'Header Top Bar')
@section('page-title', 'Header Top Bar')
@section('page-description', 'Configure top bar messaging, contact details, and social links displayed in the header.')

@section('content')
<div class="card shadow-sm">
  <div class="card-body p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="h5 mb-1">Header Top Bar</h2>
        <p class="text-muted mb-0">Set announcements, email, phone, hours, and social channels.</p>
      </div>
      <a href="{{ route('admin.header.topbars.edit') }}" class="btn btn-outline-secondary btn-sm">Refresh</a>
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

    <form method="POST" action="{{ route('admin.header.topbars.update') }}">
      @csrf
      @method('PUT')

      <div class="row g-4">
        <div class="col-lg-6">
          <div class="mb-3">
            <label class="form-label" for="left_text">Announcement Text</label>
            <input id="left_text" name="left_text" type="text" class="form-control @error('left_text') is-invalid @enderror" value="{{ old('left_text', $headerTopbar->left_text) }}" maxlength="255">
            @error('left_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $headerTopbar->email) }}" maxlength="150">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label" for="phone">Phone</label>
            <input id="phone" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $headerTopbar->phone) }}" maxlength="50">
            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label" for="opening_hours">Opening Hours</label>
            <input id="opening_hours" name="opening_hours" type="text" class="form-control @error('opening_hours') is-invalid @enderror" value="{{ old('opening_hours', $headerTopbar->opening_hours) }}" maxlength="191">
            @error('opening_hours')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card border-light shadow-sm p-4 mb-4">
            <h3 class="h6 mb-3">Social Media</h3>
            <div class="mb-3">
              <label class="form-label" for="facebook">Facebook URL</label>
              <input id="facebook" name="facebook" type="url" class="form-control @error('facebook') is-invalid @enderror" value="{{ old('facebook', $headerTopbar->facebook) }}" maxlength="255">
              @error('facebook')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="instagram">Instagram URL</label>
              <input id="instagram" name="instagram" type="url" class="form-control @error('instagram') is-invalid @enderror" value="{{ old('instagram', $headerTopbar->instagram) }}" maxlength="255">
              @error('instagram')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="linkedin">LinkedIn URL</label>
              <input id="linkedin" name="linkedin" type="url" class="form-control @error('linkedin') is-invalid @enderror" value="{{ old('linkedin', $headerTopbar->linkedin) }}" maxlength="255">
              @error('linkedin')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="youtube">YouTube URL</label>
              <input id="youtube" name="youtube" type="url" class="form-control @error('youtube') is-invalid @enderror" value="{{ old('youtube', $headerTopbar->youtube) }}" maxlength="255">
              @error('youtube')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="twitter">Twitter URL</label>
              <input id="twitter" name="twitter" type="url" class="form-control @error('twitter') is-invalid @enderror" value="{{ old('twitter', $headerTopbar->twitter) }}" maxlength="255">
              @error('twitter')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="card border-light shadow-sm p-4 mb-4">
            <div class="form-check form-switch">
              <input id="status" name="status" type="checkbox" class="form-check-input" value="1" {{ old('status', $headerTopbar->status) ? 'checked' : '' }}>
              <label class="form-check-label" for="status">Top Bar Published</label>
            </div>
          </div>
        </div>
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Save Top Bar</button>
        <button type="reset" class="btn btn-outline-secondary">Reset</button>
      </div>
    </form>
  </div>
</div>
@endsection
