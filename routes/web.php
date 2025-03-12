<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\sliderController;
use App\Http\Controllers\admin\SettingsController;
use App\Http\Controllers\admin\PostsController;
use App\Http\Controllers\admin\TestimonialController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Middleware\TimeRestrictedAccess;
use App\Http\Middleware\ROLE_SUPER_ADMIN;
use App\Http\Middleware\ROLE_ADMIN;
use App\Http\Middleware\ROLE_USER;
use App\Http\Middleware\ROLE_GUEST;
use App\Http\Middleware\ROLE_SUPER_USER;
use App\Models\slider;
use App\Models\Testimonial;
use App\Models\Posts;
use App\Models\Settings;



define('ROLE_SUPER_ADMIN', 'role:super-admin');


Route::get('/', function () {
    $sliders=slider::all();
    $testimonials=Testimonial::all();
    return view('frontend.home',compact('sliders','testimonials' ));

});

Route::get('/about', function () {
    return view('frontend.about');
});

Route::get('/service', function () {
    return view('frontend.service');
})->middleware([TimeRestrictedAccess::class]);


Route::get('/blog', function () {
    $posts = Posts::orderBy('created_at','desc')->paginate(6);

    return view('frontend.blog',compact('posts'));
});

Route::get('/contact', function () {
    return view('frontend.contact');
});

Route::get('/blog/{slug}', function ($slug) {
    $post = Posts::where('slug', $slug)->first();
    return view('frontend.post-single',compact('post'));
});

Route::get('/dashboard', function () {
    return view('admin.layouts.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    $profileRoute = '/profile';
    Route::get($profileRoute, [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch($profileRoute, [ProfileController::class, 'update'])->name('profile.update');
    Route::delete($profileRoute, [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(sliderController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('/sliderIndex', 'index')->name('slider.index');
    Route::post('/saveSlider', 'storeslider')->name('slider.store');
    Route::post('/sliderUpdate','updateslider')->name('slider.update');
    Route::get('/deleteSlider/{id}','deleteslider')->name('slider.delete');
});
Route::controller(TestimonialController::class)->middleware(['auth','verified'])->group(function (){
    Route::get('/TestimonialIndex','Index')->name('Testimonial.index');
    Route::post('/saveTestimonial','storeTestimonial')->name('Testimonial.store');
    Route::post('/TestimonialUpdate','updateTestimonial')->name('Testimonial.update');
    Route::get('/deleteTestimonial/{id}','deleteTestimonial')->name('Testimonial.delete');
});

Route::controller(SettingsController::class)->middleware(['auth','verified'])->group(function (){
    Route::get('/settings','index')->name('settings');
    Route::post('/settingUpdate','update')->name('settings.update');
 });

 Route::controller(PostsController::class)->middleware(['auth','verified'])->group(function (){

    Route::get('/postIndex','index');
    Route::post('/savePost','storepost')->name('post.store');
    Route::post('/postUpdate','updatepost')->name('post.update');
    Route::get('/deletePost/{id}','deletepost')->name('post.delete');

 });

 Route::controller(PermissionController::class)->middleware(['auth','verified'])->group(function (){

    Route::get('/permissionIndex','index');
    Route::post('/savePermission','storepermission')->name('permission.store');
    Route::get('/deletePermission/{id}','deletepermission')->middleware([ROLE_SUPER_ADMIN])->name('permission.delete');
    Route::post('/permissionUpdate','updatepermission')->name('permission.update');
    Route::get('/deletePermission/{id}','deletepermission')->middleware(['role:super-admin'])->name('permission.delete');
 });


 Route::controller(RoleController::class)->middleware(['auth','verified'])->group(function (){

    Route::get('/roleIndex','index');
    Route::get('/deleteRole/{id}','deleterole')->middleware([ROLE_SUPER_ADMIN])->name('role.delete');
    Route::post('/roleUpdate','updaterole')->name('role.update');
    Route::get('/deleteRole/{id}','deleterole')->middleware(['role:super-admin'])->name('role.delete');

    Route::get('/permissionToRole/{id}','givePermissionToRole')->name('role.givePermissionToRole');
    Route::put('/givePermissionToRole/{id}','giveRoleToPermission')->name('role.giveRoleToPermission');
 });

 Route::controller(UserController::class)->middleware(['auth','verified','role:super-admin|admin'])->group(function (){

    Route::get('/userIndex','index');
    Route::get('/deleteUser/{id}','deleteuser')->middleware([ROLE_SUPER_ADMIN])->name('user.delete');
    Route::post('/userUpdate','updateuser')->name('user.update');
    Route::get('/deleteUser/{id}','deleteuser')->middleware(['role:super-admin'])->name('user.delete');
 });
require __DIR__.'/auth.php';
