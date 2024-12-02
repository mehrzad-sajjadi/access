<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\License;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        
        $roleUsers = RoleUser::where("user_id",$user->id)->get()->pluck("role-info")->select("id")->toArray();
        $licenses = License::whereIn("role_id",$roleUsers )->get();
        foreach($licenses as $license){
            if(($license->access=="READ" && $license->section=="CATEGORY" ) || $user->is_admin==1){
                return true;
            }
        }
        return false;

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $roleUsers = RoleUser::where("user_id",$user->id)->get()->pluck("role-info")->select("id")->toArray();
        $licenses = License::whereIn("role_id",$roleUsers )->get();
        foreach($licenses as $license){
            if(($license->access=="CREATE" && $license->section=="CATEGORY" ) || $user->is_admin==1){
                return true;
            }
        }
        return false;

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category): bool
    {
        $roleUsers = RoleUser::where("user_id",$user->id)->get()->pluck("role-info")->select("id")->toArray();
        $licenses = License::whereIn("role_id",$roleUsers )->get();
        foreach($licenses as $license){
            if(($license->access=="UPDATE" && $license->section=="CATEGORY" ) || $user->is_admin==1){
                return true;
            }
        }
        return false;

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category): bool
    {
        $roleUsers = RoleUser::where("user_id",$user->id)->get()->pluck("role-info")->select("id")->toArray();
        $licenses = License::whereIn("role_id",$roleUsers )->get();
        foreach($licenses as $license){
            if(($license->access=="DELETE" && $license->section=="CATEGORY" ) || $user->is_admin==1){
                return true;
            }
        }
        return false;

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Category $category): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Category $category): bool
    {
        //
    }
}