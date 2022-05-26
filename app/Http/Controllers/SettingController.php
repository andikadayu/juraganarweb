<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $data['setting'] = json_decode(Redis::get('user-' . Auth::user()->id . ':setting'));
        return view('page.setting.index', $data);
    }

    public function process(Request $request)
    {
        $data = [
            "add_first_name" => $request->input('add_first_name'),
            "add_last_name" => $request->input('add_last_name'),
            "add_first_description" => $request->input('add_first_description'),
            "add_last_description" => $request->input('add_last_description'),
            "remove_text" => $request->input('remove_text'),
            "preorder" => $request->input('preorder'),
            "etalase" => $request->input('etalase'),
            "kategori" => $request->input('kategori'),
            "with_markup" => ($request->input('with_markup')) ? true : false,
            "markup_value" => $request->input('markup_value'),
            "with_rumus" => ($request->input('with_rumus')) ? true : false,
            "rumus_value" => $request->input('rumus_value'),
            "berat" => $request->input('berat'),
            "min_pesan" => $request->input('min_pesan'),
            "min_stok" => $request->input('min_stok'),
            "min_harga" => $request->input('min_harga'),
        ];

        Redis::set('user-' . Auth::user()->id . ':setting', json_encode($data));

        return redirect()->back()->with('status', 'Setting Saved');
    }
}
