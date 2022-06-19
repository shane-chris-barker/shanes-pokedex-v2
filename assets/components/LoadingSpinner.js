import React, {Component} from 'react';

class LoadingSpinner extends Component {

    render() {
        return(
            <section className='text-center'>
                <div className="col-4 offset-4">
                    <h1>Loading...</h1>
                    <i className='fa fa-spinner fa-5x fa-spin'/>
                </div>
            </section>
        )
    }
}
export default LoadingSpinner;