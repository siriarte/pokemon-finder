<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pokemon;
use GuzzleHttp\Client;

class PokemonController extends Controller
{
    /*
     * getPokemonsByPartialName(string $partialName)
     * 
     * Get information from pokeApi requesting the $pokeApiUrl
     * 
     */
    public function getPokemonInformation($pokeApiUrl){
        $client = new Client(['base_uri' =>  $pokeApiUrl]);
        $response = $client->request('GET','');
        $body = $response->getBody();
        $pokemonInfo = json_decode($body, TRUE);
        return $pokemonInfo;
    }
    
    /*
     * getPokemonsByPartialName(string $partialName)
     * 
     * Return a json with the specific requiered from pokemons
     * that match the name with the pokemon db name cache
     * 
     */
    public function getPokemonsByPartialName($partialName){
        
        // Verify max length
        if(strlen($partialName)>30){
            return response()->json(array('status' => '400', 'error' => 'El nombre a buscar no puede exceder los 30 caracteres.'));
        }
        
        // Get pokemons from db that match
        $pokemons = Pokemon::where('name','LIKE','%'.$partialName.'%')->get();
        
        // For each match request information from PokeApi and build a response 
        // with specific information used
        $pokemonArray = [];
        foreach($pokemons as $pokemon){
            $pokemonInfo = $this->getPokemonInformation($pokemon->url);
            $pokemonResume = [];
            $pokemonResume['name'] = $pokemonInfo['name'];
            $pokemonResume['picture'] = $pokemonInfo['sprites']['front_default'];
            $pokemonResume['types'] = $pokemonInfo['types'];            
            $pokemonArray[] = $pokemonResume;
        }
        
        // Return response
        return  response()->json(array('status' => '200', 'results' => $pokemonArray));
    }

}
