<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Message\Response;

use App\Helper\Helper as Helper;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getAllPokemon() {
        $client = new Client();
        $req = $client->request('GET', 'https://pokeapi.co/api/v2/pokemon/');
        $response = json_decode($req->getBody());

        $pokeData = array();
        foreach($response->results as $data)
        {
            $req2 = $client->request('GET', $data->url);
            $response2 = json_decode($req2->getBody());
            array_push($pokeData, $response2);
        }
        return view('pokedex', array('pokemons' => $response, 'pokeData' => $pokeData));
    }
    public function getAllPokemonOffset($id) {
        $client = new Client();
        $url = 'https://pokeapi.co/api/v2/pokemon/?offset='.$id.'&limit=20';
        $req = $client->request('GET', $url);
        $response = json_decode($req->getBody());

        $pokeData = array();
        foreach($response->results as $data)
        {
            $req2 = $client->request('GET', $data->url);
            $response2 = json_decode($req2->getBody());
            array_push($pokeData, $response2);
        }
        return view('pokedex', array('pokemons' => $response, 'pokeData' => $pokeData));
    }
    /*public function getPokeData($url) {
        $client = new Client();
        $req = $client->request('GET', $url);
        $response = json_decode($req->getBody());

        $pokeData = array();
        foreach($response->results as $data)
        {
            $req2 = $client->request('GET', $data->url);
            $response2 = json_decode($req2->getBody());
            array_push($pokeData, $response2);
        }
        return array('pokemons' => $response, 'pokeData' => $pokeData);
    }*/
}
