@extends('admin.layouts.app')

@section('title', 'Media Library')
@section('page-title', 'Media Library')
@section('page-description', 'Browse, upload, organize, and manage media assets.')

@section('content')
<div class="card shadow-sm">
  <div class="card-body p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
      <div>
        <h2 class="h5 mb-1">Media Library</h2>
        <p class="text-muted mb-0">Search files, filter by folder, and preview images or documents.</p>
      </div>
      <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.media.create') }}" class="btn btn-primary btn-sm">
          <i class="fa-solid fa-upload me-1"></i>
          Upload Files
        </a>
        <form method="POST" action="{{ route('admin.media.bulk-delete') }}" class="d-inline-flex align-items-center" onsubmit="return confirm('Delete selected media items?');">
          @csrf
          <div id="bulk-delete-inputs"></div>
          <button type="submit" class="btn btn-outline-danger btn-sm" id="bulk-delete-button" disabled>
            <i class="fa-solid fa-trash me-1"></i>
            Delete Selected
          </button>
        </form>
      </div>
    </div>

    <form method="GET" action="{{ route('admin.media.index') }}" class="row g-3 mb-4">
      <div class="col-md-4">
        <input type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search media by title, filename, or type...">
      </div>
      <div class="col-md-3">
        <select name="folder" class="form-select">
          <option value="">All folders</option>
          @foreach($folders as $folderOption)
            <option value="{{ $folderOption }}" {{ $folder === $folderOption ? 'selected' : '' }}>{{ ucfirst(str_replace('-', ' ', $folderOption)) }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <select name="view" class="form-select">
          <option value="grid" {{ $viewMode === 'grid' ? 'selected' : '' }}>Grid view</option>
          <option value="list" {{ $viewMode === 'list' ? 'selected' : '' }}>List view</option>
        </select>
      </div>
      <div class="col-md-2 d-grid">
        <button type="submit" class="btn btn-outline-secondary">Filter</button>
      </div>
    </form>

    @if($media->count())
      <div class="table-responsive d-none d-md-block">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th scope="col">
                <div class="form-check">
                  <input id="select-all" class="form-check-input" type="checkbox">
                </div>
              </th>
              <th scope="col">Preview</th>
              <th scope="col">Title</th>
              <th scope="col">Folder</th>
              <th scope="col">Type</th>
              <th scope="col">Size</th>
              <th scope="col">Uploaded</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($media as $item)
              <tr>
                <td>
                  <div class="form-check">
                    <input class="form-check-input item-checkbox" type="checkbox" value="{{ $item->id }}">
                  </div>
                </td>
                <td>
                  <div style="max-width: 100px;">
                    <img src="{{ $item->thumbnail_url }}" class="img-fluid rounded" alt="{{ $item->alt_text ?: $item->title }}">
                  </div>
                </td>
                <td>
                  <strong>{{ $item->title ?: $item->original_name }}</strong>
                  <div class="text-muted small">{{ $item->original_name }}</div>
                </td>
                <td>{{ ucfirst(str_replace('-', ' ', $item->folder)) }}</td>
                <td>{{ $item->type }}</td>
                <td>{{ $item->human_size }}</td>
                <td>{{ $item->created_at->diffForHumans() }}</td>
                <td>
                  <div class="d-flex gap-1 flex-wrap">
                    <a href="{{ route('admin.media.show', $item) }}" class="btn btn-sm btn-outline-primary">View</a>
                    <a href="{{ route('admin.media.edit', $item) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                    <a href="{{ route('admin.media.download', $item) }}" class="btn btn-sm btn-outline-success">Download</a>
                    <form method="POST" action="{{ route('admin.media.destroy', $item) }}" onsubmit="return confirm('Delete this media item?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="row row-cols-1 row-cols-md-3 g-3 d-md-none">
        @foreach($media as $item)
          <div class="col">
            <div class="card shadow-sm h-100">
              <img src="{{ $item->thumbnail_url }}" class="card-img-top" alt="{{ $item->alt_text ?: $item->title }}">
              <div class="card-body">
                <h3 class="h6">{{ $item->title ?: $item->original_name }}</h3>
                <p class="small text-muted mb-2">{{ ucfirst(str_replace('-', ' ', $item->folder)) }} · {{ $item->human_size }}</p>
                <div class="d-flex gap-1 flex-wrap">
                  <a href="{{ route('admin.media.show', $item) }}" class="btn btn-sm btn-outline-primary">View</a>
                  <a href="{{ route('admin.media.edit', $item) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="mt-4">
        {{ $media->links() }}
      </div>
    @else
      <div class="alert alert-secondary mb-0">
        No media items found. Upload new files to populate the library.
      </div>
    @endif
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.querySelector('#select-all');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const bulkDeleteButton = document.querySelector('#bulk-delete-button');
    const bulkDeleteItems = document.querySelector('#bulk-delete-items');

    const bulkDeleteInputs = document.querySelector('#bulk-delete-inputs');

    const updateBulkState = () => {
      const selected = Array.from(itemCheckboxes).filter(chk => chk.checked).map(chk => chk.value);
      bulkDeleteInputs.innerHTML = selected.map(id => `<input type="hidden" name="items[]" value="${id}">`).join('');
      bulkDeleteButton.disabled = selected.length === 0;
    };

    if (selectAll) {
      selectAll.addEventListener('change', function () {
        itemCheckboxes.forEach(chk => chk.checked = selectAll.checked);
        updateBulkState();
      });
    }

    itemCheckboxes.forEach(chk => chk.addEventListener('change', updateBulkState));
  });
</script>
@endsection
