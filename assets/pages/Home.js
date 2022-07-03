import React, {Component} from 'react';
import axios from 'axios';

import PokemonResult from "../components/pokemon/PokemonResult";
import LocationResult from "../components/location/LocationResult";
import PokemonForm from "../components/forms/PokemonForm";
import LocationForm from "../components/forms/LocationForm";
import Error from '../components/Error';
import LoadingSpinner from "../components/LoadingSpinner";
import EmailMeResult from "../components/forms/EmailMeResult";
import SearchTypes from "../components/forms/components/SearchTypes";
import ItemSearchForm from "../components/forms/ItemForm";
import ItemResult from "../components/item/ItemResult";

class Home extends Component {
    constructor() {
        super();
        this.state = {
            pokemon: [],
            location: [],
            item: [],
            displayResult: false,
            error: false,
            errorMessage: "",
            loading: false,
            url: "http://localhost:8080/",
            selectedSearch: 'pokemon',
            emailSent: false,
            searchTerm: ""
        };
        this.getPokemon     = this.getPokemon.bind(this);
        this.getLocation    = this.getLocation.bind(this);
        this.getItem        = this.getItem.bind(this);
        this.emailResult    = this.emailResult.bind(this);
        this.toggleSearch   = this.toggleSearch.bind(this);
    }

    getLocation(name) {
        this.setState({
            displayResult: false,
            loading: true,
            pokemon: [],
            item: [],
            searchTerm: name
        });
        let url = this.state.url+'location/'+name;
        axios.get(url)
            .then(location => {
                if (true === location.data.error) {
                    this.setState({
                        location: [],
                        displayResult: false,
                        error: true,
                        errorMessage: location.data.data,
                        loading: false
                    });
                } else {
                    console.log(location.data);
                    this.setState({
                        location: location.data,
                        displayResult: true,
                        error: false,
                        errorMessage: "",
                        loading: false
                    });
                }
            });
    }

    getPokemon(name) {
        this.setState({displayResult: false, loading: true, location: [], item: [], searchTerm: name});
        let url = this.state.url+'pokemon/'+name
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

    getItem(name) {
        this.setState({displayResult: false, loading: true, location: [], pokemon: [], searchTerm: name });
        let url = this.state.url+'item/'+name
        axios.get(url)
            .then(item => {
                if (true === item.data.error) {
                    this.setState({
                        item: [],
                        displayResult: false,
                        error: true,
                        errorMessage: item.data.data,
                        loading: false
                    });
                } else {
                    this.setState({
                        item: item.data,
                        displayResult: true,
                        error: false,
                        errorMessage: "",
                        loading: false
                    });
                }
            });
    }

    emailResult(event) {
        event.preventDefault();
        let email = event.target.email_address.value
        let url = this.state.url+'send/result/'+this.state.selectedSearch+'/'+this.state.searchTerm+'/'+email
        axios.get(url)
            .then(result => {
                if (true === result.data.error) {
                    this.setState({
                        emailSent: false
                    });
                } else {
                    this.setState({
                        emailSent: true
                    });
                }
            });
    }

    handlePokemonSearch = event => {
        event.preventDefault();
        this.getPokemon(event.target.pokemon_name.value);
    }

    handleItemSearch = event => {
        event.preventDefault();
        this.getItem(event.target.item_name.value);
    }

    handleLocationSearch = event => {
        event.preventDefault();
        this.getLocation(event.target.location_name.value);
    }

    toggleSearch(event) {
        event.preventDefault();
        this.setState({
            selectedSearch: event.target.value,
            displayResult: false
        })
    }

    render() {
        const displayResult = this.state.displayResult;
        const loading = this.state.loading;
        const error = this.state.error;
        const pokemonSearch = this.state.selectedSearch === 'pokemon';
        const locationSearch = this.state.selectedSearch === 'location';
        const itemSearch  = this.state.selectedSearch === 'item';
        const emailSent = this.state.emailSent;
        return(
            <div>
                <div className="container">
                    <section className="row-section col-6 offset-3">
                        <div className="card mt-5">
                            <h5 className="card-header text-center p-5 ">
                                <i className='fa fa-search' /><br/>
                                Search the Pokemon World!
                            </h5>
                            <div className='text-center mt-5'>
                                Search by...
                                <SearchTypes onToggle={this.toggleSearch} selected={this.state.selectedSearch} key={this.state.selectedSearch}/>
                            </div>
                            <section className="row-section p-5">
                                <div className="form-group">
                                    {pokemonSearch &&
                                        <div>
                                            <PokemonForm handleSearch={this.handlePokemonSearch}/>
                                        </div>
                                    }
                                    {locationSearch &&
                                        <div>
                                            <LocationForm handleSearch={this.handleLocationSearch}/>
                                        </div>
                                    }
                                    {itemSearch &&
                                        <div>
                                            <ItemSearchForm handleSearch={this.handleItemSearch}/>
                                        </div>
                                    }
                                </div>
                            </section>
                        </div>
                    </section>
                    {loading &&
                        <LoadingSpinner />
                    }
                    {error && !loading &&
                        <Error errorMessage={this.state.errorMessage}/>
                    }
                    <div className='mt-5'>
                        <section className="row-section col-6 offset-3">
                            {displayResult && pokemonSearch &&
                                <div className="card">
                                    <PokemonResult pokemon={this.state.pokemon} key={this.state.pokemon.name} />
                                </div>
                            }
                            {displayResult && locationSearch &&
                                <div className="card">
                                    <LocationResult location={this.state.location.data} key={this.state.location.name} />
                                </div>
                            }
                            {displayResult && itemSearch &&
                                <div className="card">
                                    <ItemResult item={this.state.item.data} key={this.state.item.name} />
                                </div>
                            }
                            {displayResult &&
                                <EmailMeResult emailSent={emailSent} handleEmailSubmit={this.emailResult} />
                            }
                        </section>
                    </div>
                </div>
            </div>
        )
    }
}
export default Home;