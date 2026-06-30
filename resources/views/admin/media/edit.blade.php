@extends('admin.layouts.app')

@section('title', 'Edit Media')
@section('page-title', 'Edit Media')
@section('page-description', 'Update metadata, folder assignment, and publication state for your media asset.')

@section('content')
<div class="card shadow-sm">
  <div class="card-body p-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
      <div>
        <h2 class="h5 mb-1">Edit Media</h2>
        <p class="text-muted mb-0">Review file details and adjust metadata as needed.</p>
      </div>
      <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary btn-sm">Back to Media</a>
    </div>

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

    <form method="POST" action="{{ route('admin.media.update', $media) }}">
      @csrf
      @method('PUT')

      <div class="row g-4">
        <div class="col-lg-4">
          <div class="border rounded p-3 text-center">
            <img src="{{ $media->thumbnail_url }}" class="img-fluid mb-3" alt="{{ $media->alt_text ?: $media->title }}">
            <div class="text-muted small mb-2">{{ $media->original_name }}</div>
            <div class="small text-muted">{{ ucfirst($media->type) }} · {{ $media->human_size }}</div>
            <a href="{{ route('admin.media.download', $media) }}" class="btn btn-sm btn-outline-success mt-3">Download File</a>
          </div>
        </div>

        <div class="col-lg-8">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="title">Title</label>
              <input id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $media->title) }}" maxlength="191">
              @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label" for="folder">Folder</label>
              <select id="folder" name="folder" class="form-select @error('folder') is-invalid @enderror" required>
                @foreach($folders as $folderOption)
                  <option value="{{ $folderOption }}" {{ old('folder', $media->folder) === $folderOption ? 'selected' : '' }}>{{ ucfirst(str_replace('-', ' ', $folderOption)) }}</option>
                @endforeach
              </select>
              @error('folder')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label" for="alt_text">Alt Text</label>
              <input id="alt_text" name="alt_text" type="text" class="form-control @error('alt_text') is-invalid @enderror" value="{{ old('alt_text', $media->alt_text) }}" maxlength="191">
              @error('alt_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label" for="caption">Caption</label>
              <input id="caption" name="caption" type="text" class="form-control @error('caption') is-invalid @enderror" value="{{ old('caption', $media->caption) }}" maxlength="191">
              @error('caption')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
              <label class="form-label" for="description">Description</label>
              <textarea id="description" name="description" rows="4" class="form-control @error('description') is-invalid @enderror" maxlength="1000">{{ old('description', $media->description) }}</textarea>
              @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label" for="status">Status</label>
              <select id="status" name="status" class="form-select">
                <option value="1" {{ old('status', $media->status) ? 'selected' : '' }}>Published</option>
                <option value="0" {{ ! old('status', $media->status) ? 'selected' : '' }}>Draft</option>
              </select>
            </div>
          </div>

          <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary">Cancel</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
