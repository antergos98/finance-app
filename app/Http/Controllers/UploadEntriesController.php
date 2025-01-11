<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UploadEntriesRequest;
use App\Services\EntriesImporter;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class UploadEntriesController
{
    public function index(): Response
    {
        return inertia()->render('Entries/Upload');
    }

    public function store(UploadEntriesRequest $request, EntriesImporter $importer): RedirectResponse
    {
        defer(fn () => $importer->import($request->file('file')));

        return redirect()->to(action(ShowDashboardController::class));
    }
}
