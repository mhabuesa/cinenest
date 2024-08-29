<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VisitorAuthController;
use App\Http\Middleware\VisitorMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/mvi/{url}', [FrontendController::class, 'movie_details'])->name('movie.details');
Route::get('/cat/{slug}', [FrontendController::class, 'category_view'])->name('category.view');
Route::get('/oscar', [FrontendController::class, 'oscar'])->name('oscar');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact/send', [FrontendController::class, 'contact_send'])->name('contact.send');
Route::get('/disclaimer', [FrontendController::class, 'disclaimer'])->name('disclaimer');
Route::get('/privacyPolicy', [FrontendController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('/search', [FrontendController::class, 'search'])->name('search');

Route::get('/download/{id}', [FrontendController::class, 'download'])->name('download');




Route::get('/signup', [FrontendController::class, 'signup'])->name('signup');
Route::get('/verification/{uniqueId}', [FrontendController::class, 'verification'])->name('verification');
Route::get('/signin', [FrontendController::class, 'signin'])->name('signin');
Route::get('/forget', [FrontendController::class, 'forget'])->name('forget');
Route::get('/forget/pass/{id}', [FrontendController::class, 'forget_pass'])->name('forget.pass');
Route::get('/passReset/{change_pass}', [FrontendController::class, 'pass_reset'])->name('pass.reset');
Route::get('/user/profile', [FrontendController::class, 'profile'])->middleware('visitor')->name('user.profile');



    //Group StoreController
    Route::controller(VisitorAuthController::class)->group(function(){
        Route::post('/visitor/store', 'visitor_store')->name('visitor.store');
        Route::post('/verify/{uniqueId}', 'verify')->name('verify');
        Route::post('/visitorSignin', 'signin')->name('visitor.signin');
        Route::get('/visitorLogout', 'visitor_logout')->name('visitor.logout');
        Route::post('/forgePass', 'forget_pass')->name('forgetPass');
        Route::post('/forgeCodeCheck/{id}', 'forget_code_check')->name('forgetCodeCheck');
        Route::post('/pass/changed/{change_pass}', 'pass_changed')->name('pass.changed');


        Route::post('/visitor/profileChange', 'profileChange')->name('profileChange');
        Route::post('/visitor/profilePassChange', 'profilePassChange')->name('profilePassChange');

    });

    //Group StoreController
    Route::controller(CommentController::class)->group(function(){
        Route::post('/comment/store','comment_store')->name('comment.store');
    });


    //Group StoreController
    Route::controller(FavoriteController::class)->group(function(){
        Route::post('/favorite_store','favorite_store')->name('favorite.store');
        Route::get('/favorite/{id}','favorite_toggle')->name('favorite.toggle');
    });

