<?php

namespace App\Http\Controllers;

use App\Helpers\RumusHarga;
use Illuminate\Http\Request;
use App\Models\ShopeeScrap;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

class ShopeeScrapController extends Controller
{
    public function index(Request $request)
    {
        $data['shopee'] = DB::table('table_shopeescrap')
            ->select('id_user', 'date_scrape', DB::raw('count(*) as jumlah'))
            ->where('id_user', '=', Auth::user()->id)
            ->groupBy('date_scrape')
            ->orderBy('date_scrape', 'desc')
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

        $delete = ShopeeScrap::where('id_user', '=', $id_user)
            ->where('date_scrape', '=', $date_scrape)
            ->delete();

        if ($delete) {
            return json_encode(['MESSAGE' => 'Data Berhasil Dihapus', 'RESULT' => 'OK']);
        } else {
            return json_encode(['MESSAGE' => 'Data Gagal Dihapus', 'RESULT' => 'FAILED']);
        }
    }

    public function export(Request $request)
    {
        $date_scrape = $request->get('date_scrape');
        $id_user = Auth::user()->id;
        $nama_file = "ScrapData-$id_user-" . $date_scrape . '-' . date('Y-m-d');
        $setting = json_decode(Redis::get('user-' . Auth::user()->id . ':setting'));


        $count = ShopeeScrap::where('date_scrape', '=', $date_scrape)
            ->where('id_user', '=', $id_user)
            ->where('jumlah_stok', '>=', $setting->min_stok)
            ->where('harga', '>=', $setting->min_harga)
            ->count();

        $f = 0;

        while ($f < $count) {
            if ($f % 300 == 0) {
                $excel = ShopeeScrap::where('date_scrape', '=', $date_scrape)
                    ->where('id_user', '=', $id_user)
                    ->where('jumlah_stok', '>=', $setting->min_stok)
                    ->where('harga', '>=', $setting->min_harga)
                    ->offset($f)
                    ->limit(300)
                    ->get();

                $this->create_excel($f, $nama_file, $setting, $excel);
            }

            $f++;
        }

        // Delete File

        $zip = new \ZipArchive();
        $zip_file = public_path("assets/export/ScrapData-$id_user-" . date('Y-m-d') . '.zip');
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        foreach (glob(public_path("assets/export/$nama_file-*.xlsx")) as $downs) {
            $zip->addFile(realpath($downs), $downs);
        }
        $zip->close();
        foreach (glob(public_path("assets/export/$nama_file-*.xlsx")) as $downs) {
            unlink($downs);
        }

        return response()->download($zip_file)->deleteFileAfterSend();
    }

    public function create_excel($offset, $nama_file, $setting, $excel)
    {
        $rumus = new RumusHarga($setting);
        $reader = new Xlsx();
        $wb = $reader->load(public_path("assets/templetes.xlsx"));
        $sheet = $wb->getActiveSheet();
        $i = 4; // number first

        $nama_file .=  '-' . $offset . '.xlsx';

        foreach ($excel as $key => $value) {
            if ($value->gambar1 != "") {
                $items = json_decode($value->gambar1, true);
                $nog = count($items);
            }

            $name = substr(str_replace(explode("\n", $setting->remove_text), "", $setting->add_first_name . ' ' . $value->nama_produk . ' ' . $setting->add_last_name), 0, 70);
            $deskripsi = substr(str_replace(explode("\n", $setting->remove_text), "", $setting->add_first_description . ' ' . $value->deskripsi), 0, 2000);

            $sheet->setCellValue("A$i", null);
            $sheet->setCellValue("B$i", $name);
            $sheet->setCellValue("C$i", $deskripsi);
            $sheet->setCellValue("D$i", $setting->kategori);
            $sheet->setCellValue("E$i", $setting->berat);
            $sheet->setCellValue("F$i", $setting->min_pesan);
            $sheet->setCellValue("G$i", $setting->etalase);
            $sheet->setCellValue("H$i", $setting->preorder);
            $sheet->setCellValue("I$i", $value->kondisi);
            $sheet->setCellValue("J$i", ($nog >= 1 ? "https://f.shopee.co.id/file/" . $items[0] : ''));
            $sheet->setCellValue("K$i", ($nog >= 2 ? "https://f.shopee.co.id/file/" . $items[1] : ''));
            $sheet->setCellValue("L$i", ($nog >= 3 ? "https://f.shopee.co.id/file/" . $items[2] : ''));
            $sheet->setCellValue("M$i", ($nog >= 4 ? "https://f.shopee.co.id/file/" . $items[3] : ''));
            $sheet->setCellValue("N$i", ($nog >= 5 ? "https://f.shopee.co.id/file/" . $items[4] : ''));
            $sheet->setCellValue("O$i", null);
            $sheet->setCellValue("P$i", null);
            $sheet->setCellValue("Q$i", null);
            $sheet->setCellValue("R$i", $value->sku_name);
            $sheet->setCellValue("S$i", $value->status);
            $sheet->setCellValue("T$i", $value->jumlah_stok);
            $sheet->setCellValue("T$i", $rumus->getHarga($value->harga));
            $sheet->setCellValue("V$i", $value->asuransi);

            $i++;
        }

        $writer = new WriterXlsx($wb);
        $path = public_path("assets/export/$nama_file");
        $writer->save($path);
    }

    public function from_file(Request $request)
    {
        return view('page.scrapper.form_file');
    }
}
