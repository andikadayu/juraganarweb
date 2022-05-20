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
                                <th>Action</th>
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
                                    <button class="btn btn-sm btn-danger">Delete</button>
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