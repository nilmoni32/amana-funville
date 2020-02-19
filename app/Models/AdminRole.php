<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{

    protected $table = 'admin_roles';

    protected $fillable = [
        'admin_id', 'role_name'
    ];

    protected $casts = [
        'admin_id' => 'integer'
    ];

    
}