@extends('layouts.master')
@section('header',"$action Users")
@section('users-active','active')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" autocomplete="off" action="{{url()->current().'/process'}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" id="name"
                                    value="<?= ($action == 'EDIT') ? $user->name : null ?>" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email"
                                    value="<?= ($action == 'EDIT') ? $user->email : null ?>" id="email"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Alamat</label>
                                <input type="text" name="alamat"
                                    value="<?= ($action == 'EDIT') ? $user->alamat : null ?>" id="alamat"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">No Telp</label>
                                <input type="number" name="no_telp"
                                    value="<?= ($action == 'EDIT') ? $user->no_telp : null ?>" id="no_telp"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="user" @if($action=='EDIT' && $user->role == 'user')
                                        {{__('selected')}} @endif>User</option>
                                    <option value="superadmin" @if($action=='EDIT' && $user->role == 'superadmin')
                                        {{__('selected')}} @endif>SuperAdmin</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" id="password" minlength="8" class="form-control"
                                    autocomplete="new-password" @if ($action=='ADD' ) {{__('required')}} @endif>
                                @if ($action=='EDIT')
                                <small>* Leave Blank if you dont change</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-5">
                        <a href="{{route('users')}}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!--//app-card-->
@endsection
@section('js')
<script>

</script>
@endsection