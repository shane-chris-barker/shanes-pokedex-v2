import React, {Component} from 'react';
import axios from 'axios';

import PokemonResult from "../components/PokemonResult";
import Form from "../components/Form";
import Error from '../components/Error';

class Home extends Component {
    constructor() {
        super();
        this.state = { pokemon: [], displayResult: false, error: false, errorMessage: ""};
        this.getPokemon = this.getPokemon.bind(this);
    }

    getPokemon(name) {
        this.setState({displayResult: false, loading: true});
        let url = 'http://localhost:8080/search/'+name
        axios.get(url)
            .then(pokemon => {
                if (true === pokemon.data.error) {
                    this.setState({
                        pokemon: [],
                        displayResult: false,
                        error: true,
                        errorMessage: pokemon.data.data
                    });
                } else {
                    this.setState({
                        pokemon: pokemon.data,
                        displayResult: true,
                        error: false,
                        errorMessage: ""
                    });
                }
            });
    }

    handleSearch = event => {
        event.preventDefault();
        this.getPokemon(event.target.pokemon_name.value);

    }

    render() {
        const displayResult = this.state.displayResult;
        const loading = this.state.loading;
        const error = this.state.error;
        return(
            <div>
                <section className="row-section">
                    <div>
                        <Form handleSearch={this.handleSearch} />
                    </div>
                    {error && !loading &&
                        <Error errorMessage={this.state.errorMessage}/>
                    }

                    {displayResult &&
                        <PokemonResult pokemon={this.state.pokemon} key={this.state.pokemon.name} />
                    }

                </section>
            </div>
        )
    }
}
export default Home;