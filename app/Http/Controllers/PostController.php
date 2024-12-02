<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\postRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    
    public function index()
    {
        Gate::authorize("view",Post::class);
        if (auth()->user()->can('delete',Post::class)) {
            $deleteBtn =true;           
        }else{
            $deleteBtn = false;
        }
        if (auth()->user()->can('update',Post::class)) {
            $updateBtn = true ;
        }else{
            $updateBtn = false ;
        }
        
        $posts = Post::all()->map(function($record)use($deleteBtn,$updateBtn){
            if($updateBtn==true){
                $updateBtn =  ["data"=>route("post.edit",$record->id)     ,  "method"=>"get"      ,"value"=>"ویرایش"    , "type"=>"edit"        ] ;
            }else{
                $updateBtn =[];
            }
            if($deleteBtn==true){
                $deleteBtn =  ["data"=>route("post.delete",$record->id)     ,  "method"=>"delete"      ,"value"=>"حذف"    , "type"=>"delete"     ];
            }else{
                $deleteBtn=[];
            }
            $array = [];
            
            $array["id"]        = ["key"=>"id","type"=>"text","data"=>$record->id ] ;
            $array["name"]      = ["key"=>"name","data"=>$record->name,"type"=>"text", ] ;
            $array["button"]    = [ "type"=>"button",
                                    "items"=>   [
                                        $updateBtn,
                                        $deleteBtn                                    
                                    ],
                                ];
            return $array;                                
        });

        return Inertia::render("Post/index",compact("posts"));
    }
    
    
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize("view",Post::class);
        Gate::authorize("create",Post::class);

        $categories = Category::all();
        return Inertia::render('Post/create',compact("categories"));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    
     public function store(postRequest $postRequest)
    {
        Gate::authorize("create",Post::class);

        $post=new Post();
        $post->name = $postRequest->name;
     
        $post->category_id = $postRequest->category_id;
        
        $check=Post::where("name",$post->name)->where("category_id",$post->category_id )->first();
        if($check){
            return redirect()->route("post.create")->withErrors("پست مورد نظر قبلا با همین نام و نوع دسته بندی ایجاد شده ");
        }else{
            $post->save();
            return redirect()->route("post.index")->with("message","پست مورد نظر ایجاد شد");
        }
    }
    
    
    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {   
        Gate::authorize("view",Post::class);

        $category_post = $post->category->name;
        return Inertia::render("post/show",compact("category_post","post"));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize("view",Post::class);

        $categories = Category::all();
        return Inertia::render("Post/edit",compact("categories","post"));
    }
    
    /**
     * Update the specified resource in storage.
     */
    
    public function update(postRequest $postRequest,Post $post)
    {
        Gate::authorize("update",Post::class);

        $post->name = $postRequest->name;
        $post->category_id = $postRequest->category_id;
        
        $post->save();
        return redirect()->route("post.index")->with("message","پست مورد نظر ویرایش شد");
    }
    

    public function delete(Post $post)
    {
        Gate::authorize("view",Post::class);        
        Gate::authorize("delete",Post::class);

        $post->delete();

        return redirect()->route("post.index")->with("message","پست مورد نظر حذف شد");;
    }
}
