<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mejaController;
use App\Http\Controllers\menuController;
use App\Http\Controllers\transaksiController;
use App\Http\Controllers\userController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/gagal_akses', function(){
    return Response()->json(['status'=>'gagal']);
})->name('login');




Route::prefix('admin')->controller(AuthController::class)->group(function () {

    Route::post('login', 'login');
    Route::post('register', 'register');

    
    Route::middleware('auth:admin_api')->group(function () {
        Route::post('logout', 'logout');
        
            //ADMIN
        Route::group(['middleware'=>['api.admin']],function(){
            //meja
            Route::post('/createmeja', [mejaController::class, 'createmeja']);
            Route::get('/getmeja', [mejaController::class, 'getmeja']);
            Route::put('/updatemeja/{id}', [mejaController::class, 'updatemeja']);
            Route::delete('/deletemeja/{id}', [mejaController::class, 'destroymeja']);
            Route::get('/detailmeja/{id}', [mejaController::class, 'getdetailmeja']);

            //menu
            Route::post('/createmenu', [menuController::class, 'createmenu']);
            Route::get('/getmenu', [menuController::class, 'getmenu']);
            Route::put('/updatemenu/{id}', [menuController::class, 'updatemenu']);
            Route::delete('/deletemenu/{id}', [menuController::class, 'destroymenu']);
            Route::get('/detailmenu/{id}', [menuController::class, 'getdetailmenu']);
            Route::post('/searchmenu', [menuController::class, 'searchmenu']);

            //user
            Route::post('/createuser', [userController::class, 'createuser']);
            Route::get('/getuser', [userController::class, 'getuser']);
            Route::put('/updateuser/{id}', [userController::class, 'updateuser']);
            Route::delete('/deleteuser/{id}', [userController::class, 'destroyuser']);
            Route::get('/detailuser/{id}', [userController::class, 'getdetailuser']);
            Route::post('/searchuser', [userController::class, 'searchuser']);

        });

        //KASIR
        Route::group(['middleware'=>['api.kasir']],function(){

            //transaksi
            Route::post('/transaksi',[transaksiController::class,'transaksi']);
            Route::get('/gettransaksi_kasir', [transaksiController::class, 'gettransaksi']);
            Route::post('/updatetransaksi/{id}', [transaksiController::class, 'updatetransaksi']);
        });

        //MANAJER
        Route::group(['middleware'=>['api.manajer']],function(){

            //transaksi
            Route::get('/gettransaksi', [transaksiController::class, 'gettransaksi']);
            Route::post('/searchtransaksi', [transaksiController::class, 'searchtransaksi']);
        });
        });
        
        Route::post('logout','logout');
        Route::post('me','me');

});

