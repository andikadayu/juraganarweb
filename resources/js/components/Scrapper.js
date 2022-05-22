import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import Swal from 'sweetalert2';


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
        Swal.showLoading();
        axios({
            method: "post",
            url: "/api/scrapping",
            data: formData,
            responseType: 'json'
        }).then(function (response) {
            Swal.close();
            console.log(response);
            if (response.data.status == 'OK') {
                Swal.fire({
                    title: 'Success',
                    text: response.data.result,
                    timer: 5000,
                    icon: 'success',
                });
                location.reload();
            } else {
                Swal.fire({
                    title: 'Failed',
                    text: response.data.result,
                    timer: 5000,
                    icon: 'error',
                });
                location.reload();
            }

        }).catch(function (error) {
            Swal.close();
            console.log(error);
            Swal.fire({
                title: 'Failed',
                text: 'Scrap has Error Occured',
                timer: 5000,
                icon: 'error',
            });
            // location.reload();
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
                                <input className='form-control' type={'hidden'} id='user_id_field' name='id_user'></input>

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


