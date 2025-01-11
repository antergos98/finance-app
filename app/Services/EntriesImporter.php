<?php

namespace App\Services;

use App\Events\EntriesImportFinished;
use App\Events\EntriesImportStarted;
use App\Models\User;
use Illuminate\Container\Attributes\Authenticated;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

readonly class EntriesImporter
{
    private const CHUNK_SIZE = 500;

    public function __construct(
        #[Authenticated] private User $user,
    ) {}

    public function import(UploadedFile $file): void
    {
        $rows = $this->collectRows($file);

        EntriesImportStarted::dispatch($this->user, count($rows));

        DB::transaction(fn () => $this->bulkInsert($rows));

        EntriesImportFinished::dispatch($this->user);
    }

    private function bulkInsert(Collection $rows): void
    {
        foreach ($rows->chunk(self::CHUNK_SIZE) as $chunk) {
            $this->user->entries()->createMany($chunk->toArray());
        }
    }

    /**
     * @return Collection<int, array{label: string, amount: string, date: string}>
     */
    private function collectRows(UploadedFile $file): Collection
    {
        $rows = collect();

        if (($handle = fopen($file->path(), 'r')) !== false) {
            fgetcsv($handle);

            while (($row = fgetcsv($handle)) !== false) {
                $rows->push([
                    'label' => $row[0],
                    'amount' => $row[1] * 100,
                    'date' => $row[2],
                ]);
            }

            fclose($handle);
        }

        return $rows;
    }
}
