<?php
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('funcionarios', 'App\Http\Controllers\ApiController@cadFuncionario');
Route::post('clientes', 'App\Http\Controllers\ApiController@cadCliente');
Route::post('mesas', 'App\Http\Controllers\ApiController@cadMesa');
Route::post('cardapios', 'App\Http\Controllers\ApiController@cadCardapio');
Route::post('itenscardapio', 'App\Http\Controllers\ApiController@cadItemCardapio');
Route::post('pedido', 'App\Http\Controllers\ApiController@cadPedido');
Route::get('itempedido', 'App\Http\Controllers\ApiController@cadItemPedido');
Route::get('fake', 'App\Http\Controllers\ApiController@fake');
Route::get('pedidosAndamento', 'App\Http\Controllers\ApiController@pedidosAndamento');
Route::get('pedidosCozinheiro', 'App\Http\Controllers\ApiController@pedidosCozinheiro');
Route::get('maiorPedido', 'App\Http\Controllers\ApiController@maiorPedido');
Route::get('primeiroPedido', 'App\Http\Controllers\ApiController@primeiroPedido');
Route::get('ultimoPedido', 'App\Http\Controllers\ApiController@ultimoPedido');
Route::get('pedidosMesa', 'App\Http\Controllers\ApiController@pedidosMesa');
Route::get('pedidosCliente', 'App\Http\Controllers\ApiController@pedidosCliente');
Route::get('pedidosDia', 'App\Http\Controllers\ApiController@pedidosDia');
route::get('stores',[StoresController::class,'index']);