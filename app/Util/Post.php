<?php
namespace App\Util;

use PokePHP\PokeApi;
$api = new PokeApi;
class Post
{

    public function allPokemons()
	{
        $api = new PokeApi;
        $response = $api->sendRequest("https://pokeapi.co/api/v2/pokemon");
        $data = json_decode($response,true);
		return $data;
	}

	public function getPokemon($id)
	{
        $api = new PokeApi;
        $response = $api->pokemon($id);
        $data = json_decode($response,true);
		return $data;
    }
}