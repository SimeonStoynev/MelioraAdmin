<?php

namespace Tests\Feature;

use App\Filament\Resources\AdTemplateResource;
use App\Filament\Resources\AdTemplateResource\Pages\ListAdTemplates;
use App\Filament\Resources\AdTemplateResource\Pages\CreateAdTemplate;
use App\Filament\Resources\AdTemplateResource\Pages\EditAdTemplate;
use App\Models\Ad;
use App\Models\AdTemplate;
use App\Models\User;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;

class AdTemplateResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::create(['name' => 'manage_ads', 'guard_name' => 'web']);
        Permission::create(['name' => 'manage_ad_templates', 'guard_name' => 'web']);
        Permission::create(['name' => 'system_configurations', 'guard_name' => 'web']);

        $role = Role::create(['name' => 'Super Admin']);
        $role->givePermissionTo(['manage_ad_templates', 'manage_ads']);

        // Create Super Admin user
        $this->user = User::factory()->create();
        $this->user->assignRole($role);

        $this->actingAs($this->user);
    }

    #[Test]
    public function can_access_index_page()
    {
        $response = $this->get(AdTemplateResource::getUrl());
        $response->assertOk();
    }

    #[Test]
    public function can_see_existing_ad_templates_in_index()
    {
        $ad = Ad::factory()->create();
        AdTemplate::factory()->create(['title' => 'Test Template', 'ad_id' => $ad->id]);

        $response = $this->get(AdTemplateResource::getUrl());
        $response->assertSee('Test Template');
    }

    #[Test]
    public function can_access_create_page()
    {
        $response = $this->get(AdTemplateResource::getUrl('create'));
        $response->assertOk();
        $response->assertSee('Create Ad Template');
    }

    #[Test]
    public function can_create_an_ad_template()
    {
        $ad = Ad::factory()->create();

        Livewire::test(CreateAdTemplate::class)
            ->set('data.title', 'New Ad Template Title')
            ->set('data.description', 'This is a new ad template description')
            ->set('data.canva_url', 'https://canva.com/example')
            ->set('data.status', AdTemplate::STATUS_DRAFT)
            ->set('data.ad_id', $ad->id)
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('ad_templates', [
            'title' => 'New Ad Template Title',
            'description' => 'This is a new ad template description',
            'canva_url' => 'https://canva.com/example',
            'ad_id' => $ad->id,
        ]);
    }

    #[Test]
    public function can_access_view_page()
    {
        $ad = Ad::factory()->create();
        $adTemplate = AdTemplate::factory()->create(['ad_id' => $ad->id]);

        $response = $this->get(AdTemplateResource::getUrl('view', [$adTemplate]));
        $response->assertOk();
        $response->assertSee($adTemplate->title);
    }

    #[Test]
    public function can_access_edit_page()
    {
        $ad = Ad::factory()->create();
        $adTemplate = AdTemplate::factory()->create(['title' => 'Original Template Title', 'ad_id' => $ad->id]);

        $response = $this->get(AdTemplateResource::getUrl('edit', [$adTemplate]));
        $response->assertOk();
        $response->assertSee('Original Template Title');
    }

    #[Test]
    public function can_update_an_ad_template()
    {
        $ad = Ad::factory()->create();
        $adTemplate = AdTemplate::factory()->create(['title' => 'Old Template Title', 'ad_id' => $ad->id]);

        Livewire::test(EditAdTemplate::class, ['record' => $adTemplate->id])
            ->set('data.title', 'Updated Template Title')
            ->set('data.description', 'Updated template description')
            ->set('data.canva_url', 'https://canva.com/updated')
            ->set('data.status', AdTemplate::STATUS_ACTIVE)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('ad_templates', [
            'id' => $adTemplate->id,
            'title' => 'Updated Template Title',
            'description' => 'Updated template description',
            'canva_url' => 'https://canva.com/updated',
            'status' => AdTemplate::STATUS_ACTIVE,
        ]);
    }

    #[Test]
    public function can_delete_an_ad_template()
    {
        $ad = Ad::factory()->create();
        $adTemplate = AdTemplate::factory()->create(['ad_id' => $ad->id]);

        Livewire::test(ListAdTemplates::class)
            ->callTableAction('delete', $adTemplate->id)
            ->assertHasNoErrors();

        // Check soft delete
        $this->assertSoftDeleted('ad_templates', ['id' => $adTemplate->id]);
    }

    #[Test]
    public function unauthorized_user_cannot_access_ad_templates_resource()
    {
        // Create a user without permissions
        $user = User::factory()->create();
        $this->be($user);
        $user->removeRole('Super Admin');

        $response = $this->get(AdTemplateResource::getUrl());
        $response->assertForbidden();
    }
}
