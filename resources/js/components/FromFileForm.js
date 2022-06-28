import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import Swal from 'sweetalert2';

class FromFileForm extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            file: null,
            loading: 0,
            isSubmit: false
        }
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    async handleSubmit(event) {
        event.preventDefault();

        this.setState({ isSubmit: true });

        let formData = new FormData(document.querySelector("form[id='formScrap']"));

        let urlSuccess = document.getElementById('btnBack').getAttribute('href');

        await axios({
            method: "post",
            url: "/api/fromfile",
            data: formData,
            responseType: 'json'
        }).then(function (response) {
            console.log(response);

            if (response.data.RESULT == 'SUCCESS') {
                Swal.fire({
                    title: 'Success',
                    text: 'Data has been saved',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function () {
                    window.location.href = urlSuccess;
                }.bind(this));
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Data has not been saved',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(function () {
                    // do nothing                    
                }.bind(this));
            }

        }).catch(function (error) {
            // swal error
            console.log(error);
            Swal.fire({
                title: 'Error',
                text: 'Have an error! Please contact administrator!',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        });

        this.setState({ isSubmit: false });
        // clear form
        document.querySelector("form[id='formScrap']").reset();
    }

    render() {
        return (

            <div className="row" >
                <div className="col-md-12">
                    <div className="card">
                        <div className="card-body">
                            <form id='formScrap' onSubmit={this.handleSubmit} encType='mulipart/form-data'>
                                <input className='form-control' type={'hidden'} id='csrf_token_field' name='_token' disabled={this.state.isSubmit}></input>
                                <input className='form-control' type={'hidden'} id='user_id_field' name='id_user' disabled={this.state.isSubmit}></input>

                                <div className="form-group">
                                    <label className="form-label">File JSON</label>
                                    <input type="file" className="form-control" id="file" name="file[]" accept='application/json' required multiple />

                                </div>

                                <div className="d-flex justify-content-between mt-5">
                                    <a href="#" id='btnBack' className="btn btn-secondary">Back</a>
                                    <button type="submit" className="btn btn-success" disabled={this.state.isSubmit}>Save</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        )
    }


}

if (document.getElementById('from-file-form')) {
    ReactDOM.render(<FromFileForm />, document.getElementById('from-file-form'));
}