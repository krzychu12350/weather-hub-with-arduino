<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index() {
        $client = new Client();
        $response = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather?id=763829&appid=7aef87c2b6d81812c53c536b5a1d715c');
        dd(
        $response->getStatusCode(),
        $response->getHeaderLine('content-type'),
        json_decode($response->getBody())
        );
    }
}
