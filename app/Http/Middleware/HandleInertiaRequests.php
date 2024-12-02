<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            
            
            
            'auth' => [
                'user' => $request->user(),
    
            ],
            "menu"=>[
                [
                    'name'=>'Categories',
                    'route'=>'category.index' ,
                    "show"=>$request->user() ? $request->user()->can("view",Category::class) : false ,
                    "active"=>Route::is("category.index") || Route::is("category.create") ||  Route::is("category.edit")
                ],
                [
                    'name'=>'Posts',
                    'route'=>'post.index',
                    "show"=>$request->user() ? $request->user()->can("view",Post::class) : false,
                    "active"=>Route::is("post.index") || Route::is("post.create") ||  Route::is("post.edit") 
                ]
            ],



            "crud"=>[
                "success"=>session("message"),
            ]
        ];

        
    }
}
