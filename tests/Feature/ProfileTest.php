<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $admin = AdminUser::factory()->create();

        $response = $this
            ->actingAs($admin, 'admin')
            ->get('/admin/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $admin = AdminUser::factory()->create();

        $response = $this
            ->actingAs($admin, 'admin')
            ->patch('/admin/profile', [
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/admin/profile');

        $admin->refresh();

        $this->assertSame('Updated Name', $admin->name);
        $this->assertSame('updated@example.com', $admin->email);
    }
}
