<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'location',
        'has_message_bar',
        'presentation_mode',
        'user_id',
        'color_1',
        'color_2',
        'color_3',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'screens_attachments');
    }

    public function messages()
    {
        return $this->belongsToMany(Message::class, 'screens_messages');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}