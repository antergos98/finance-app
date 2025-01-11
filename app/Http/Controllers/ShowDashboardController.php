<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\User;
use Inertia\Response;

class ShowDashboardController
{
    public function __invoke(): Response
    {
        /** @var User $user */
        $user = auth()->user();

        $entries = $user
            ->entries()
            ->latest('date')
            ->limit(10)
            ->get()
            ->groupBy(fn (Entry $entry): string => $entry->date->isoFormat('ll'));

        return inertia()->render('Dashboard', [
            'entries' => $entries,
            'totalBalance' => $user->entries()->sum('amount') / 100,
        ]);
    }
}
