<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'alt_text',
        'caption',
        'description',
        'file_name',
        'original_name',
        'file_path',
        'disk',
        'mime_type',
        'extension',
        'file_size',
        'width',
        'height',
        'folder',
        'is_image',
        'status',
        'uploaded_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'file_size' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'is_image' => 'boolean',
        'status' => 'boolean',
    ];

    /**
     * The user who uploaded the file.
     */
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the public URL to the media file.
     */
    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->file_path);
    }

    /**
     * Get the public URL to the thumbnail if available.
     */
    public function getThumbnailUrlAttribute(): string
    {
        if (! $this->is_image) {
            return $this->url;
        }

        $thumbnailPath = $this->thumbnailPath();

        if (Storage::disk($this->disk)->exists($thumbnailPath)) {
            return Storage::disk($this->disk)->url($thumbnailPath);
        }

        return $this->url;
    }

    /**
     * Build the thumbnail path from the file path.
     */
    public function thumbnailPath(): string
    {
        return preg_replace('/\/media\//', '/media/thumbnails/', $this->file_path, 1);
    }

    /**
     * Get the file type category.
     */
    public function getTypeAttribute(): string
    {
        return $this->is_image ? 'image' : explode('/', $this->mime_type)[0] ?? 'file';
    }

    /**
     * Get a human readable file size.
     */
    public function getHumanSizeAttribute(): string
    {
        if ($this->file_size >= 1048576) {
            return number_format($this->file_size / 1048576, 2) . ' MB';
        }

        if ($this->file_size >= 1024) {
            return number_format($this->file_size / 1024, 2) . ' KB';
        }

        return $this->file_size . ' B';
    }
}
