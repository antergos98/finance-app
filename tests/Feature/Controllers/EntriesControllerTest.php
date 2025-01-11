<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use App\Http\Controllers\EntriesController;
use App\Models\Entry;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(EntriesController::class)]
class EntriesControllerTest extends TestCase
{
    #[Test]
    public function it_renders_create_component(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(action([EntriesController::class, 'create']))
            ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page->component('Entries/Create'));
    }

    #[Test]
    public function it_stores_an_entries(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(action([EntriesController::class, 'store']), Entry::factory()->raw(['label' => 'test']))
            ->assertRedirect();

        $this->assertDatabaseHas(Entry::class, ['label' => 'test', 'user_id' => $user->getKey()]);
    }

    #[Test]
    public function a_user_cannot_delete_entries_of_others(): void
    {
        $user = User::factory()->create();

        $entry = Entry::factory()
            ->create();

        $this->actingAs($user)
            ->delete(action([EntriesController::class, 'destroy'], ['entry' => $entry->getKey()]))
            ->assertForbidden();

        $this->assertDatabaseHas(Entry::class, ['id' => $entry->getKey()]);
    }

    #[Test]
    public function a_user_can_delete_their_own_entries(): void
    {
        $user = User::factory()->create();

        $entry = Entry::factory()
            ->for($user)
            ->create();

        $this->actingAs($user)
            ->delete(action([EntriesController::class, 'destroy'], ['entry' => $entry->getKey()]))
            ->assertRedirect();

        $this->assertDatabaseMissing(Entry::class, ['id' => $entry->getKey()]);
    }
}
