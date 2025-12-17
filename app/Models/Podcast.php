<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Episodes relation
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    // Users who have access
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_podcast_accesses');
    }

    // Access codes
    public function accessCodes()
    {
        return $this->hasMany(AccessCode::class);
    }
}
