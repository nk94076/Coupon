<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponRequest;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Store;
use App\Services\ActivityLogService;
use App\Services\MediaUploadService;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CouponController extends Controller
{
    public function __construct(private readonly MediaUploadService $mediaUploadService)
    {
        $this->authorizeResource(Coupon::class, 'coupon');
    }

    public function index(Request $request): View
    {
        $coupons = Coupon::query()
            ->with(['store', 'category'])
            ->search($request->string('search')->toString() ?: null)
            ->when($request->filled('store_id'), fn ($q) => $q->where('store_id', $request->integer('store_id')))
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->integer('category_id')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->toString()))
            ->when($request->filled('verified'), fn ($q) => $q->where('verified', $request->boolean('verified')))
            ->when($request->filled('featured'), fn ($q) => $q->where('featured', $request->boolean('featured')))
            ->when($request->filled('exclusive'), fn ($q) => $q->where('exclusive', $request->boolean('exclusive')))
            ->when($request->filled('coupon_type'), fn ($q) => $q->where('coupon_type', $request->string('coupon_type')->toString()))
            ->when($request->filled('expired'), fn ($q) => $request->boolean('expired') ? $q->expired() : $q->notExpired())
            ->orderByDesc('created_at')
            ->paginate((int) setting('default_pagination', 15))
            ->withQueryString();

        $stores = Store::query()->orderBy('name')->get(['id', 'name']);
        $categories = Category::query()->orderBy('name')->get(['id', 'name']);

        return view('admin.coupons.index', compact('coupons', 'stores', 'categories'));
    }

    public function create(): View
    {
        $stores = Store::query()->orderBy('name')->get(['id', 'name']);
        $categories = Category::query()->orderBy('name')->get(['id', 'name']);

        return view('admin.coupons.create', compact('stores', 'categories'));
    }

    public function store(CouponRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? SlugService::unique(Coupon::class, $data['title']);

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $this->mediaUploadService->storeFile($request->file('og_image'), 'coupons/og');
        }

        $coupon = Coupon::create($data);

        ActivityLogService::log('create', 'coupon', $coupon->id, "Admin created coupon {$coupon->title}");

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function edit(Coupon $coupon): View
    {
        $stores = Store::query()->orderBy('name')->get(['id', 'name']);
        $categories = Category::query()->orderBy('name')->get(['id', 'name']);

        return view('admin.coupons.edit', compact('coupon', 'stores', 'categories'));
    }

    public function update(CouponRequest $request, Coupon $coupon): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? SlugService::unique(Coupon::class, $data['title'], $coupon->id);

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $this->mediaUploadService->replaceFile($request->file('og_image'), 'coupons/og', $coupon->og_image);
        }

        $coupon->update($data);

        ActivityLogService::log('update', 'coupon', $coupon->id, "Admin updated coupon {$coupon->title}");

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon): RedirectResponse
    {
        $title = $coupon->title;
        $coupon->delete();

        ActivityLogService::log('delete', 'coupon', $coupon->id, "Admin deleted coupon {$title}");

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully.');
    }

    public function toggleStatus(Coupon $coupon): RedirectResponse
    {
        $this->authorize('update', $coupon);

        $coupon->status = $coupon->status === Status::Active ? Status::Inactive : Status::Active;
        $coupon->save();

        ActivityLogService::log('update', 'coupon', $coupon->id, "Admin changed status of coupon {$coupon->title} to {$coupon->status->value}");

        return back()->with('success', 'Coupon status updated.');
    }

    public function toggleFeatured(Coupon $coupon): RedirectResponse
    {
        $this->authorize('update', $coupon);

        $coupon->featured = ! $coupon->featured;
        $coupon->save();

        ActivityLogService::log('update', 'coupon', $coupon->id, "Admin toggled featured for coupon {$coupon->title}");

        return back()->with('success', 'Coupon updated.');
    }

    public function toggleExclusive(Coupon $coupon): RedirectResponse
    {
        $this->authorize('update', $coupon);

        $coupon->exclusive = ! $coupon->exclusive;
        $coupon->save();

        ActivityLogService::log('update', 'coupon', $coupon->id, "Admin toggled exclusive for coupon {$coupon->title}");

        return back()->with('success', 'Coupon updated.');
    }

    public function toggleVerified(Coupon $coupon): RedirectResponse
    {
        $this->authorize('update', $coupon);

        $coupon->verified = ! $coupon->verified;
        $coupon->save();

        ActivityLogService::log('update', 'coupon', $coupon->id, "Admin marked coupon {$coupon->title} as ".($coupon->verified ? 'verified' : 'unverified'));

        return back()->with('success', 'Coupon updated.');
    }
}
