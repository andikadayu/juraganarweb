@extends('layouts.master')
@section('header','Shopee Scrapper')
@section('shopee-active','active')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-info">
                    {{ session('status') }}
                </div>
                @endif
                <a href="{{ url()->current().'/add' }}" class="btn btn-success"><i class="fa fa-plus"></i> Scrape</a>
                <div class="table-responsive mt-3">
                    <table class="table table-hover table-bordered" style="white-space: nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th style="width: 20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach ($shopee as $shop)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$shop->date_scrape}}</td>
                                <td>{{$shop->jumlah}}</td>
                                <td>
                                    <button class="btn btn-sm btn-info"
                                        onclick="cetakData('{{$shop->date_scrape}}')">Cetak</button>
                                    <button class="btn btn-sm btn-danger"
                                        onclick="deleteData('{{$shop->date_scrape}}')">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 mb-2 d-flex justify-content-end">
                    {{ $shopee->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!--//app-card-->
@endsection
@section('js')
<script type="text/javascript">
    function deleteData(date_scrape) {
    swal({
        title: 'Apakah anda yakin?',
        text: `menghapus data ini`,
        icon: 'warning',
        buttons: true,
        dangerMode: true
    }).then(isAccepted => {
        if (isAccepted) {
            $.ajax({
                url: "{{url()->current().'/delete'}}",
                headers:{
                    'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                dataType: 'json',
                data: {
                    date_scrape: date_scrape
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

    function cetakData(date_scrape) {
        swal({
            title: 'Apakah anda yakin?',
            text: `mencetak data ini`,
            icon: 'info',
            buttons: true,
            dangerMode: false
        }).then(isAccepted => {
            if (isAccepted) {
                window.open("{{route('export')}}?date_scrape="+date_scrape,'_blank');
            }
        });
    }
</script>
@endsection