<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarCategoryController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\DonatieController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SearchCarController;
use App\Http\Controllers\TicketController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

RateLimiter::for('testing', function (Request $request) {
    return Limit::perMinute(3000);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['middleware' => ['cors', 'json.response', 'throttle:testing']], function () {
    Route::post('user/login', [AuthController::class, 'login'])->name('login.api');
    Route::post('user/register', [AuthController::class, 'register'])->name('register.api');
    Route::get('user/auth', [AuthController::class, 'checkAuth'])->name('auth.api');
    Route::get('/car', [CarController::class, 'index'])->name('car');
    Route::get('/car/{id}', [CarController::class, 'get'])->name('car');
    Route::get('/organizations', [OrganizationController::class, 'index'])->name('organization');
    Route::get('/search/{search}', [SearchCarController::class, 'search'])->name('search');
    Route::get('/event', [EventController::class, 'index'])->name('event');
    Route::get('/event/{id}', [EventController::class, 'get'])->name('event');
});
Route::group(['middleware' => ['cors', 'json.response', 'throttle:testing', 'auth:api']], function () {
    // our routes to be protected will go in here
    //user
    Route::post('user/logout', [AuthController::class, 'logout'])->name('logout.api');
    Route::get('user', function (Request $request) {
        $user = $request->user();
        $id = $user["id"];
        return $user->with("roles")->findorFail($id);
    });
    Route::get('/usertickets', [TicketController::class, 'indexuser'])->name('ticket');

    //cars
    Route::post('/car/create', [CarController::class, 'create'])->name('car');
    Route::put('/car/{id}/edit', [CarController::class, 'edit'])->name('car');
    Route::delete('/car/{id}/delete', [CarController::class, 'delete'])->name('car');
    Route::get('/categories', [CarCategoryController::class, 'get'])->name('car_categories');

    //tickets
    Route::post('/ticket/create', [TicketController::class, 'create'])->name('ticket');
    Route::get('/ticket', [TicketController::class, 'index'])->name('ticket');
    Route::get('/ticket/{id}', [TicketController::class, 'get'])->name('ticket');
    Route::put('/ticket/{id}/edit', [TicketController::class, 'edit'])->name('ticket');
    Route::put('/ticket/{id}/status', [TicketController::class, 'editStatus'])->name('ticket');
    Route::delete('/ticket/{id}/delete', [TicketController::class, 'delete'])->name('ticket');

    //jobs
    Route::get('/job', [JobController::class, 'index'])->name('job');
    Route::get('/job/{id}', [JobController::class, 'get'])->name('job');
    Route::post('/job/create', [JobController::class, 'create'])->name('job');
    Route::delete('/job/{id}/delete', [JobController::class, 'delete'])->name('job');
    Route::get('/organization/{id}', [OrganizationController::class, 'get'])->name('organization');

    //donaties
    Route::get('/donatie', [DonatieController::class, 'index'])->name('donatie');
    Route::get('/userdonatie', [DonatieController::class, 'indexuser'])->name('donatie');
    Route::post('/donatie/create', [DonatieController::class, 'create'])->name('donatie');

    //events
    Route::post('/event/create', [EventController::class, 'create'])->name('event');
});
