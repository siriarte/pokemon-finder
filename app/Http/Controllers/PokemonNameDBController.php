<?php

namespace App\Http\Controllers;

use App\Pokemon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PokemonNameDBController extends Controller
{
    /*
     * getPokemonsTotalCountFromPokeApi()
     *
     * Make simple request to pokeApi to know how many 
     * pokemons exist on its service
     *   
     */    
    public function getPokemonsTotalCountFromPokeApi() {
        $client = new Client(['base_uri' => 'https://pokeapi.co/']);
        $response = $client->request('GET', 'api/v2/pokemon?limit=1');
        $body = $response->getBody();
        $content = json_decode($body, TRUE);
        $count = $content['count'];
        return $count;
    }
    
    /*
     * updatePokemonNameCache() 
     * 
     * Create a table with name and info-url for all pokemons on pokeApi
     * 
     */    
    public function createPokemonNameDB() {
        
        // Get total number of pokemons on pokeapi
        $totalPokemonsInPokeApi = $this->getPokemonsTotalCountFromPokeApi();
        
        // Truncate pokemon table
        Pokemon::truncate();
 
        // Get all basic information from all pokemons
        $client = new Client(['base_uri' => 'https://pokeapi.co/']);
        $response = $client->request('GET', 'api/v2/pokemon?limit='. $totalPokemonsInPokeApi);
        $body = $response->getBody();
        
        // Decode response
        $content = json_decode($body, TRUE);
        $result = $content['results'];
        
        // Save the pokemon model
        foreach($result as $r){
            $pokemon =  new Pokemon(['name'=>$r['name'], 'url'=>$r['url']]);
            $pokemon->save();
        }
        
        return 'Database updated successfully with ' . $totalPokemonsInPokeApi . ' pokemons';
    }
}
