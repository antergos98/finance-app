<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use App\Http\Controllers\UploadEntriesController;
use App\Models\Entry;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(UploadEntriesController::class)]
class UploadEntriesControllerTest extends TestCase
{
    #[Test]
    public function it_shows_index(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(action([UploadEntriesController::class, 'index']))
            ->assertInertia(fn (AssertableInertia $page) => $page->component('Entries/Upload'));
    }

    #[Test]
    public function it_uploads_the_file(): void
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()
            ->createWithContent('test.csv', <<<'CSV'
Label,Value,Date
"Car Insurance",-185.15,"2016-01-16 18:02:17"
"Groceries",-69.52,"1986-07-20 04:17:58"
CSV);

        $this->actingAs($user)
            ->post(action([UploadEntriesController::class, 'store']), ['file' => $file])
            ->assertRedirect();

        $this->assertDatabaseHas(Entry::class, ['label' => 'Car Insurance', 'user_id' => $user->getKey(), 'amount' => '-1851500']);
    }

    #[Test]
    public function cannot_upload_a_large_file(): void
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()
            ->create('test.csv', 8 * 1024);

        $this->actingAs($user)
            ->post(action([UploadEntriesController::class, 'store']), ['file' => $file])
            ->assertSessionHasErrors('file');
    }

    #[Test]
    public function cannot_upload_a_file_other_than_csv(): void
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()
            ->create('test.pdf', mimeType: 'application/pdf');

        $this->actingAs($user)
            ->post(action([UploadEntriesController::class, 'store']), ['file' => $file])
            ->assertSessionHasErrors('file');
    }

    #[Test]
    public function file_is_required(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(action([UploadEntriesController::class, 'store']), ['file' => null])
            ->assertSessionHasErrors('file');
    }
}
