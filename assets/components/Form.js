import React, {Component} from 'react';

class Form extends Component {
    constructor(props) {
        super(props);
        this.handleSearch = this.props.handleSearch.bind(this);
    }

    render() {
        return(
            <div className="card mt-5">
                <h5 className="card-header text-center p-5 ">
                    <i className='fa fa-search' /><br/>
                    Search the Pokemon World!
                </h5>
                <section className="row-section p-5">
                    <div className="form-group">
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
                    </div>
                </section>
            </div>
        )
    }
}
export default Form;