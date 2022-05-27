<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rumus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RumusController extends Controller
{
    public function index(Request $request)
    {
        $data['rumus'] = DB::table('table_rumus', 'a')
            ->select(DB::raw("a.start_range,a.end_range,(select nilai from table_rumus b where b.start_range = a.start_range and b.id_user = a.id_user and b.metode = 'murah' ) as murah,(select nilai from table_rumus b where b.start_range = a.start_range and b.id_user = a.id_user and b.metode = 'sedang' ) as sedang,(select nilai from table_rumus b where b.start_range = a.start_range and b.id_user = a.id_user and b.metode = 'mahal' ) as mahal"))
            ->where('a.id_user', '=', Auth::user()->id)
            ->groupBy('start_range', 'id_user')
            ->orderBy('end_range', 'asc')
            ->cursorPaginate(10);
        return view('page.rumus.index', $data);
    }

    public function add(Request $request)
    {
        $ins = [
            [
                'id_user' => Auth::user()->id,
                'start_range' => $request->input('start_range'),
                'end_range' => $request->input('end_range'),
                'nilai' => $request->input('nilai_murah'),
                'metode' => $request->input('metode_murah'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_user' => Auth::user()->id,
                'start_range' => $request->input('start_range'),
                'end_range' => $request->input('end_range'),
                'nilai' => $request->input('nilai_sedang'),
                'metode' => $request->input('metode_sedang'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_user' => Auth::user()->id,
                'start_range' => $request->input('start_range'),
                'end_range' => $request->input('end_range'),
                'nilai' => $request->input('nilai_mahal'),
                'metode' => $request->input('metode_mahal'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]

        ];
        $insert = Rumus::insert($ins);
        if ($insert) {
            return redirect('rumus')->with('status', 'success insert data');
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
    }

    public function delete(Request $request)
    {
        $start = $request->input('start_range');
        $end = $request->input('end_range');

        $delete = Rumus::where('start_range', '=', $start)
            ->where('end_range', '=', $end)
            ->where('id_user', '=', Auth::user()->id)
            ->delete();

        if ($delete) {
            return json_encode(['MESSAGE' => 'Data Berhasil Dihapus', 'RESULT' => 'OK']);
        } else {
            return json_encode(['MESSAGE' => 'Data Gagal Dihapus', 'RESULT' => 'FAILED']);
        }
    }
}
