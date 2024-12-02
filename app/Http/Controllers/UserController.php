<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Doctrine\Inflector\Rules\English\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;


class UserController extends Controller
{
    public function index(){
        Gate::authorize('view',User::class);
        $users = User::all()->map(function($record){
            $array = [];
            $array["id"]        = ["key"=>"id","type"=>"text","data"=>$record->id ] ;
            $array["name"]      = ["key"=>"name","data"=>$record->name,"type"=>"text", ] ;
            $array["email"]     = ["key"=>"email","data"=>$record->email,"type"=>"text" ];
            $array["button"]    = [ "type"=>"button",
                                    "items"=>[
                                        ["data"=>route("user.show",$record->id)   ,  "method"=>"get"    ,"value"=>"نمایش"       ,  "type"=>"show" ]
                                    ],
                                ];
            return $array;
        });

        $header = ["id", "نام", "ایمیل", "عملیات"];
        return Inertia::render("User/index",compact("users","header"));
    }

    public function axios(Request $request){
        $roles = RoleUser::where("user_id",$request->id)->get()->pluck("role_info")->map(function($record)use($request){
            $array=[];
            $array["id"]        = [ "key"=>"id","type"=>"text","data"=>$record->id ] ;
            $array["name"]      = [ "key"=>"name","data"=>$record->name,"type"=>"text" ] ;
            $array["button"]    = [ "type"=>"button",
                                    "items"=>[
                                        ["data"=>route("role.show",$record->id)     ,  "method"=>"get"      ,"value"=>"نمایش دسترسی ها"           , "type"=>"show"        ],
                                        ["data"=>route("roleUser.delete",[$request->id,$record->id])   ,  "method"=>"delete"    ,"value"=>"حذف"       ,  "type"=>"delete" ],
                                    ],
                                ];  
            return $array;
        })->toArray();
        return $roles;
    }




    public function create(){
        Gate::authorize('view',User::class);
        return Inertia::render("User/create");
    }

    public function store(Request $request)
    {
        Gate::authorize('create',User::class);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed'],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        event(new Registered($user));
        return redirect()->route("user.index");
    }

    public function show(User $user){
        $roles = RoleUser::where("user_id",$user->id)->get()->pluck("role_info")->map(function($record)use($user){
            $array=[];
            $array["id"]        = [ "key"=>"id","type"=>"text","data"=>$record->id ] ;
            $array["name"]      = [ "key"=>"name","data"=>$record->name,"type"=>"text" ] ;
            $array["button"]    = [ "type"=>"button",
                                    "items"=>[
                                        ["data"=>route("role.show",$record->id)     ,  "method"=>"get"      ,"value"=>"نمایش دسترسی ها"           , "type"=>"show"        ],
                                        ["data"=>route("roleUser.delete",[$user->id,$record->id])   ,  "method"=>"delete"    ,"value"=>"حذف"       ,  "type"=>"delete" ],
                                    ],
                                ];  
            return $array;
        });

        
        return Inertia::render("User/show",compact("roles","user"));

    }
    

    public function delete(User $user){        
        // Gate::authorize('delete',User::class);
        $user->delete();
        return redirect()->route("user.index");
    }
}
