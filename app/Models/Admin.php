<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\AdminPasswordResetNotification;

class Admin extends Authenticatable
{
    // We are using notifiable trait which will be used for password reset notification
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays. 
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
  
    // Once we have the reset token, we are ready to send the message out to this
    // Admin user with a link to reset their password. 
    // we will create adminpasswordresetnotification
    public function sendPasswordResetNotification($token){  
        
        $this->notify( new AdminPasswordResetNotification($token));
    }

        
    
}
