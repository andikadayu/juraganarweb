import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';


class Scrapper extends React.Component {

    constructor(props) {
        super(props);
        this.state = { loading: 0, isSubmit: false }
        // This binding is necessary to make `this` work in the callback
        this.handleSubmit = this.handleSubmit.bind(this);
        this.saveLoading = this.saveLoading.bind(this);
    }

    saveLoading(value) {
        this.setState({ loading: value });
    }

    handleSubmit(event) {
        event.preventDefault();

        this.saveLoading(0);
        this.setState({ isSubmit: true });

        let formData = new FormData(document.querySelector("form[id='formScrap']"));
        let links = formData.get('shopeelink');
        let _token = formData.get('_token');
        let id_user = formData.get('id_user');

        let allLink = links.split(',');

        let count = allLink.length;
        let current = 1;

        for (let index = 0; index < count; index++) {
            const mylink = allLink[index];
            let formNew = new FormData();
            formNew.append('shopeelink', mylink);
            formNew.append('_token', _token);
            formNew.append('id_user', id_user);

            setTimeout(async () => {
                await axios({
                    method: "post",
                    url: "/api/scrapping",
                    data: formNew,
                    responseType: 'json'
                }).then(function (response) {
                    console.log(response);
                }).catch(function (error) {
                    console.log(error);
                })
                this.saveLoading(current / count * 100);
                current++;

            }, 2000);

        }


    }

    render() {
        return (
            <div className="row" >
                <div className="col-md-12">
                    <div className="card">
                        <div className="card-body">
                            <form id='formScrap' onSubmit={this.handleSubmit}>
                                <input className='form-control' type={'hidden'} id='csrf_token_field' name='_token' disabled={this.state.isSubmit}></input>
                                <input className='form-control' type={'hidden'} id='user_id_field' name='id_user' disabled={this.state.isSubmit}></input>

                                <div className="form-group">
                                    <label className="form-label">Link Shopee</label>
                                    <textarea name="shopeelink" id="shopeelink" className="form-control"
                                        placeholder="Enter link separate by comma" required style={{ height: 200 + 'px' }} disabled={this.state.isSubmit}></textarea>
                                </div>

                                <div className="d-flex justify-content-between mt-5">
                                    <a href="#" id='btnBack' className="btn btn-secondary">Back</a>
                                    <button type="submit" className="btn btn-success" disabled={this.state.isSubmit}>Save</button>
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


