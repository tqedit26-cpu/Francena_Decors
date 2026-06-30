<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    public function storeFile(UploadedFile $file, string $folder, int $userId): Media
    {
        $folder = $this->sanitizeFolder($folder);
        $fileName = $this->generateUniqueFileName($file);
        $filePath = Storage::disk('public')->putFileAs("media/{$folder}", $file, $fileName);

        $isImage = $this->isImage($file);
        $dimensions = $this->getImageDimensions($filePath, $isImage);

        $media = Media::create([
            'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'alt_text' => null,
            'caption' => null,
            'description' => null,
            'file_name' => $fileName,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'disk' => 'public',
            'mime_type' => $file->getClientMimeType(),
            'extension' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'width' => $dimensions['width'],
            'height' => $dimensions['height'],
            'folder' => $folder,
            'is_image' => $isImage,
            'status' => true,
            'uploaded_by' => $userId,
        ]);

        if ($isImage) {
            $this->generateThumbnail($filePath);
        }

        return $media;
    }

    public function delete(Media $media): bool
    {
        if (Storage::disk($media->disk)->exists($media->file_path)) {
            Storage::disk($media->disk)->delete($media->file_path);
        }

        if ($media->is_image) {
            $thumbnailPath = $media->thumbnailPath();
            if (Storage::disk($media->disk)->exists($thumbnailPath)) {
                Storage::disk($media->disk)->delete($thumbnailPath);
            }
        }

        return $media->delete();
    }

    public function moveToFolder(Media $media, string $folder): void
    {
        $folder = $this->sanitizeFolder($folder);

        if ($folder === $media->folder) {
            return;
        }

        $destinationPath = 'media/' . $folder . '/' . $media->file_name;
        Storage::disk($media->disk)->move($media->file_path, $destinationPath);

        if ($media->is_image) {
            $oldThumbnailPath = $media->thumbnailPath();
            $newThumbnailPath = preg_replace('/\/media\//', '/media/thumbnails/', $destinationPath, 1);
            if (Storage::disk($media->disk)->exists($oldThumbnailPath)) {
                Storage::disk($media->disk)->move($oldThumbnailPath, $newThumbnailPath);
            }
        }

        $media->update([
            'folder' => $folder,
            'file_path' => $destinationPath,
        ]);
    }

    protected function sanitizeFolder(string $folder): string
    {
        return trim(Str::slug($folder, '-')) ?: 'custom';
    }

    protected function generateUniqueFileName(UploadedFile $file): string
    {
        $baseName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $extension = $file->getClientOriginalExtension();

        return sprintf('%s-%s.%s', $baseName, Str::random(8), $extension);
    }

    protected function isImage(UploadedFile $file): bool
    {
        return str_starts_with($file->getMimeType(), 'image/');
    }

    protected function getImageDimensions(string $filePath, bool $isImage): array
    {
        if (! $isImage) {
            return ['width' => null, 'height' => null];
        }

        $path = Storage::disk('public')->path($filePath);
        $dimensions = @getimagesize($path);

        return [
            'width' => $dimensions[0] ?? null,
            'height' => $dimensions[1] ?? null,
        ];
    }

    protected function generateThumbnail(string $filePath): void
    {
        $storage = Storage::disk('public');
        $fullPath = $storage->path($filePath);
        $thumbnailPath = preg_replace('/\/media\//', '/media/thumbnails/', $filePath, 1);
        $thumbnailDirectory = dirname($thumbnailPath);

        if (! $storage->exists($thumbnailDirectory)) {
            $storage->makeDirectory($thumbnailDirectory);
        }

        $imageInfo = @getimagesize($fullPath);

        if (! $imageInfo) {
            return;
        }

        [$width, $height, $type] = $imageInfo;
        $newWidth = 300;
        $newHeight = (int) (($height / $width) * $newWidth);

        $sourceImage = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($fullPath),
            IMAGETYPE_PNG => imagecreatefrompng($fullPath),
            IMAGETYPE_WEBP => imagecreatefromwebp($fullPath),
            default => null,
        };

        if (! $sourceImage) {
            return;
        }

        $thumbnail = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($thumbnail, false);
        imagesavealpha($thumbnail, true);
        imagecopyresampled($thumbnail, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        ob_start();
        match ($type) {
            IMAGETYPE_JPEG => imagejpeg($thumbnail, null, 80),
            IMAGETYPE_PNG => imagepng($thumbnail, null, 8),
            IMAGETYPE_WEBP => imagewebp($thumbnail, null, 80),
            default => null,
        };
        $imageData = ob_get_clean();

        if ($imageData !== false) {
            $storage->put($thumbnailPath, $imageData);
        }

        imagedestroy($sourceImage);
        imagedestroy($thumbnail);
    }
}
