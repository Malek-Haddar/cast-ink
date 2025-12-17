<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'podcast_id',
        'code',
        'is_used',
        'used_by',
    ];

    protected $casts = [
        'is_used' => 'boolean',
    ];

    public function podcast()
    {
        return $this->belongsTo(Podcast::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'used_by');
    }
}
