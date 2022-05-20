@extends('layouts.master')
@section('header','Manage Users')
@section('users-active','active')

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
                <a href="{{ url()->current().'/add' }}" class="btn btn-success"><i class="fa fa-plus"></i> Add Users</a>
                <div class="table-responsive mt-3">
                    <table class="table table-hover table-bordered" style="white-space: nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Telp</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach ($users as $user)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->no_telp}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->alamat}}</td>
                                <td>
                                    @if ($user->is_active == 0)
                                    <span class="badge rounded-pill bg-danger">Not Active</span>
                                    @else
                                    <span class="badge rounded-pill bg-success">Active</span>
                                    @endif
                                </td>
                                <td>{{$user->role}}</td>
                                <td>
                                    <a class="btn btn-sm btn-warning"
                                        href="{{ url()->current().'/edit/'.$user->id }}"><i class="fa fa-edit"></i></a>
                                    <button class="btn btn-sm btn-danger" type="button"
                                        onclick="deleteData({{$user->id}})"><i class="fa fa-trash"></i></button>
                                    @if ($user->is_active == 0)
                                    <button class="btn btn-sm btn-success" type="button"
                                        onclick="activateData({{$user->id}})"><i class="fa fa-check"></i></button>
                                    @else
                                    <button class="btn btn-sm btn-secondary" type="button"
                                        onclick="deactivateData({{$user->id}})"><i class="fa fa-ban"></i></button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 mb-2 d-flex justify-content-end">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!--//app-card-->
@endsection
@section('js')
<script>
    function deleteData(id) {
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
                        id: id
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
    function activateData(id) {
        swal({
            title: 'Apakah anda yakin?',
            text: `aktivasi data ini`,
            icon: 'warning',
            buttons: true,
            dangerMode: true
        }).then(isAccepted => {
            if (isAccepted) {
                $.ajax({
                    url: "{{url()->current().'/activate'}}",
                    headers:{
                        'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        id: id
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
    function deleteData(id) {
        swal({
            title: 'Apakah anda yakin?',
            text: `menonaktifkan data ini`,
            icon: 'warning',
            buttons: true,
            dangerMode: true
        }).then(isAccepted => {
            if (isAccepted) {
                $.ajax({
                    url: "{{url()->current().'/deactivate'}}",
                    headers:{
                        'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        id: id
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