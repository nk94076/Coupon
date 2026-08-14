<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('code')->nullable();
            $table->text('description')->nullable();

            $table->string('discount_type')->default('percentage');
            $table->decimal('discount_value', 10, 2)->nullable();
            $table->decimal('minimum_order', 10, 2)->nullable();
            $table->decimal('maximum_discount', 10, 2)->nullable();

            $table->date('start_date')->nullable();
            $table->date('expiry_date')->nullable();

            $table->string('coupon_type')->default('general');
            $table->boolean('is_new_user')->default(false);
            $table->boolean('is_app_only')->default(false);
            $table->boolean('is_bank_offer')->default(false);
            $table->boolean('is_student')->default(false);

            $table->string('affiliate_url')->nullable();

            $table->string('status')->default('active');
            $table->boolean('featured')->default(false);
            $table->boolean('exclusive')->default(false);
            $table->boolean('verified')->default(false);
            $table->unsignedInteger('sort_order')->default(0);

            // SEO placeholders (Phase 3 will expand these into a full SEO engine).
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('canonical_url')->nullable();
            $table->boolean('robots_index')->default(true);
            $table->boolean('robots_follow')->default(true);
            $table->string('og_title')->nullable();
            $table->string('og_description')->nullable();
            $table->string('og_image')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('expiry_date');
            $table->index('verified');
            $table->index('featured');
            $table->index('coupon_type');
            $table->index('discount_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
