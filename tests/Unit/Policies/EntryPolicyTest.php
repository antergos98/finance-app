<?php

namespace Tests\Unit\Policies;

use App\Models\Entry;
use App\Policies\EntryPolicy;
use Illuminate\Support\Facades\Gate;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(EntryPolicy::class)]
class EntryPolicyTest extends TestCase
{
    #[Test]
    public function it_checks_if_user_is_owner(): void
    {
        $entry = Entry::factory()->create();

        $this->actingAs($entry->user);
        $this->assertTrue(Gate::allows('delete', $entry));
        $this->assertTrue(Gate::allows('update', $entry));
    }
}
