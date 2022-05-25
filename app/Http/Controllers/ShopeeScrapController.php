<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopeeScrap;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShopeeScrapController extends Controller
{
    public function index(Request $request)
    {
        $data['shopee'] = DB::table('table_shopeescrap')
            ->select('id_user', 'date_scrape', DB::raw('count(*) as jumlah'))
            ->where('id_user', '=', Auth::user()->id)
            ->groupBy('date_scrape')
            ->orderBy('date_scrape')
            ->cursorPaginate(10);

        return view('page.scrapper.index', $data);
    }

    public function add(Request $request)
    {
        return view('page.scrapper.form');
    }

    public function delete(Request $request)
    {
        $date_scrape = $request->input('date_scrape');
        $id_user = Auth::user()->id;

        $delete = ShopeeScrap::where('id_user','=',$id_user)
        ->where('date_scrape','=',$date_scrape)
        ->delete();

        if ($delete) {
            return json_encode(['MESSAGE' => 'Data Berhasil Dihapus', 'RESULT' => 'OK']);
        } else {
            return json_encode(['MESSAGE' => 'Data Gagal Dihapus', 'RESULT' => 'FAILED']);
        }
    }
}
