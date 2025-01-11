<?php

namespace Tests\Unit\Models;

use App\Models\Entry;
use App\Models\User;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(User::class)]
class EntryTest extends TestCase
{
    #[Test]
    public function it_belongs_to_a_user(): void
    {
        /** @var Entry $model */
        $model = Entry::factory()->create();
        $this->assertInstanceOf(User::class, $model->user);
    }

    #[Test]
    public function it_returns_a_friendly_date(): void
    {
        /** @var Entry $model */
        $model = Entry::factory()->create(['date' => Carbon::parse('november 29th 2024 at 1:05 AM')]);
        $this->assertSame('29 Nov, 2024 at 01:05 AM', $model->friendly_date);
    }
}
