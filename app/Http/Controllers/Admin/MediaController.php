<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MediaUploadRequest;
use App\Models\Media;
use App\Services\ActivityLogService;
use App\Services\MediaUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function __construct(private readonly MediaUploadService $mediaUploadService) {}

    public function index(): View
    {
        $media = Media::query()->with('uploader')->latest()->paginate(24);

        return view('admin.media.index', compact('media'));
    }

    public function store(MediaUploadRequest $request): RedirectResponse
    {
        $media = $this->mediaUploadService->store($request->file('file'), 'library', Auth::guard('admin')->user());

        ActivityLogService::log('upload', 'media', $media->id, "Admin uploaded media {$media->original_name}");

        return back()->with('success', 'File uploaded successfully.');
    }

    public function destroy(Media $medium): RedirectResponse
    {
        $name = $medium->original_name;
        $this->mediaUploadService->delete($medium);

        ActivityLogService::log('delete', 'media', $medium->id, "Admin deleted media {$name}");

        return back()->with('success', 'File deleted successfully.');
    }
}
