<?php

use App\Models\User;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);

Route::middleware(['auth:api'])->group(function () {
    Route::resource('/users', \App\Http\Controllers\UserController::class)
        ->except(['create', 'edit', 'store']);
});


Route::post('/login', [\App\Http\Controllers\UserController::class, 'login']);

Route::get('/teste', function () {
    $user = User::find(1);
    $user2 = User::find(2);
//    $user->conteudos()->create([
//        'titulo' => 'Titulo 4',
//        'texto' => ' texto te ts',
//        'imagem' => 'imagem',
//        'link' => 'Link p',
//    ]);
//

//    $user->amigos()->attach($user2->id);
//    $user->amigos()->attach($user2->id);
//    $user->amigos()->detach($user2->id);
    $user->amigos()->toggle(2);

    return $user->amigos;
});
