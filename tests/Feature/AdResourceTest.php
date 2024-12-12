<?php

namespace Tests\Feature;

use App\Filament\Resources\AdResource\Pages\EditAd;
use App\Filament\Resources\AdResource\Pages\CreateAd;
use App\Filament\Resources\AdResource\Pages\ListAds;
use App\Models\Ad;
use App\Models\User;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use App\Filament\Resources\AdResource;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class AdResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::firstOrCreate(['name' => 'manage_ads', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'manage_ad_templates', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'system_configurations', 'guard_name' => 'web']);

        $role = Role::create(['name' => 'Super Admin']);
        $role->givePermissionTo(['manage_ads', 'manage_ad_templates']);

        // Create Super Admin
        $this->user = User::factory()->create();
        $this->user->assignRole($role);

        $this->actingAs($this->user);
    }

    #[Test]
    public function can_access_index_page()
    {
        $response = $this->get(AdResource::getUrl());
        $response->assertOk();
    }

    #[Test]
    public function can_see_existing_ads_in_index()
    {
        Ad::factory()->create(['title' => 'Test Ad']);

        $response = $this->get(AdResource::getUrl());
        $response->assertSee('Test Ad');
    }

    #[Test]
    public function can_access_create_page()
    {
        $response = $this->get(AdResource::getUrl('create'));
        $response->assertOk();
        $response->assertSee('Create Ad');
    }

    #[Test]
    public function can_create_an_ad()
    {
        Livewire::test(CreateAd::class)
            ->set('data.title', 'New Ad Title')
            ->set('data.description', 'This is a new ad description')
            ->set('data.url', 'https://example.com')
            ->set('data.status', Ad::STATUS_PENDING)
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('ads', [
            'title' => 'New Ad Title',
            'description' => 'This is a new ad description',
        ]);
    }

    #[Test]
    public function can_access_view_page()
    {
        $ad = Ad::factory()->create();

        $response = $this->get(AdResource::getUrl('view', [$ad]));
        $response->assertOk();
        $response->assertSee($ad->title);
    }

    #[Test]
    public function can_access_edit_page()
    {
        $ad = Ad::factory()->create(['title' => 'Original Title']);

        $response = $this->get(AdResource::getUrl('edit', [$ad]));
        $response->assertOk();
        $response->assertSee('Original Title');
    }

    #[Test]
    public function can_update_an_ad()
    {
        $ad = Ad::factory()->create(['title' => 'Old Title']);

        Livewire::test(EditAd::class, ['record' => $ad->id])
            ->set('data.title', 'Updated Title')
            ->set('data.description', 'Updated description')
            ->set('data.url', 'https://updated.com')
            ->set('data.status', Ad::STATUS_IN_PROGRESS)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('ads', [
            'id' => $ad->id,
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'url' => 'https://updated.com',
            'status' => Ad::STATUS_IN_PROGRESS,
        ]);
    }

    #[Test]
    public function can_delete_an_ad()
    {
        $ad = Ad::factory()->create();

        Livewire::test(ListAds::class)
            ->callTableAction('delete', $ad->id)
            ->assertHasNoErrors();

        // Check soft delete
        $this->assertSoftDeleted('ads', ['id' => $ad->id]);
    }

    #[Test]
    public function can_generate_ad_template_action()
    {
        $ad = Ad::factory()->create(['status' => Ad::STATUS_PENDING]);

        // Trigger the "Generate Ad Template" action via the ListAds Livewire component
        Livewire::test(ListAds::class)
            ->callTableAction('generateTemplate', $ad->id)
            ->assertHasNoErrors();

        $ad->refresh();
        $this->assertEquals(Ad::STATUS_COMPLETED, $ad->status, 'Ad status should be completed after template generation.');

        $this->assertDatabaseHas('ad_templates', [
            'ad_id' => $ad->id,
            'title' => $ad->title.' Template',
        ]);
    }

    #[Test]
    public function unauthorized_user_cannot_access_resource()
    {
        // Create a user without permissions
        $user = User::factory()->create();
        $this->be($user);
        $user->removeRole('Super Admin');

        $response = $this->get(AdResource::getUrl());
        $response->assertForbidden();
    }
}
