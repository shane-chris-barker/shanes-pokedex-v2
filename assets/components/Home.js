import React, {Component} from 'react';
import axios from 'axios';

import PokemonResult from "./PokemonResult";
import Form from "./Form";

class Home extends Component {
    constructor() {
        super();
        this.state = { pokemon: [], loading: false, displayResult: false};
        this.getPokemon = this.getPokemon.bind(this);
    }

    getPokemon(name) {
        let url = 'http://localhost:8080/pokemon/'+name
        axios.get(url)
            .then(pokemon => {
                this.setState({ pokemon: pokemon.data, displayResult: true})
            })
    }

    handleSearch = event => {
        event.preventDefault();
        this.getPokemon(event.target.pokemon_name.value);

    }

    render() {
        const displayResult = this.state.displayResult;
        return(
            <div>
                <section className="row-section">
                    <div>
                        <Form handleSearch={this.handleSearch} />
                    </div>
                    {displayResult &&
                      <PokemonResult pokemon={this.state.pokemon} key={this.state.pokemon.name} />
                    }

                </section>
            </div>
        )
    }
}
export default Home;