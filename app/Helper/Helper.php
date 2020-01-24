<?php

namespace App\Helper;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Message\Response;

class Helper
{
    public static function getPokeData($url) {
        $client = new Client();
        $req = $client->request('GET', $url);
        $response = json_decode($req->getBody());
        return $response;
    }
}