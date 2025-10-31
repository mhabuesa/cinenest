<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MetaConfigController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SupperHitController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware('auth', 'verified')->name('dashboard');

// category
Route::get('/category', [CategoryController::class, 'category'])->middleware('auth', 'verified')->name('category');
Route::post('/category/store', [CategoryController::class, 'category_store'])->name('category.store');
Route::get('/category/delete/{id}', [CategoryController::class, 'category_delete'])->name('category.delete');
Route::post('/category/update/{id}', [CategoryController::class, 'category_update'])->name('category.update');

// Movies
Route::get('/movie_add', [MovieController::class, 'movie_add'])->middleware('auth', 'verified')->name('movie.add');
Route::post('/movie_store', [MovieController::class, 'movie_store'])->name('movie.store');
Route::get('/movie_list', [MovieController::class, 'movie_list'])->middleware('auth', 'verified')->name('movie.list');
Route::get('/movie/delete/{id}', [MovieController::class, 'movie_delete'])->name('movie.delete');
Route::get('/movie_edit/{id}', [MovieController::class, 'movie_edit'])->middleware('auth', 'verified')->name('movie.edit');
Route::get('/prev/link/del/{id}', [MovieController::class, 'prev_link_del'])->name('prev.link.del');
Route::post('/movie_update/{id}', [MovieController::class, 'movie_update'])->name('movie.update');

Route::get('/pendingList', [MovieController::class, 'pendinglist'])->middleware('auth', 'verified')->name('pending.list');
Route::get('/approve/{movie}', [MovieController::class, 'approve'])->middleware('auth', 'verified')->name('movie.approve');
Route::post('/reject/{movie}', [MovieController::class, 'reject'])->middleware('auth', 'verified')->name('movie.reject');
Route::get('/rejectedList', [MovieController::class, 'rejected_list'])->middleware('auth', 'verified')->name('rejected.list');
Route::get('/approvalReq/{movie}', [MovieController::class, 'approval_req'])->middleware('auth', 'verified')->name('approval.req');
Route::get('/movie/per/delete/{id}', [MovieController::class, 'movie_per_delete'])->name('movie.per.delete');

Route::get('/screenshort/delete/{id}', [MovieController::class, 'screenshort_delete'])->name('screenshort.delete');
Route::get('/screenshortLink/delete/{id}', [MovieController::class, 'screenshortLink_delete'])->name('screenshort.link.delete');


//Features
Route::get('/features', [FeatureController::class, 'features'])->middleware('auth', 'verified')->name('features');
Route::post('/oscar/status', [FeatureController::class, 'oscar_status'])->name('oscar.status');
Route::post('/supper/status', [FeatureController::class, 'supper_status'])->name('supper.status');

//Features
Route::get('/message', [MessageController::class, 'message'])->middleware('auth', 'verified')->name('message');
Route::get('/message/read/{id}', [MessageController::class, 'message_read'])->middleware('auth', 'verified')->name('message.read');
Route::get('/message/delete/{id}', [MessageController::class, 'message_delete'])->middleware('auth', 'verified')->name('message.delete');

// Meta Config
Route::get('/configMeta', [MetaConfigController::class, 'configMeta'])->middleware('auth', 'verified')->name('configMeta');
Route::post('/configMeta/update', [MetaConfigController::class, 'configMeta_update'])->name('configMeta.update');

// Users
Route::get('/users', [UsersController::class, 'users'])->middleware('auth', 'verified')->name('users');
Route::post('/users/store', [UsersController::class, 'users_store'])->name('users.store');
Route::get('/users/edit/{id}', [UsersController::class, 'users_edit'])->middleware('auth', 'verified')->name('users.edit');
Route::post('/users/update/{id}', [UsersController::class, 'users_update'])->name('users.update');
Route::get('/users/delete/{id}', [UsersController::class, 'users_delete'])->name('users.delete');

// Profile
Route::get('/profile',[ProfileController::class, 'profile'])->middleware('auth', 'verified')->name('profile');
Route::get('/profile/setting',[ProfileController::class, 'profile_setting'])->middleware('auth', 'verified')->name('profile.setting');
Route::post('/profile/settings/update',[ProfileController::class, 'profile_settings_update'])->name('profile.settings.update');

Route::get('/profile/security',[ProfileController::class, 'profile_security'])->middleware('auth', 'verified')->name('profile.security');
Route::post('/profile/security/update',[ProfileController::class, 'profile_security_update'])->name('profile.security.update');

// Comment
Route::get('/Comments',[CommentController::class, 'comments'])->middleware('auth', 'verified')->name('comments');
Route::post('/reply/store/{id}',[CommentController::class, 'reply_store'])->middleware('auth', 'verified')->name('reply.store');


Route::get('/unauthorized',[HomeController::class, 'unauthorized'])->middleware('auth', 'verified')->name('unauthorized');
Route::get('/activityLog',[HomeController::class, 'activityLog'])->middleware('auth', 'verified')->name('activityLog');

Route::get('/payout',[PointController::class, 'payout'])->middleware('auth', 'verified')->name('payout');
Route::post('/payoutRequest',[PointController::class, 'payoutRequest'])->name('payoutRequest');
Route::get('/payment',[PointController::class, 'payment'])->middleware('auth', 'verified')->name('payment');
Route::post('/rate/update/{id}',[PointController::class, 'rate_update'])->name('rate.update');
Route::post('/pay/{id}',[PointController::class, 'pay'])->name('pay');



Route::get('/role',[RoleController::class, 'role'])->middleware('auth', 'verified')->name('role');
Route::post('/permission/store',[RoleController::class, 'permission_store'])->name('permission.store');
Route::post('/role/store',[RoleController::class, 'role_store'])->name('role.store');

Route::get('/role/delete/{id}',[RoleController::class, 'role_delete'])->middleware('auth', 'verified')->name('role.delete');
Route::get('/role/edit/{id}',[RoleController::class, 'role_edit'])->middleware('auth', 'verified')->name('role.edit');
Route::post('/permission/update/{id}',[RoleController::class, 'permission_update'])->name('permission.update');

Route::post('/role/assign',[RoleController::class, 'role_assign'])->name('role.assign');
Route::get('/role/remove/{id}',[RoleController::class, 'role_remove'])->name('role.remove');


Route::get('/todoList',[TodoController::class, 'todo_list'])->middleware('auth', 'verified')->name('todo.list');
Route::post('/todo/store',[TodoController::class, 'todo_store'])->name('todo.store');
Route::get('/todo/assign/{id}',[TodoController::class, 'todo_assign'])->middleware('auth', 'verified')->name('todo.assign');
Route::get('/todo/complete/{id}',[TodoController::class, 'todo_complete'])->middleware('auth', 'verified')->name('todo.complete');
Route::get('/todo/delete/{id}',[TodoController::class, 'todo_delete'])->middleware('auth', 'verified')->name('todo.delete');


Route::get('/clear_cache', [HomeController::class, 'clearCache'])->middleware('auth', 'verified')->name('clear.cache');

Route::get('/sitemap.xml',[HomeController::class, 'sitemap'])->name('sitemap');
Route::get('/sitemap/reload',[HomeController::class, 'sitemap_reload'])->name('sitemap.reload');

