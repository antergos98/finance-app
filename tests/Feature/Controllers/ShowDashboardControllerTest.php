<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use App\Http\Controllers\ShowDashboardController;
use App\Models\Entry;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ShowDashboardController::class)]
class ShowDashboardControllerTest extends TestCase
{
    #[Test]
    public function it_renders_a_component(): void
    {
        $user = User::factory()
            ->has(Entry::factory()->count(3)->state(['amount' => 100_000]))
            ->create();

        $this->actingAs($user)
            ->get(action(ShowDashboardController::class))
            ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page->component('Dashboard')
                ->has('entries', 1)
                ->where('totalBalance', 300_000)
            );
    }
}
