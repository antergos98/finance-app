<?php

namespace Tests\Feature\Services;

use App\Events\EntriesImportFinished;
use App\Events\EntriesImportStarted;
use App\Models\Entry;
use App\Models\User;
use App\Services\EntriesImporter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(EntriesImporter::class)]
class EntriesImporterTest extends TestCase
{
    #[Test]
    public function it_uploads_csv_into_database_for_current_user(): void
    {
        Event::fake();

        $file = UploadedFile::fake()
            ->createWithContent('test.csv', <<<'CSV'
Label,Value,Date
"Car Insurance",-185.15,"2016-01-16 18:02:17"
"Groceries",-69.52,"1986-07-20 04:17:58"
CSV);

        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var EntriesImporter $importer */
        $importer = app(EntriesImporter::class);
        $importer->import($file);

        $this->assertDatabaseCount(Entry::class, 2);

        $this->assertDatabaseHas(Entry::class, ['label' => 'Car Insurance', 'user_id' => $user->getKey(), 'amount' => '-1851500']);
        $this->assertDatabaseHas(Entry::class, ['label' => 'Groceries', 'user_id' => $user->getKey(), 'amount' => '-695200']);

        Event::assertDispatched(EntriesImportStarted::class, fn (EntriesImportStarted $event) => $event->count === 2);
        Event::assertDispatched(EntriesImportFinished::class);
    }
}
