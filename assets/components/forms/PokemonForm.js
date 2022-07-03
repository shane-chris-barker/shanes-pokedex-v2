import React, {Component} from 'react';

class PokemonSearchForm extends Component {
    constructor(props) {
        super(props);
        this.handleSearch = this.props.handleSearch.bind(this);
    }

    render() {
        return(
            <form onSubmit={this.handleSearch}>
                <label htmlFor="pokemon_name">Pokemon Name</label>
                <input className="form-control"
                       type="text"
                       name="pokemon_name"
                       id="pokemon_name"
                       ref={node => this.inputNode = node}
                />
                <input type="submit"  value="Search" className='col-4 offset-4 mt-2 btn-primary' />
            </form>
        )
    }
}
export default PokemonSearchForm;