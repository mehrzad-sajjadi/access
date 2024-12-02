<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleUserRequest;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleUserController extends Controller
{
    public function create(User $user){
        $roles = Role::all();
        return Inertia::render("RoleUser/create",compact("roles","user"));
    }

    public function store(RoleUserRequest $roleUserRequest){
        $roleUser = new RoleUser();
        $roleUser->role_id = $roleUserRequest->role_id;        
        $roleUser->user_id = $roleUserRequest->user_id;
        $check = RoleUser::where("role_id",$roleUser->role_id)->where("user_id",$roleUser->user_id)->first();
        if($check){
            return redirect()->route("roleUser.create",$roleUser->user_id)->withErrors("این کاربر قبلا این نقش را دریافت کرده");
        }else{
            $roleUser->save();
            return redirect()->route("user.show",$roleUser->user_id)->with("message","نقش به فرد مورد نظر اضافه شد");
        }
    }
 
    public function delete($userId,$roleId){
        $roleUser = RoleUser::where("user_id",$userId)->where("role_id",$roleId)->first();
        $roleUser->delete();
        return Redirect()->route("user.show",$userId)->with("message","نقش از کاربر حذف شد");
    }
}
