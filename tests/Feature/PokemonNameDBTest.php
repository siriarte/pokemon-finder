<?php

namespace Tests\Feature;

use App\Pokemon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use GuzzleHttp\Client;

class PokemonNameDBTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
   
    private function getPokemonsTotalCountFromPokeApi() {
        $client = new Client(['base_uri' => 'https://pokeapi.co/']);
        $response = $client->request('GET', 'api/v2/pokemon?limit=1');
        $body = $response->getBody();
        $content = json_decode($body, TRUE);
        $count = $content['count'];
        return $count;
    }
    
    public function testGetToCreateCacheDBPopulateDB()
    {
        Pokemon::truncate();
        $totalPokemonsOnPokeApi = $this->getPokemonsTotalCountFromPokeApi();
        $this->get('/create-pokemons-name-db')->assertSee($totalPokemonsOnPokeApi);
        $pokemons = Pokemon::All();
        
        $theRegisterCreatesAreEqualsToNumberOfPokemons = (count($pokemons)==$totalPokemonsOnPokeApi);
        $this->assertTrue($theRegisterCreatesAreEqualsToNumberOfPokemons);
        Pokemon::truncate();
    }
    
}
    