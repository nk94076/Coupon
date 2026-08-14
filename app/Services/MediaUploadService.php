<?php

namespace App\Services;

use App\Models\AdminUser;
use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Reusable, secure file upload service for store logos, category images,
 * coupon images, SEO OG images and the standalone Media Library. Every
 * future media need (Phase 2+) should go through this service rather than
 * touching Storage directly.
 *
 * Security notes:
 *  - The client-supplied filename/extension is never trusted or reused.
 *  - The stored filename is randomly generated with an extension derived
 *    from the file's real, server-detected MIME type, so a disguised
 *    executable (e.g. shell.php renamed to .jpg) cannot be stored with an
 *    executable extension.
 *  - Only image MIME types configured in config/media.php are accepted.
 */
class MediaUploadService
{
    private const EXTENSION_MAP = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    /**
     * Store a file directly against a model field (store logo, category
     * image, coupon OG image, ...) and return its storage path. No Media
     * library record is created for these single-purpose uploads.
     */
    public function storeFile(UploadedFile $file, string $directory): string
    {
        return $this->putFile($file, $directory);
    }

    /**
     * Store a new file and delete the previous one at $existingPath, if any.
     */
    public function replaceFile(UploadedFile $file, string $directory, ?string $existingPath = null): string
    {
        $path = $this->putFile($file, $directory);

        $this->deletePath($existingPath);

        return $path;
    }

    /**
     * Store a file in the shared Media Library, tracked in the `media` table.
     */
    public function store(UploadedFile $file, string $directory, ?AdminUser $uploader = null): Media
    {
        $path = $this->putFile($file, $directory);

        return Media::create([
            'admin_user_id' => $uploader?->id,
            'disk' => config('media.disk'),
            'directory' => $directory,
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);
    }

    public function delete(Media $media): void
    {
        Storage::disk($media->disk)->delete($media->path);
        $media->delete();
    }

    public function deletePath(?string $path, ?string $disk = null): void
    {
        if (! $path) {
            return;
        }

        Storage::disk($disk ?? config('media.disk'))->delete($path);
    }

    private function putFile(UploadedFile $file, string $directory): string
    {
        $this->assertValid($file);

        $extension = self::EXTENSION_MAP[$file->getMimeType()];
        $filename = Str::random(40).'.'.$extension;

        return $file->storeAs($directory, $filename, config('media.disk'));
    }

    private function assertValid(UploadedFile $file): void
    {
        if (! $file->isValid()) {
            throw new InvalidArgumentException('The uploaded file is invalid.');
        }

        $mime = $file->getMimeType();

        if (! in_array($mime, config('media.allowed_mime_types'), true) || ! isset(self::EXTENSION_MAP[$mime])) {
            throw new InvalidArgumentException('Unsupported file type. Only JPG, PNG and WebP images are allowed.');
        }

        $maxBytes = config('media.max_size_kb') * 1024;

        if ($file->getSize() > $maxBytes) {
            throw new InvalidArgumentException('The uploaded file exceeds the maximum allowed size.');
        }
    }
}
