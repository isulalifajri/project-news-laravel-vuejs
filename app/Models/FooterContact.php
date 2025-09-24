<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterContact extends Model
{
    protected $fillable = ['type','label','value','icon','is_active'];
}
