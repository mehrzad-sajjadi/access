<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable=[
        "name",
    ];
    // public function license(){
    //     return $this->hasMany(License::class);
    // }

    // public $appends=["license_info"];

    // public function getLicenseInfoAttribute(){
    //     return $this->license;
    // }



}
