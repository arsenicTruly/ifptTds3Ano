<?php 

require_once("modelo/Pokemon.php");

echo"<link rel='stylesheet' href='style.css'>";

$pokemons = [       
                new Pokemon("Bulbasaur", 
                    "Planta, Venenoso", 
                    "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1.png", "https://www.pokemon.com/br/pokedex/bulbasaur"),
                new Pokemon("Charmander", 
                    "Fogo", 
                    "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/4.png", "https://www.pokemon.com/br/pokedex/charmander"),
                new Pokemon("Squirtle", 
                    "Água", 
                    "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/7.png", "https://www.pokemon.com/br/pokedex/squirtle"),
                new Pokemon("Pikachu", 
                    "Elétrico", 
                    "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/25.png", "https://www.pokemon.com/br/pokedex/pikachu"),
                new Pokemon("Turtwig", 
                    "Planta", 
                    "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/387.png", "https://www.pokemon.com/br/pokedex/turtwig")
            ];

print"<table>";

    print"<tr>";

        print"<th colspan='4'>";
            echo"Tabela Pokemon";
        print"</th>";

    print"</tr>";

    print"<tr class='nomeCol'>";

        print"<th>";
            echo"Nome";
        print"</th>";
        print"<th>";
            echo"Tipo";
        print"</th>";
        print"<th>";
            echo"Imagem";
        print"</th>";
        print"<th>";
            echo"Link";
        print"</th>";

    print"</tr>";

    foreach($pokemons as $poke){

        $poke->getRow();
    }

print"</table>";