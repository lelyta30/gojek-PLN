<?php

use App\Http\Controllers\CleaningController;
use App\Http\Controllers\DriverController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\RequestController;

use App\Http\Controllers\Technician\TechnicianDashboardController;
use App\Http\Controllers\Technician\FollowedUpRequestController;
use App\Http\Controllers\Technician\BreakTypeController;
use App\Http\Controllers\Technician\ComputerController;
use App\Http\Controllers\Technician\DepartmentController;
use App\Http\Controllers\Technician\UserController;

use App\Http\Controllers\Manager\ManagerDashboardController;
use App\Http\Controllers\Manager\VerifiedRequestController;
use App\Http\Controllers\Manager\TechnicianController;
use App\Http\Controllers\SecurityController;
use SebastianBergmann\CodeCoverage\Driver\Driver;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false, 'reset' => false]);

Route::prefix('/')
    ->get('/', [UserDashboardController::class, 'index'])
    ->middleware(['auth', 'which.home'])
    ->name('user.dashboard');

Route::prefix('/')
    ->middleware(['auth', 'is.user'])
    ->group(function(){
        Route::get('/profile', [UserDashboardController::class, 'profile'])
        ->name('user.profile');
        Route::get('/request', [RequestController::class, 'index'])
        ->name('user.request');
        Route::get('/request/json', [RequestController::class, 'json'])
        ->name('user.request.json');
        Route::get('/request/daftar-pekerja', [RequestController::class, 'listPekerja'])
        ->name('user.request.daftarpekerja');
        Route::get('/request/pekerjajson', [RequestController::class, 'dataPekerja'])
        ->name('user.request.pekerjajson');
        Route::get('/request/create', [RequestController::class, 'create'])
        ->name('user.request.create');
        Route::get('/request/edit/{id}', [RequestController::class, 'edit'])
        ->name('user.request.edit');
        Route::post('/request/update/{id}', [RequestController::class, 'update'])
        ->name('user.request.update');
        Route::get('/request/show/{id}', [RequestController::class, 'show'])
        ->name('user.request.show');
        Route::post('/request/store', [RequestController::class, 'store'])
        ->name('user.request.store');
        Route::get('/request/print/{id}', [RequestController::class, 'printPreview'])
        ->name('user.request.print');
        Route::get('/request/cancel/{id}', [RequestController::class, 'cancel'])
        ->name('user.request.cancel');
        Route::get('/request/finish/{id}', [RequestController::class, 'finish'])
        ->name('user.request.finish');
        Route::get('/request/delete/{id}', [RequestController::class, 'destroy'])
        ->name('user.request.delete');
        Route::post('/request/rating/{id}', [RequestController::class, 'rating'])
        ->name('user.request.rating');
        Route::get('/profile', [RequestController::class, 'profile'])
        ->name('user.profile');
        Route::post('/store-profile', [RequestController::class, 'profilestore'])
        ->name('user.storeprofile');

        Route::get('/dropdown', [RequestController::class, 'DropdownRole'])->name('user.request.dropdown');
        Route::post('/api/fetch-dropdown/{role}', [RequestController::class, 'getRole'])->name('user.request.dropdown.getRole');
    });

Route::prefix('t')
    ->middleware(['auth', 'is.technician'])
    ->group(function(){
        Route::get('/', [TechnicianDashboardController::class, 'index'])
        ->name('technician.dashboard');
        Route::get('/profile', [TechnicianDashboardController::class, 'profile'])
        ->name('technician.profile');
        Route::post('/store-profile', [TechnicianDashboardController::class, 'profilestore'])
        ->name('technician.storeprofile');

        Route::get('/f-up-request', [FollowedUpRequestController::class, 'index'])
        ->name('technician.f-up-request');
        Route::get('/f-up-request/json', [FollowedUpRequestController::class, 'json'])
        ->name('technician.f-up-request.json');
        Route::get('/f-up-request/show/{id}', [FollowedUpRequestController::class, 'show'])
        ->name('technician.f-up-request.show');
        Route::get('/f-up-request/accept/{id}', [FollowedUpRequestController::class, 'accept'])
        ->name('technician.f-up-request.accept');
        Route::get('/f-up-request/cancel/{id}', [FollowedUpRequestController::class, 'cancel'])
        ->name('technician.f-up-request.cancel');
        Route::get('/f-up-request/finish/{id}', [FollowedUpRequestController::class, 'finish'])
        ->name('technician.f-up-request.finish');
        Route::get('/f-up-request/edit/{id}', [FollowedUpRequestController::class, 'edit'])
        ->name('technician.f-up-request.edit');
        Route::put('/f-up-request/update/{id}', [FollowedUpRequestController::class, 'update'])
        ->name('technician.f-up-request.update');
        Route::get('/f-up-request/reject/{id}', [FollowedUpRequestController::class, 'reject'])
        ->name('technician.f-up-request.reject');

        Route::get('/computer/json', [ComputerController::class, 'json'])
        ->name('computer.json');

        Route::get('/user/json', [UserController::class, 'json'])
        ->name('user.json');

        Route::resources([
            'break-type'    => BreakTypeController::class,
            'computer'      => ComputerController::class,
            'department'    => DepartmentController::class,
            'user'          => UserController::class
        ]);
    });

