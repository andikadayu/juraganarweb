@extends('layouts.master')
@section('header','Rumus')
@section('rumus-active','active')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Form Tambah Rumus
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="card">
                            <div class="card-body">
                                @if (session('status'))
                                <div class="alert alert-info">
                                    {{ session('status') }}
                                </div>
                                @endif
                                <form action="{{route('add_rumus')}}" method="post" autocomplete="off"
                                    aria-autocomplete="none">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Minimal Harga</label>
                                                <input type="number" name="start_range" id="start_range"
                                                    class="form-control" required aria-required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Maksimal Harga</label>
                                                <input type="number" name="end_range" id="end_range"
                                                    class="form-control" required aria-required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Nilai Keuntungan</label>
                                                <input type="text" name="nilai_murah" id="nilai_murah"
                                                    class="form-control" required aria-required="true">
                                                <small>*tambahkan simbol % untuk nilai persen contoh 10%</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Metode</label>
                                                <select name="metode_murah" id="metode_murah" class="form-select"
                                                    required>
                                                    <option value="murah" selected>Murah</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Nilai Keuntungan</label>
                                                <input type="text" name="nilai_sedang" id="nilai_sedang"
                                                    class="form-control" required aria-required="true">
                                                <small>*tambahkan simbol % untuk nilai persen contoh 10%</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Metode</label>
                                                <select name="metode_sedang" id="metode_sedang" class="form-select"
                                                    required>
                                                    <option value="sedang" selected>Sedang</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Nilai Keuntungan</label>
                                                <input type="text" name="nilai_mahal" id="nilai_mahal"
                                                    class="form-control" required aria-required="true">
                                                <small>*tambahkan simbol % untuk nilai persen contoh 10%</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Metode</label>
                                                <select name="metode_mahal" id="metode_mahal" class="form-select"
                                                    required>
                                                    <option value="mahal" selected>Mahal</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-2">
            <div class="card-body">
                <div class="card-title">Data Rumus</div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="white-space: nowrap;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Min Harga</th>
                                <th>Max Harga</th>
                                <th>Nilai Murah</th>
                                <th>Nilai Sedang</th>
                                <th>Nilai Mahal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach ($rumus as $rms)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$rms->start_range}}</td>
                                <td>{{$rms->end_range}}</td>
                                <td>{{$rms->murah}}</td>
                                <td>{{$rms->sedang}}</td>
                                <td>{{$rms->mahal}}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger"
                                        onclick="deleteData('{{$rms->start_range}}','{{$rms->end_range}}')">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 mb-2 d-flex justify-content-end">
                    {{ $rumus->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!--//app-card-->
@endsection
@section('js')
<script type="text/javascript">
    function deleteData(start_range,end_range) {
    swal({
        title: 'Apakah anda yakin?',
        text: `menghapus data ini`,
        icon: 'warning',
        buttons: true,
        dangerMode: true
    }).then(isAccepted => {
        if (isAccepted) {
            $.ajax({
                url: "{{route('delete_rumus')}}",
                headers:{
                    'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                dataType: 'json',
                data: {
                    start_range: start_range,
                    end_range: end_range
                },
                success: function(response) {
                    if (response.RESULT == 'OK') {
                        return swalMessageSuccess(response.MESSAGE, ok => {
                            return window.location.reload();
                        });
                    } else {
                        return swalMessageFailed(response.MESSAGE);
                    }
                }
            }).fail(function() {
                return swalError();
            })
        }
    })
  }
</script>
@endsection