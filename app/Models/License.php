<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $fillable=[
        "role_id",
        "access",
        "section"
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }
}
