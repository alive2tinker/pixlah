<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function screens()
    {
        return $this->hasMany(Screen::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function thumbnail()
    {
        $initals = substr(explode(' ', $this->name)[0],0,1)
            . substr(explode(' ', $this->name)[1], 0,1);
        return "f8712a/FFFFFF/?text=" . $initals;
    }
}
