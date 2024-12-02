<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $fillable=[
        "role_id",
        "user_id"
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
    public $appends=["role_info","person"];
    
    public function getRoleInfoAttribute(){
        return $this->role;
    }       

    public function getPersonAttribute(){
        return $this->user->id;
    }

    
}