Route::prefix('d')
    ->middleware(['auth', 'is.driver'])
    ->group(function(){
        Route::get('/', [DriverController::class, 'index'])
        ->name('driver.dashboard');
        Route::get('/profile', [DriverController::class, 'profile'])
        ->name('driver.profile');
        Route::post('/store-profile', [DriverController::class, 'profilestore'])
        ->name('driver.storeprofile');

        Route::get('/request/show/{id}', [DriverController::class, 'show'])
        ->name('driver.request.show');
        Route::get('/request/accept/{id}', [DriverController::class, 'accept'])
        ->name('driver.request.accept');
        Route::get('/request/cancel/{id}', [DriverController::class, 'cancel'])
        ->name('driver.request.cancel');
        Route::get('/request/finish/{id}', [DriverController::class, 'finish'])
        ->name('driver.request.finish');
        Route::get('/request/reject/{id}', [DriverController::class, 'reject'])
        ->name('driver.request.reject');

        // Route::get('/f-up-request', [FollowedUpRequestController::class, 'index'])
        // ->name('technician.f-up-request');
        // Route::get('/f-up-request/json', [FollowedUpRequestController::class, 'json'])
        // ->name('technician.f-up-request.json');
        // Route::get('/f-up-request/show/{id}', [FollowedUpRequestController::class, 'show'])
        // ->name('technician.f-up-request.show');
        // Route::get('/f-up-request/accept/{id}', [FollowedUpRequestController::class, 'accept'])
        // ->name('technician.f-up-request.accept');
        // Route::get('/f-up-request/cancel/{id}', [FollowedUpRequestController::class, 'cancel'])
        // ->name('technician.f-up-request.cancel');
        // Route::get('/f-up-request/finish/{id}', [FollowedUpRequestController::class, 'finish'])
        // ->name('technician.f-up-request.finish');
        // Route::get('/f-up-request/edit/{id}', [FollowedUpRequestController::class, 'edit'])
        // ->name('technician.f-up-request.edit');
        // Route::put('/f-up-request/update/{id}', [FollowedUpRequestController::class, 'update'])
        // ->name('technician.f-up-request.update');
        // Route::get('/f-up-request/reject/{id}', [FollowedUpRequestController::class, 'reject'])
        // ->name('technician.f-up-request.reject');

        // Route::get('/computer/json', [ComputerController::class, 'json'])
        // ->name('computer.json');

        // Route::get('/user/json', [UserController::class, 'json'])
        // ->name('user.json');
    });

Route::prefix('cl')
    ->middleware(['auth', 'is.cleaning'])
    ->group(function(){
        Route::get('/', [CleaningController::class, 'index'])
        ->name('cleaning.dashboard');
        Route::get('/profile', [CleaningController::class, 'profile'])
        ->name('cleaning.profile');
        Route::post('/store-profile', [CleaningController::class, 'profilestore'])
        ->name('cleaning.storeprofile');

        Route::get('/request/show/{id}', [CleaningController::class, 'show'])
        ->name('cleaning.request.show');
        Route::get('/request/accept/{id}', [CleaningController::class, 'accept'])
        ->name('cleaning.request.accept');
        Route::get('/request/cancel/{id}', [CleaningController::class, 'cancel'])
        ->name('cleaning.request.cancel');
        Route::get('/request/finish/{id}', [CleaningController::class, 'finish'])
        ->name('cleaning.request.finish');
        Route::get('/request/reject/{id}', [CleaningController::class, 'reject'])
        ->name('cleaning.request.reject');
    });

Route::prefix('sc')
    ->middleware(['auth', 'is.security'])
    ->group(function(){
        Route::get('/', [SecurityController::class, 'index'])
        ->name('security.dashboard');
        Route::get('/profile', [SecurityController::class, 'profile'])
        ->name('security.profile');
        Route::post('/store-profile', [SecurityController::class, 'profilestore'])
        ->name('security.storeprofile');

        Route::get('/request/show/{id}', [SecurityController::class, 'show'])
        ->name('security.request.show');
        Route::get('/request/accept/{id}', [SecurityController::class, 'accept'])
        ->name('security.request.accept');
        Route::get('/request/cancel/{id}', [SecurityController::class, 'cancel'])
        ->name('security.request.cancel');
        Route::get('/request/finish/{id}', [SecurityController::class, 'finish'])
        ->name('security.request.finish');
        Route::get('/request/reject/{id}', [SecurityController::class, 'reject'])
        ->name('security.request.reject');
    });

Route::prefix('m')
    ->middleware(['auth', 'is.manager'])
    ->group(function(){
        Route::get('/', [ManagerDashboardController::class, 'index'])
        ->name('manager.dashboard');
        Route::get('/verified-request', [VerifiedRequestController::class, 'index'])
        ->name('manager.verified-request');
        Route::get('/verified-request/json', [VerifiedRequestController::class, 'json'])
        ->name('manager.verified-request.json');
        Route::put('/verified-request/verify/{id}', [VerifiedRequestController::class, 'verify'])
        ->name('manager.verified-request.verify');


        Route::get('/user/json', [TechnicianController::class, 'json'])
        ->name('technician.json');
        Route::get('/user/index', [TechnicianController::class, 'index'])
        ->name('technician.index');
        Route::get('/user/create', [TechnicianController::class, 'create'])
        ->name('technician.create');
        Route::get('/user/alluser_store', [TechnicianController::class, 'alluser_store'])
        ->name('alluser.store');
        Route::get('/user/destroy/{id}', [TechnicianController::class, 'destroy'])
        ->name('manager.user.delete');
        Route::get('/user/edit/{id}', [TechnicianController::class, 'edit'])
        ->name('manager.user.edit');
        Route::post('/user/update/{id}', [TechnicianController::class, 'update'])
        ->name('manager.user.update');
        
        
        Route::get('/verified-request/export-excel/{awal}/{akhir}', [ManagerDashboardController::class, 'exportExcel'])
        ->name('manager.request.export_excel');
        Route::get('/verified-request/data/test/{awal}/{akhir}', [ManagerDashboardController::class, 'getData']);
        Route::get('/verified-request/data/{awal}/{akhir}', [ManagerDashboardController::class, 'data'])
        ->name('manager.request.data');
        
    });