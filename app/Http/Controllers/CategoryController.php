<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use App\Models\Category;
use App\Http\Requests\categoryRequest;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{
    public function index()
    {
        Gate::authorize("view",Category::class);
        $categories = Category::all()->map(function($record){
            $array = [];
            $array["id"]        = ["key"=>"id","type"=>"text","data"=>$record->id ] ;
            $array["name"]      = ["key"=>"name","data"=>$record->name,"type"=>"text"] ;
            $array["button"]    = [ "type"=>"button",
                                    "items"=>   [
                                        // ["data"=>route("category.show",$record->id)     ,  "method"=>"get"      ,"value"=>"نمایش"    , "type"=>"show"        ]
                                        ["data"=>route("category.axios")     ,  "method"=>"post"      ,"value"=>"نمایش"    , "type"=>"axios"        ]
                                    ],
                                ];
            return $array;
        });
        $header = ["id", "نام دسته بندی", "عملیات"];
        return Inertia::render("Category/index",compact("categories","header"));
    }
    
    public function showAxios(Request $request){
        Gate::authorize("view",Category::class);
        $title = Category::find($request->id);
        $posts=Post::where("category_id",$request->id)->get()->map(function($record){
            $array = [];
            $array["id"]        = ["key"=>"id","type"=>"text","data"=>$record->id ] ;
            $array["name"]      = ["key"=>"name","data"=>$record->name,"type"=>"text"] ;            
            return $array;
        })->toArray();        
        $title = " جزئیات دسته بندی ".$title->name;
        return ["content"=>$posts,"tableHeader"=>['id','نام'] ,"title"=>$title];
    }


    // public function show(Category $category)
    // {
    //     Gate::authorize("view",Category::class);
    //     $posts=Post::where("category_id",$category->id)->get()->map(function($record){
    //         $array = [];
    //         $array["id"]        = ["key"=>"id","type"=>"text","data"=>$record->id ] ;
    //         $array["name"]      = ["key"=>"name","data"=>$record->name,"type"=>"text"] ;            
    //         return $array;
    //     });
    //     $header = ["id","name"];
    //     return Inertia::render("Category/show",compact("posts","category","header"));
    
    // }


    
    public function create()
    {
        return Inertia::render('Category/create');
    }
    
    
    public function store(categoryRequest $categoryRequest)
    {
        $category=new Category();
        $category->name = $categoryRequest->name;
        $category->save();
        return redirect()->route("category.index")->with("message","دسته بندی با موفقیت ایجاد شد");
    }
    




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
    
        return Inertia::render("Category/edit",compact('category'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    
    public function update(categoryRequest $categoryStoreRequest,Category $category)
    {

        $category->name=$categoryStoreRequest->name;
        $check = $category->where("name",$category->name)->first();
        if($check){
            return redirect()->route("category.edit",$category->id);
        }else{
            $category->save();
            return redirect()->route("category.index")->with("message","دسته بندی مورد نظر ویرایش شد");    
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route("category.index")->with("message","دسته بندی مورد نظر حذف شد");;
    }
    

}
