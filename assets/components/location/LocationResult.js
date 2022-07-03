import React, {Component} from 'react';

class LocationResult extends Component {
    constructor(props) {
        super(props);
        this.location = this.props.location;
    }

    render() {
        return(
                <div>
                    <h5 className="card-header text-center p-5 ">{this.location.name}</h5>
                    <div className="card-body text-center">
                        <h5 className="card-title">Location Information</h5>
                        <p className="card-text">
                            <strong>{this.location.name} </strong>is found in the <strong>{this.location.area}</strong>,
                            which is in <strong>{this.location.region}</strong>
                        </p>
                    </div>
                    <div className="col-6 offset-3">
                        <hr className="col-12" />
                    </div>
                    <div className="card-body text-center">
                        <h5 className="col-12 ">Pokemon Encountered in <strong>{this.location.name}</strong> </h5>
                        <div className="row">
                            {this.location.pokemonEncounters.map((encounter) =>
                                <p key={encounter.pokemon.name} className="p-2 col-4">
                                    <strong>{encounter.pokemon.name} </strong>
                                </p>
                            )}
                        </div>
                    </div>
                    <div className="card-body">
                        <a href="#" className="card-link">Card link</a>
                        <a href="#" className="card-link">Another link</a>
                    </div>
                </div>

        )
    }
}
export default LocationResult;