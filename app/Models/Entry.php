<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\EntryFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Carbon $date
 * @property-read User $user
 * @property-read int $amount
 * @property-read string|null $friendly_date
 */
class Entry extends Model
{
    /** @use HasFactory<EntryFactory> */
    use HasFactory;

    protected $guarded = [];

    /**
     * @var string[]
     */
    protected $appends = ['friendly_date'];

    /**
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'date' => 'datetime',
            'amount' => 'int',
        ];
    }

    protected function friendlyDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->date->format('j M, Y \a\t h:i A'),
        );
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    /**
     * @return BelongsTo<User, Entry>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
