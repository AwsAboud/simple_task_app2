<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Priority extends Model
{
    protected $fillable = ['key', 'label', 'color'];
    
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
