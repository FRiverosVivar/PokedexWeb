<?php

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

Route::get('home/{id}', 'Controller@getAllPokemonOffset');
Route::get('home', 'Controller@getAllPokemon');

/*Route::get('','Controller@getPokeData');

Route::get('/', function (PokePHP\PokeApi $pokemon) {
    $api = new PokeApi;
    $response = $api->sendRequest("https://pokeapi.co/api/v2/");
    $data = json_decode($response,true);
    dd($data);
});*/