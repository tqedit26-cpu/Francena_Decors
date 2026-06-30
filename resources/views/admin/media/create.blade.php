@extends('admin.layouts.app')

@section('title', 'Upload Media')
@section('page-title', 'Upload Media')
@section('page-description', 'Upload images, documents, and other assets to the media library.')

@section('content')
<div class="card shadow-sm">
  <div class="card-body p-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
      <div>
        <h2 class="h5 mb-1">Upload New Media</h2>
        <p class="text-muted mb-0">Choose files and assign them to a folder for easy organization.</p>
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

    <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="mb-4">
        <label class="form-label" for="folder">Folder</label>
        <select id="folder" name="folder" class="form-select @error('folder') is-invalid @enderror" required>
          <option value="">Select a folder</option>
          @foreach($folders as $folderOption)
            <option value="{{ $folderOption }}" {{ old('folder') === $folderOption ? 'selected' : '' }}>{{ ucfirst(str_replace('-', ' ', $folderOption)) }}</option>
          @endforeach
        </select>
        @error('folder')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="mb-4">
        <label class="form-label" for="files">Files</label>
        <input id="files" name="files[]" type="file" class="form-control @error('files') is-invalid @enderror @error('files.*') is-invalid @enderror" multiple required>
        <small class="form-text text-muted">Supported types: PNG, JPG, JPEG, WEBP, SVG, PDF, DOCX, XLSX, ZIP. Max 10 MB per file.</small>
        @error('files')<div class="invalid-feedback">{{ $message }}</div>@enderror
        @error('files.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <button type="submit" class="btn btn-primary">Upload</button>
      <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
  </div>
</div>
@endsection
