<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManageUserController extends Controller
{
    public function index(Request $request)
    {
        $data['users'] = User::cursorPaginate(10);
        return view('page.muser.index', $data);
    }

    public function add(Request $request)
    {
        $data['action'] = 'ADD';
        return view('page.muser.form', $data);
    }

    public function add_process(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'alamat' => ['required', 'string'],
            'no_telp' => ['required', 'string'],
        ]);
        $insert = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'alamat' => $request->input('alamat'),
            'no_telp' => $request->input('no_telp'),
            'role' => $request->input('role'),
            'is_active' => 0
        ]);
        if ($insert) {
            return redirect('manage-user')->with('status', 'success insert data');
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
    }

    public function edit($id)
    {
        $data['action'] = 'EDIT';
        $data['user'] = User::find($id);
        return view('page.muser.form', $data);
    }

    public function edit_process(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_telp' => ['required', 'string'],
        ]);

        $update = User::findOrFail($id);

        if ($request->input('password') != '') {
            $update->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'alamat' => $request->input('alamat'),
                'no_telp' => $request->input('no_telp'),
                'role' => $request->input('role'),
            ]);
        } else {
            $update->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'alamat' => $request->input('alamat'),
                'no_telp' => $request->input('no_telp'),
                'role' => $request->input('role'),
            ]);
        }
        if ($update) {
            return redirect('manage-user')->with('status', 'success update data');
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
    }

    public function delete_process(Request $request)
    {
        $id = $request->input('id');

        $delete = User::find($id)->delete();
        if ($delete) {
            return json_encode(['MESSAGE' => 'Data Berhasil Dihapus', 'RESULT' => 'OK']);
        } else {
            return json_encode(['MESSAGE' => 'Data Gagal Dihapus', 'RESULT' => 'FAILED']);
        }
    }
    public function activate_process(Request $request)
    {
        $id = $request->input('id');

        $find = User::find($id);

        $find->is_active = 1;

        $status = $find->save();

        if ($status) {
            return json_encode(['MESSAGE' => 'Data Berhasil DiAktifkan', 'RESULT' => 'OK']);
        } else {
            return json_encode(['MESSAGE' => 'Data Gagal DiAktifkan', 'RESULT' => 'FAILED']);
        }
    }
    public function deactivate_process(Request $request)
    {
        $id = $request->input('id');

        $find = User::find($id);

        $find->is_active = 0;

        $status = $find->save();

        if ($status) {
            return json_encode(['MESSAGE' => 'Data Berhasil DiNonAktifkan', 'RESULT' => 'OK']);
        } else {
            return json_encode(['MESSAGE' => 'Data Gagal DiNonAktifkan', 'RESULT' => 'FAILED']);
        }
    }
}
