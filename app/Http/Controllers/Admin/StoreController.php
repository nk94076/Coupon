<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRequest;
use App\Models\Category;
use App\Models\Store;
use App\Services\ActivityLogService;
use App\Services\MediaUploadService;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function __construct(private readonly MediaUploadService $mediaUploadService)
    {
        $this->authorizeResource(Store::class, 'store');
    }

    public function index(Request $request): View
    {
        $stores = Store::query()
            ->with('category')
            ->withCount('coupons')
            ->search($request->string('search')->toString() ?: null)
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->integer('category_id')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->toString()))
            ->when($request->filled('featured'), fn ($q) => $q->where('featured', $request->boolean('featured')))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate((int) setting('default_pagination', 15))
            ->withQueryString();

        $categories = Category::query()->orderBy('name')->get(['id', 'name']);

        return view('admin.stores.index', compact('stores', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::query()->orderBy('name')->get(['id', 'name']);

        return view('admin.stores.create', compact('categories'));
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? SlugService::unique(Store::class, $data['name']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->mediaUploadService->storeFile($request->file('logo'), 'stores/logos');
        }

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $this->mediaUploadService->storeFile($request->file('og_image'), 'stores/og');
        }

        $store = Store::create($data);

        ActivityLogService::log('create', 'store', $store->id, "Admin created store {$store->name}");

        return redirect()->route('admin.stores.index')->with('success', 'Store created successfully.');
    }

    public function edit(Store $store): View
    {
        $categories = Category::query()->orderBy('name')->get(['id', 'name']);

        return view('admin.stores.edit', compact('store', 'categories'));
    }

    public function update(StoreRequest $request, Store $store): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? SlugService::unique(Store::class, $data['name'], $store->id);

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->mediaUploadService->replaceFile($request->file('logo'), 'stores/logos', $store->logo);
        }

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $this->mediaUploadService->replaceFile($request->file('og_image'), 'stores/og', $store->og_image);
        }

        $store->update($data);

        ActivityLogService::log('update', 'store', $store->id, "Admin updated store {$store->name}");

        return redirect()->route('admin.stores.index')->with('success', 'Store updated successfully.');
    }

    public function destroy(Store $store): RedirectResponse
    {
        $name = $store->name;
        $store->delete();

        ActivityLogService::log('delete', 'store', $store->id, "Admin deleted store {$name}");

        return redirect()->route('admin.stores.index')->with('success', 'Store deleted successfully.');
    }

    public function toggleStatus(Store $store): RedirectResponse
    {
        $this->authorize('update', $store);

        $store->status = $store->status === Status::Active ? Status::Inactive : Status::Active;
        $store->save();

        ActivityLogService::log('update', 'store', $store->id, "Admin changed status of store {$store->name} to {$store->status->value}");

        return back()->with('success', 'Store status updated.');
    }

    public function toggleFeatured(Store $store): RedirectResponse
    {
        $this->authorize('update', $store);

        $store->featured = ! $store->featured;
        $store->save();

        ActivityLogService::log('update', 'store', $store->id, "Admin toggled featured for store {$store->name}");

        return back()->with('success', 'Store updated.');
    }
}
