import React, {Component} from 'react';
import axios from 'axios';

import PokemonResult from "../components/PokemonResult";
import Form from "../components/Form";
import Error from '../components/Error';
import Spinner from '../components/LoadingSpinner';
import LoadingSpinner from "../components/LoadingSpinner";

class Home extends Component {
    constructor() {
        super();
        this.state = { pokemon: [], displayResult: false, error: false, errorMessage: "", loading: false};
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
                        errorMessage: pokemon.data.data,
                        loading: false
                    });
                } else {
                    this.setState({
                        pokemon: pokemon.data,
                        displayResult: true,
                        error: false,
                        errorMessage: "",
                        loading: false
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
                <div className="container">
                    <section className="row-section col-6 offset-3">
                        <div>
                            <Form handleSearch={this.handleSearch} />
                        </div>
                        {loading &&
                            <LoadingSpinner />
                        }
                        {error && !loading &&
                            <Error errorMessage={this.state.errorMessage}/>
                        }

                        {displayResult &&
                            <PokemonResult pokemon={this.state.pokemon} key={this.state.pokemon.name} />
                        }

                    </section>
                </div>
            </div>
        )
    }
}
export default Home;