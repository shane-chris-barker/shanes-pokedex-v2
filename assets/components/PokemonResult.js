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
                            <h5 className="card-header text-center p-5 ">{this.pokemon.data.name}</h5>

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
                            <div className="col-6 offset-3">
                                <hr className="col-12" />
                            </div>
                            <div className="card-body text-center">
                                <h5 className="col-12 ">Base Stats</h5>
                                <div className="row">
                                    {this.pokemon.stats.map((stat) =>
                                        <p key={stat.name} className="p-2 col-4">
                                            <strong>{stat.name}</strong> : {stat.value}
                                        </p>
                                    )}
                                </div>
                            </div>
                            <div className="col-6 offset-3">
                                <hr className="col-12" />
                            </div>
                            <div className="card-body text-center">
                                <h3 className="col-12 ">Evolution Chain</h3>
                                {this.pokemon.evolution.chain.length > 0 &&
                                    <div className="row">
                                        {this.pokemon.evolution.chain.map((evolution) =>
                                            <div className="col-4" key={evolution.name}>
                                                <p><strong>{evolution.name}</strong></p>
                                                <p>Stage: {evolution.stage}</p>
                                                <img src={evolution.image} alt={evolution.image + "image"} className='img-fluid'/>
                                            </div>
                                        )}
                                    </div>
                                }
                            </div>
                            <ul className="list-group list-group-flush mt-2">
                                <h5 className="col-12 text-center">Abilities</h5>
                                {this.pokemon.abilities.map((ability) =>
                                    <div key={ability.name} className="p-2 text-center">
                                        <strong><p className="col-12">{ability.name}</p></strong>
                                        <p className="col-12 ">{ability.effect}</p>
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