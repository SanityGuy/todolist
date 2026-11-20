<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = ['title', 'notes', 'is_completed'];

    protected function casts(): array
    {
        return ['is_completed' => 'boolean'];
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
