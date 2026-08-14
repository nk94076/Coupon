<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Services\ActivityLogService;
use App\Services\MediaUploadService;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(private readonly MediaUploadService $mediaUploadService)
    {
        $this->authorizeResource(Category::class, 'category');
    }

    public function index(Request $request): View
    {
        $categories = Category::query()
            ->withCount('stores')
            ->with('parent')
            ->search($request->string('search')->toString() ?: null)
            ->when($request->filled('parent_id'), fn ($q) => $q->where('parent_id', $request->integer('parent_id')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->toString()))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate((int) setting('default_pagination', 15))
            ->withQueryString();

        $parents = Category::query()->whereNull('parent_id')->orderBy('name')->get(['id', 'name']);

        return view('admin.categories.index', compact('categories', 'parents'));
    }

    public function create(): View
    {
        $parents = Category::query()->whereNull('parent_id')->orderBy('name')->get(['id', 'name']);

        return view('admin.categories.create', compact('parents'));
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? SlugService::unique(Category::class, $data['name']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->mediaUploadService->storeFile($request->file('image'), 'categories');
        }

        $category = Category::create($data);

        ActivityLogService::log('create', 'category', $category->id, "Admin created category {$category->name}");

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category): View
    {
        $parents = Category::query()->whereNull('parent_id')->where('id', '!=', $category->id)->orderBy('name')->get(['id', 'name']);

        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? SlugService::unique(Category::class, $data['name'], $category->id);

        if ($request->hasFile('image')) {
            $data['image'] = $this->mediaUploadService->replaceFile($request->file('image'), 'categories', $category->image);
        }

        $category->update($data);

        ActivityLogService::log('update', 'category', $category->id, "Admin updated category {$category->name}");

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $name = $category->name;
        $category->delete();

        ActivityLogService::log('delete', 'category', $category->id, "Admin deleted category {$name}");

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

    public function toggleStatus(Category $category): RedirectResponse
    {
        $this->authorize('update', $category);

        $category->status = $category->status === Status::Active ? Status::Inactive : Status::Active;
        $category->save();

        ActivityLogService::log('update', 'category', $category->id, "Admin changed status of category {$category->name} to {$category->status->value}");

        return back()->with('success', 'Category status updated.');
    }

    public function toggleFeatured(Category $category): RedirectResponse
    {
        $this->authorize('update', $category);

        $category->featured = ! $category->featured;
        $category->save();

        ActivityLogService::log('update', 'category', $category->id, "Admin toggled featured for category {$category->name}");

        return back()->with('success', 'Category updated.');
    }
}
