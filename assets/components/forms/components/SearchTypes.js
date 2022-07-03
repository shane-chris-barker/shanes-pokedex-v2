import React, {Component} from 'react';

class SearchTypes extends Component {
    constructor(props) {
        super(props);
        this.onToggle = this.props.onToggle.bind(this);
        this.selected = this.props.selected;
    }

    render() {
        return(
            <div>
                <div className="form-check form-check-inline">
                    <input
                        type="radio"
                        className="form-check-input"
                        value="pokemon"
                        name="search_type"
                        id='pokemon_search'
                        onChange={this.onToggle}
                        checked={this.selected === 'pokemon'}
                    />
                    <label className="form-check-label" htmlFor='pokemon_search'>Pokemon Name</label>
                </div>
                <div className="form-check form-check-inline">
                    <input type="radio"
                           className="form-check-input"
                           value="location"
                           name="search_type"
                           id='location_search'
                           onChange={this.onToggle}
                           checked={this.selected === 'location'}
                    />
                    <label className="form-check-label" htmlFor='location_search'>Location Name</label>
                </div>
                <div className="form-check form-check-inline">
                    <input type="radio"
                           className="form-check-input"
                           value="item"
                           name="search_type"
                           id='item_search'
                           onChange={this.onToggle}
                           checked={this.selected === 'item'}
                    />
                    <label className="form-check-label" htmlFor='location_search'>Item Name</label>
                </div>
            </div>
        )
    }
}
export default SearchTypes;