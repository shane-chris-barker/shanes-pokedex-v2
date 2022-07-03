import React, {Component} from 'react';

class ItemResult extends Component {
    constructor(props) {
        super(props);
        this.item = this.props.item;
    }

    render() {
        return(
            <div>
                <h5 className="card-header text-center p-5 ">{this.item.name}</h5>
                <div className="card-body text-center">
                    <p className="card-text">
                        {this.item.effectText}
                    </p>
                    <div className="row">
                        <img
                            src={this.item.imageUrl}
                            className="col-2 offset-5"
                            alt="Default front image"
                        />
                    </div>
                    <div className="col-6 offset-3">
                        <hr className="col-12" />
                    </div>
                    <p className="card-text">
                        {this.item.descriptionText}
                    </p>
                    <p className="card-text">
                        The <strong>{this.item.name}</strong> belongs to the <strong>{this.item.category}</strong> category.
                    </p>
                </div>

                <div className="card-body">
                    <a href="#" className="card-link">Card link</a>
                    <a href="#" className="card-link">Another link</a>
                </div>
            </div>
        )
    }
}
export default ItemResult;