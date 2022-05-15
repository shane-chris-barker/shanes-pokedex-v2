import React, {Component} from 'react';

class Form extends Component {
    constructor(props) {
        super(props);
        this.handleSearch = this.props.handleSearch.bind(this);


    }

    render() {
        return(
            <div className="col-4 offset-4">
                <section className="row-section">
                    <div className="form-group">
                        <form onSubmit={this.handleSearch}>
                            <label htmlFor="pokemon_name">Pokemon Name</label>
                            <input className="form-control" type="text" name="pokemon_name" id="pokemon_name" ref={node => this.inputNode = node}/>
                            <input type="submit"  value="Search" />
                        </form>
                    </div>

                </section>
            </div>
        )
    }
}
export default Form;