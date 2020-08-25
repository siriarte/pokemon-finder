<?php

namespace Tests\Feature;

use App\Pokemon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
    private function setUpMockDB(){
        Pokemon::truncate();
        $pokemon1 = new Pokemon();
        $pokemon1->name = 'venonat';
        $pokemon1->url = 'https://pokeapi.co/api/v2/pokemon/48/';
        $pokemon1->save();
        
        $pokemon2 = new Pokemon();
        $pokemon2->name = 'venomoth';
        $pokemon2->url = 'https://pokeapi.co/api/v2/pokemon/49/';
        $pokemon2->save();
        
        $pokemon3 = new Pokemon();
        $pokemon3->name = 'diglett';
        $pokemon3->url = 'https://pokeapi.co/api/v2/pokemon/50/';
        $pokemon3->save();
        
        $pokemon4 = new Pokemon();
        $pokemon4->name = 'dugtrio';
        $pokemon4->url = 'https://pokeapi.co/api/v2/pokemon/51/';
        $pokemon4->save();
        
        $pokemon4 = new Pokemon();
        $pokemon4->name = 'dugtrio-alola';
        $pokemon4->url = 'https://pokeapi.co/api/v2/pokemon/10106/';
        $pokemon4->save();    
    }
    
    private function truncateMockDB(){
        Pokemon::truncate();
    }
    
    
    public function testFrontEnd()
    {
        $this->get('/')
            ->assertSee('Pokemon Finder')
            ->assertSee('El que quiere pokemons que los busque.')
            ->assertSee('Buscar');
    }
    
    public function testEmptySearchReturn404(){
        $this->get('/search/')->assertStatus(404);
    }
    
    public function testSearchWithLengthBiggerThan30ReturnError(){
        $stringWithLenMoraThan30 = 'ssssssssssssssssssssssssssssssssssssssss';
        $this->get('/search/' . $stringWithLenMoraThan30)
            ->assertJson(['status' => 400])
            ->assertJsonStructure([
                'status',
                'error'
            ]);;
    }
    
    public function testSearchWithLengthExact30Return200(){
        $stringWithLenMoraThan30 = 'ssssssssssssssssssssssssssssss';
        $this->get('/search/' . $stringWithLenMoraThan30)
            ->assertJson(['status' => 200])
            ->assertJsonStructure([
                'status',
                'results'
            ]);
    }   
    
    public function testSearchReturnPokemonNameAndPictureAndTypes(){
        $this->setUpMockDB();
        $nameToSearch = 'venonat';
        $response = $this->get('/search/' . $nameToSearch)
        ->assertJson(['status' => 200])
        ->assertJsonStructure([
            'status',
            'results'
        ]);
        
        $responseDecoded = json_decode($response->getContent(), true);
        $pokemonArray = $responseDecoded['results'];

        $this->assertTrue(isset($pokemonArray[0]['name']));
        $this->assertTrue(isset($pokemonArray[0]['picture']));
        $this->assertTrue(isset($pokemonArray[0]['types']));
    }
    
    public function testSearchWithAPokemonStartString(){
        $this->setUpMockDB();
        $nameToSearch = 'ven';
        $response = $this->get('/search/' . $nameToSearch)
            ->assertJson(['status' => 200])
            ->assertJsonStructure([
                'status',
                'results'
            ]);
        
        $responseDecoded = json_decode($response->getContent(), true);
        $pokemonArray = $responseDecoded['results'];
        $pokemonsMockDB = Pokemon::where('name','LIKE','%'.$nameToSearch.'%')->get();
        
        $this->assertTrue($pokemonArray[0]['name'] == $pokemonsMockDB[0]->name);
        $this->assertTrue($pokemonArray[1]['name'] == $pokemonsMockDB[1]->name);
        
        $this->truncateMockDB();
    }
    
    public function testSearchWithAPokemonContainsString(){
        $this->setUpMockDB();
        $nameToSearch = 'trio';
        $response = $this->get('/search/' . $nameToSearch)
        ->assertJson(['status' => 200])
        ->assertJsonStructure([
            'status',
            'results'
        ]);
        
        $responseDecoded = json_decode($response->getContent(), true);
        $pokemonArray = $responseDecoded['results'];
        $pokemonsMockDB = Pokemon::where('name','LIKE','%'.$nameToSearch.'%')->get();
        
        $this->assertTrue($pokemonArray[0]['name'] == $pokemonsMockDB[0]->name);
        $this->assertTrue($pokemonArray[1]['name'] == $pokemonsMockDB[1]->name);
        
        $this->truncateMockDB();
    }
    
    

    
}
    