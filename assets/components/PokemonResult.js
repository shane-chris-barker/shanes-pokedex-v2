import React, {Component} from 'react';

class PokemonResult extends Component {
    constructor(props) {
        super(props);
        this.pokemon = this.props.pokemon;
    }

    render() {
        return(
            <div>
                <section className="row-section">
                    <div className="container col-6 offset-3">
                        <div className="card">
                            <h5 className="card-header text-center">{this.pokemon.name}</h5>

                            <div className="row">
                                <div className="col-6">
                                    <p className="col-12 text-center">Normal</p>
                                    <img
                                        src={this.pokemon.images.default.front.image}
                                        className="col-6"
                                        alt="Default front image"

                                    />
                                    <img
                                        src={this.pokemon.images.default.back.image}
                                        className="col-6"
                                        alt="Default back image"
                                    />
                                </div>
                                <div className="col-6">
                                    <p className="col-12 text-center">Shiny</p>
                                    <img
                                        src={this.pokemon.images.shiny.front.image}
                                        className="col-6"
                                        alt="Shiny version front"
                                    />
                                    <img
                                        src={this.pokemon.images.shiny.back.image}
                                        className="col-6"
                                        alt="Shiny Version Back"
                                    />
                                </div>

                            </div>
                            <div className="card-body text-center">
                                <h5 className="card-title">Pokedex Description</h5>
                                <p className="card-text">
                                    {this.pokemon.pokedex.pokedexDescription}
                                </p>
                            </div>
                            <ul className="list-group list-group-flush mt-2">
                                <h5 className="col-12 text-center">Abilities</h5>
                                {this.pokemon.abilities.map((ability) =>
                                    <div key={ability.name} className="p-2">
                                        <strong><p className="col-12 text-center">{ability.name}</p></strong>
                                        <p className="col-12 text-center">{ability.effect}</p>
                                        <p className="col-12">{ability.affect}</p>
                                    </div>
                                )}
                            </ul>
                            <div className="card-body">
                                <a href="#" className="card-link">Card link</a>
                                <a href="#" className="card-link">Another link</a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        )
    }
}
export default PokemonResult;