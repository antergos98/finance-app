<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntryRequest;
use App\Http\Requests\UpdateEntryRequest;
use App\Models\Entry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Response;

class EntriesController
{
    public function create(): Response
    {
        return inertia()->render('Entries/Create');
    }

    public function store(StoreEntryRequest $request): RedirectResponse
    {
        auth()->user()->entries()->create($request->validated());

        return redirect()->back();
    }

    public function update(Entry $entry, UpdateEntryRequest $request): RedirectResponse
    {
        Gate::authorize('update', $entry);

        $entry->update($request->validated());

        return redirect()->back();
    }

    public function destroy(Entry $entry): RedirectResponse
    {
        Gate::authorize('delete', $entry);

        $entry->delete();

        return redirect()->back();
    }
}
