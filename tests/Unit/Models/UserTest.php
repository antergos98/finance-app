<?php

namespace Tests\Unit\Models;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(User::class)]
class UserTest extends TestCase
{
    #[Test]
    public function it_has_many_entries(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->has(Entry::factory(2))
            ->create();

        $this->assertCount(2, $user->entries);
        $this->assertInstanceOf(Collection::class, $user->entries);
    }
}
