import React, {Component} from 'react';

class EmailMeResultForm extends Component {
    constructor(props) {
        super(props);
        this.handleEmailSubmit  = this.props.handleEmailSubmit.bind(this);
        this.emailSent          = this.props.emailSent;
    }

    render() {
        const emailSent = this.emailSent;
        return(
            <div className="card mt-5">
                <h5 className="card-header text-center p-5 ">
                    <i className='fa fa-search' /><br/>
                    Email me this result!
                </h5>
                <section className="row-section p-5">
                    {emailSent &&
                        <div className='alert alert-primary'>
                            The email was sent! Please check your spam.
                        </div>
                    }
                    <div className="form-group">
                        <form onSubmit={this.handleEmailSubmit}>
                            <label htmlFor="email_address">Email Address</label>
                            <input className="form-control"
                                   type="text"
                                   name="email_address"
                                   id="email_address"
                                   ref={node => this.inputNode = node}
                            />
                            <input type="submit"  value="Send" className='col-4 offset-4 mt-2 btn-primary' />
                        </form>
                    </div>
                </section>
            </div>
        )
    }
}
export default EmailMeResultForm;