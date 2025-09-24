<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BackendUser extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasFactory;

    protected $guard_name = 'backend';
    protected $fillable = ['name','email','password'];
}
