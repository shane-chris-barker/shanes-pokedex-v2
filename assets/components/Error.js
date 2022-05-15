import React, {Component} from 'react';

class Error extends Component {

    constructor(props) {
        super(props);
        this.errorMessage = this.props.errorMessage;

    }
    render() {
        return(
            <div>
                <section className="row-section">
                    <div className="container col-6 offset-3">
                        <div className="alert alert-danger text-center">
                            <i className="fa fa-exclamation-circle fa-3x" />
                            <br/>
                            <br/>
                            {this.errorMessage}
                        </div>
                    </div>
                </section>
            </div>
        )
    }
}

export default Error;