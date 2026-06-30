<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MediaStoreRequest;
use App\Http\Requests\MediaUpdateRequest;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaController extends Controller
{
    protected MediaService $service;

    public function __construct(MediaService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): View
    {
        $query = Media::query();
        $search = $request->query('search');
        $folder = $request->query('folder');
        $viewMode = $request->query('view', 'grid');

        if ($search) {
            $query->where(function ($sub) use ($search) {
                $sub->where('title', 'like', "%{$search}%")
                    ->orWhere('original_name', 'like', "%{$search}%")
                    ->orWhere('mime_type', 'like', "%{$search}%");
            });
        }

        if ($folder) {
            $query->where('folder', $folder);
        }

        $media = $query->orderBy('created_at', 'desc')->paginate(16)->withQueryString();
        $folders = $this->defaultFolders();

        return view('admin.media.index', compact('media', 'folders', 'viewMode', 'search', 'folder'));
    }

    public function create(): View
    {
        return view('admin.media.create', ['folders' => $this->defaultFolders()]);
    }

    public function store(MediaStoreRequest $request): RedirectResponse
    {
        $user = auth()->user();

        foreach ($request->file('files') as $file) {
            $this->service->storeFile($file, $request->input('folder'), $user->id);
        }

        return redirect()->route('admin.media.index')->with('success', 'Files uploaded successfully.');
    }

    public function show(Media $media): View
    {
        return view('admin.media.show', compact('media'));
    }

    public function edit(Media $media): View
    {
        return view('admin.media.edit', ['media' => $media, 'folders' => $this->defaultFolders()]);
    }

    public function update(MediaUpdateRequest $request, Media $media): RedirectResponse
    {
        $media->update(array_merge($request->validated(), [
            'status' => $request->boolean('status'),
        ]));

        if ($media->folder !== $request->input('folder')) {
            $this->service->moveToFolder($media, $request->input('folder'));
        }

        return redirect()->route('admin.media.edit', $media)->with('success', 'Media details updated successfully.');
    }

    public function destroy(Media $media): RedirectResponse
    {
        $this->service->delete($media);

        return redirect()->route('admin.media.index')->with('success', 'Media deleted successfully.');
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $items = collect($request->input('items', []))->filter()->map(fn ($item) => (int) $item)->toArray();

        if (empty($items)) {
            return redirect()->route('admin.media.index')->with('warning', 'No media items selected for deletion.');
        }

        Media::whereIn('id', $items)->get()->each(function (Media $media) {
            $this->service->delete($media);
        });

        return redirect()->route('admin.media.index')->with('success', 'Selected media items were deleted.');
    }

    public function download(Media $media)
    {
        return Storage::disk($media->disk)->download($media->file_path, $media->original_name);
    }

    protected function defaultFolders(): array
    {
        return [
            'hero',
            'services',
            'projects',
            'gallery',
            'team',
            'clients',
            'blogs',
            'logos',
            'icons',
            'documents',
            'custom',
        ];
    }
}
