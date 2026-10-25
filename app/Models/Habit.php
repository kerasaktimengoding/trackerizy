<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Habit extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'icon',
        'color',
        'target_per_day',
        'is_active',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(HabitLog::class);
    }

    public function isCompletedToday(): bool
    {
        return $this->logs()
            ->where('date', now()->toDateString())
            ->where('completed', true)
            ->exists();
    }

    public function currentStreak(): int
    {
        $streak = 0;
        $checkDate = now();

        if (!$this->isCompletedToday()) {
            $checkDate = now()->subDay();
        }

        while (true) {
            $hasLog = $this->logs()
                ->where('date', $checkDate->toDateString())
                ->where('completed', true)
                ->exists();

            if ($hasLog) {
                $streak++;
                $checkDate->subDay();
            } else {
                break;
            }
        }

        return $streak;
    }
}
