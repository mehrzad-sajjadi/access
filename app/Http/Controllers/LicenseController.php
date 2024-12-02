<?php

namespace App\Http\Controllers;

use App\Enums\Access;
use App\Enums\Section;
use App\Http\Requests\licenseRequest;
use App\Models\License;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LicenseController extends Controller
{

    public function create(Role $role){
        $accesses = Access::cases();    
        $sections = Section::cases();   
        return Inertia::render("License/create",compact("role","accesses","sections"));
    }
    public function store(licenseRequest $licenseRequest){
        $license = new License();
        $license->role_id = $licenseRequest->role_id;
        $license->access  = $licenseRequest->access;
        $license->section = $licenseRequest->section;
        $check = License::where("role_id",$license->role_id)->where("access",$license->access)->where("section",$license->section)->first();
        if($check){
            return Redirect()->route("license.create",$license->role_id)->withErrors("این نقش قبلا این دسترسی را دریافت کرده است");
        }else{
            $license->save();
            return Redirect()->route("role.show",$license->role_id)->with("message","دسترسی مورد نظر اضافه شد ");
        }

    }

    public function delete(License $license){
        $license->delete();
        return Redirect()->route("role.show",$license->role_id);
    }

}
