<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'link',
        'user_id',
        'quote_text',
        'sm_link',
        'duration',
        'tweet_info'
    ];

    public function screens()
    {
        return $this->belongsToMany(Screen::class, 'screens_attachments');
    }

    protected $casts = [
        'tweet_info' => 'array'
    ];
}
