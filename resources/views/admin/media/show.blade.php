@extends('admin.layouts.app')

@section('title', 'View Media')
@section('page-title', 'View Media')
@section('page-description', 'Preview the media asset details and download or manage the file.')

@section('content')
<div class="card shadow-sm">
  <div class="card-body p-4">
    <div class="mb-4 d-flex justify-content-between align-items-start gap-3 flex-column flex-md-row">
      <div>
        <h2 class="h5 mb-1">Media Detail</h2>
        <p class="text-muted mb-0">Preview the uploaded asset and review its metadata.</p>
      </div>
      <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.media.edit', $media) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
        <a href="{{ route('admin.media.download', $media) }}" class="btn btn-outline-success btn-sm">Download</a>
        <a href="{{ route('admin.media.index') }}" class="btn btn-outline-dark btn-sm">Back to Library</a>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-lg-5">
        <div class="border rounded overflow-hidden">
          <img src="{{ $media->thumbnail_url }}" class="img-fluid w-100" alt="{{ $media->alt_text ?: $media->title }}">
        </div>
      </div>
      <div class="col-lg-7">
        <div class="row g-3">
          <div class="col-12">
            <h3 class="h6">{{ $media->title ?: $media->original_name }}</h3>
            <p class="text-muted mb-1">{{ ucfirst($media->type) }} · {{ $media->human_size }}</p>
            <p class="text-muted small mb-0">Uploaded by {{ $media->uploadedBy?->name ?? 'Unknown' }} · {{ $media->created_at->format('M d, Y H:i') }}</p>
          </div>
          <div class="col-md-6">
            <strong>Folder</strong>
            <p class="mb-0">{{ ucfirst(str_replace('-', ' ', $media->folder)) }}</p>
          </div>
          <div class="col-md-6">
            <strong>Status</strong>
            <p class="mb-0">{{ $media->status ? 'Published' : 'Draft' }}</p>
          </div>
          <div class="col-md-6">
            <strong>Original Name</strong>
            <p class="mb-0">{{ $media->original_name }}</p>
          </div>
          <div class="col-md-6">
            <strong>Filename</strong>
            <p class="mb-0">{{ $media->file_name }}</p>
          </div>
          <div class="col-12">
            <strong>Description</strong>
            <p class="mb-0">{{ $media->description ?: 'No additional description provided.' }}</p>
          </div>
          <div class="col-12">
            <strong>File URL</strong>
            <p class="mb-0"><a href="{{ $media->url }}" target="_blank" rel="noopener noreferrer">Open asset</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
