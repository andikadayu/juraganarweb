import React, { useEffect } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';


class Scrapper extends React.Component {

    constructor(props) {
        super(props);
        this.state = { loading: 0 }
        // This binding is necessary to make `this` work in the callback
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleSubmit(event) {
        event.preventDefault();
        let formData = new FormData(document.querySelector("form[id='formScrap']"));

        axios({
            method: "post",
            url: "/api/scrapping",
            data: formData
        }).then(function (response) {
            console.log(response);

        }).catch(function (response) {
            console.log(response);

        });

    }

    render() {
        return (
            <div className="row" >
                <div className="col-md-12">
                    <div className="card">
                        <div className="card-body">
                            <form id='formScrap' onSubmit={this.handleSubmit}>
                                <input className='form-control' type={'hidden'} id='csrf_token_field' name='_token'></input>

                                <div className="form-group">
                                    <label className="form-label">Link Shopee</label>
                                    <textarea name="shopeelink" id="shopeelink" className="form-control"
                                        placeholder="Enter link separate by comma" required style={{ height: 200 + 'px' }}></textarea>
                                </div>

                                <div className="d-flex justify-content-between mt-5">
                                    <a href="#" id='btnBack' className="btn btn-secondary">Back</a>
                                    <button type="submit" className="btn btn-success">Save</button>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div className="progress mt-3">
                        <div className="progress-bar" role="progressbar" style={{ width: this.state.loading + '%' }} aria-valuenow={this.state.loading} aria-valuemin="0" aria-valuemax="100">{this.state.loading}%</div>
                    </div>

                </div>
            </div>
        );
    };

}

if (document.getElementById('scrapper-form')) {
    ReactDOM.render(<Scrapper />, document.getElementById('scrapper-form'));
}


