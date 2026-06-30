<?php

use App\Models\Media;
use Illuminate\Support\Facades\Storage;

if (! function_exists('media_url')) {
    /**
     * Return the public URL for a media item or file path.
     */
    function media_url(Media|string|null $media): ?string
    {
        if (! $media) {
            return null;
        }

        if ($media instanceof Media) {
            return Storage::disk($media->disk)->url($media->file_path);
        }

        return Storage::disk('public')->url($media);
    }
}

if (! function_exists('thumbnail_url')) {
    /**
     * Return the public thumbnail URL for an image media item.
     */
    function thumbnail_url(Media|string|null $media): ?string
    {
        if (! $media) {
            return null;
        }

        if ($media instanceof Media) {
            return $media->thumbnail_url;
        }

        $thumbnailPath = preg_replace('/\/media\//', '/media/thumbnails/', $media, 1);

        if (Storage::disk('public')->exists($thumbnailPath)) {
            return Storage::disk('public')->url($thumbnailPath);
        }

        return Storage::disk('public')->url($media);
    }
}

if (! function_exists('image_url')) {
    /**
     * Return the public URL for an image or media item.
     */
    function image_url(Media|string|null $media): ?string
    {
        return media_url($media);
    }
}
