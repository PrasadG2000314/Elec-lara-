<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\sliderController;
use App\Http\Controllers\admin\TestimonialController;
use App\Models\slider;
use App\Models\Testimonial;



Route::get('/', function () {
    $sliders=slider::all();
    $testimonials=Testimonial::all();
    return view('frontend.home',compact('sliders','testimonials' ));

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

require __DIR__.'/auth.php';
