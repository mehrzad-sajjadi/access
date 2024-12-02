<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\RoleUser;
use Redirect;
use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\RoleUserController;
use function Laravel\Prompts\select;


class RoleController extends Controller
{
    public function index(){
        
        
        $roles = Role::select("id","name")->get()->map(function($record) {
            $users = RoleUser::where("role_id",$record->id)->count();
            $licenses = License::where("role_id",$record->id)->count();
            $array =[];

            $array["name"]          = ["type"=>"text","data"=>$record->name];
            $array["user_num"]      = ["type"=>"text","data"=>$users];
            $array["aceess_num"]    = ["type"=>"text","data"=>$licenses];
            
            $array["button"]    = [ "type"=>"button",
                                    "items"=>[
                                        ["data"=>route("role.show",$record->id)     ,  "method"=>"get"      ,"value"=>"نمایش"           , "type"=>"show"        ],
                                        ["data"=>route("role.delete",$record->id)   ,  "method"=>"delete"   ,"value"=>"حذف"             , "type"=>"delete"      ],
                                    ],
                                ];

            return $array;
        });

        return Inertia::render("Role/index",compact("roles"));
    }
    public function create(){
        
        return Inertia::render("Role/create");
    }
    public function store(Request $request){
        $request->validate(["name"=>["required","string","unique:roles"]]);
        $role = new Role();
        $role->name = $request->name;

        $role->save();
        return Redirect()->route("role.index")->with("message","نقش مورد نظر اضافه شد ");
    
    }

    public function show(Role $role){
        $licenses = License::where("role_id",$role->id)->get()->map(function($record){

            $array["access"]      = ["type"=>"text","data"=>$record->access]    ;
            $array["section"]     = ["type"=>"text","data"=>$record->section]   ;
            $array["button"]    = [ "type"=>"button",
                                    "items"=>[
 
                                        ["data"=>route("role.delete",$record->id)   ,  "method"=>"delete"   ,"value"=>"حذف"             , "type"=>"delete"      ],

                                    ],
                                ];

            return $array;
        });
        return Inertia::render("Role/show",compact("licenses","role"));
    }
    public function delete(Role $role){
        $check = RoleUser::where("role_id",$role->id)->first();
        
        if($check){
            return redirect()->route("role.index")->withErrors("این نقش دارای عضو میباشد");
        }else{
            $role->delete();
            return redirect()->route("role.index")->with("message","نقش مورد نظر حذف شد");
        }
    }



}
