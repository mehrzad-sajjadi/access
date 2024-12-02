<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::prefix("/user")->middleware(["auth","verified",IsAdmin::class])->group(function(){
    Route::get("/",[UserController::class,"index"])->name("user.index");
    Route::get("/create",[UserController::class,"create"])->name("user.create");
    Route::post("/",[UserController::class,"store"])->name("user.store");
    Route::delete("/{user}/delete",[UserController::class,"delete"])->name("user.delete");
    Route::get("/{user}/show",[UserController::class,"show"])->name("user.show");
    Route::get("/{user}/add",[RoleUserController::class,"create"])->name("roleUser.create");
    Route::delete("/{user}/{role}/delete",[RoleUserController::class,"delete"])->name("roleUser.delete");

    Route::post("axios",[UserController::class,"axios"])->name("user.ax");
});

Route::prefix("role")->middleware(["auth","verified",IsAdmin::class])->group(function(){
    Route::get("/",[RoleController::class,"index"])->name("role.index");
    Route::get("/create",[RoleController::class,"create"])->name("role.create");
    Route::post("/",[RoleController::class,"store"])->name("role.store");    
    Route::get("/{role}/show",[RoleController::class,"show"])->name("role.show");
    Route::delete("/{role}/delete",[RoleController::class,"delete"])->name("role.delete");    
});

Route::prefix("roleUser")->middleware(["auth","verified",IsAdmin::class])->group(function(){
    Route::post("/",[RoleUserController::class,"store"])->name("roleUser.store");

}); 

Route::prefix("license")->middleware(["auth","verified",IsAdmin::class])->group(function(){
    Route::get("/{role}/create",[LicenseController::class,"create"])->name("license.create");
    Route::post("/",[LicenseController::class,"store"])->name("license.store");
    Route::delete("/{license}/delete",[LicenseController::class,"delete"])->name("license.delete");

}); 



Route::prefix("category")->middleware(['auth', 'verified'])->group(function(){
    Route::get("/",[CategoryController::class,'index'])->name("category.index");
    Route::delete("/{category}/delete",[CategoryController::class,'delete'])->name("category.delete");
    Route::get("/{category}/show",[CategoryController::class,'show'])->name("category.show");
    Route::get("/{category}/edit",[CategoryController::class,'edit'])->name("category.edit");
    Route::put("/{category}/update",[CategoryController::class,'update'])->name("category.update");
    Route::get("/create",[CategoryController::class,'create'])->name("category.create");
    Route::post("/",[CategoryController::class,'store'])->name("category.store");
    Route::post("/axios",[CategoryController::class,'showAxios'])->name("category.axios");

}); 

Route::prefix("post")->middleware(['auth', 'verified'])->group(function(){
    Route::get("/",[PostController::class,'index'])->name("post.index");
    Route::delete("/{post}/delete",[PostController::class,'delete'])->name("post.delete");
    Route::get("/{post}/show",[PostController::class,'show'])->name("post.show");
    Route::get("/{post}/edit",[PostController::class,'edit'])->name("post.edit");
    Route::put("/{post}/update",[PostController::class,'update'])->name("post.update");
    Route::get("/create",[PostController::class,'create'])->name("post.create");
    Route::post("/",action: [PostController::class,'store'])->name("post.store");
});





Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
