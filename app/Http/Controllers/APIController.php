<?php

namespace App\Http\Controllers;

use App\Models\ShopeeScrap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class APIController extends Controller
{
    public function scrapping(Request $request)
    {
        $shopeelink = $request->input('shopeelink');
        $id_user = $request->input('id_user');
        $dateNow = date('Y-m-d');
        $arrlink = explode(',', $shopeelink);
        $nama = NULL;
        $deskripsi = NULL;
        $catid = 0;
        $berat = 0;
        $min = 1;
        $etalase = NULL;
        $preorder = 1;
        $kondisi = "Baru";
        $gambar1 = NULL;
        $video1 = NULL;
        $sku = NULL;
        $status = "Aktif";
        $stok = 12;
        $harga = 12000;
        $asuransi = "optional";
        $linkss = null;
        $successCount = 0;
        $countAll = count($arrlink);
        foreach ($arrlink as $key => $valued) {
            $values = stripslashes(str_replace('"', '', $valued));
            $vals = str_replace('?', '.', $values);
            $param = explode('-i.', $vals);
            $params = explode('.', $param[1]);
            $shop_id = $params[0];
            $item_id = $params[1];

            $response = Http::accept('application/json')->get('https://shopee.co.id/api/v4/item/get', [
                'shopid' => $shop_id,
                'itemid' => $item_id
            ]);

            if ($response->successful()) {
                $json = (object)$response->json('data');

                $nama = str_replace("'", "", $json->name);
                $deskripsi = str_replace("'", "", $json->description);
                $catid = $json->catid;
                $kondisi = ($json->condition) ? 'Baru' : 'Bekas';
                $status = ($json->status) ? 'Aktif' : 'Nonaktif';
                $stok = $json->stock;
                $harga = substr($json->price_max, 0, -5);
                $gambar1 = json_encode($json->images);
                $video1 = ($json->video_info_list != '') ? json_encode($json->video_info_list) : null;
                $sku = $this->generateSKU($nama);
                $linkss = "https://shopee.co.id/" . str_replace(" ", "-", $nama) . "-i." . $json->shopid . "." . $json->itemid;

                $insert = ShopeeScrap::insert([
                    'id_user' => $id_user,
                    'date_scrape' => $dateNow,
                    'url_scrape' => $linkss,
                    'nama_produk' => $nama,
                    'deskripsi' => $deskripsi,
                    'cat1' => $catid,
                    'berat' => $berat,
                    'minimum_pemesanan' => $min,
                    'nomor_etalase' => $etalase,
                    'waktu_preorder' => $preorder,
                    'kondisi' => $kondisi,
                    'gambar1' => $gambar1,
                    'video1' => $video1,
                    'sku_name' => $sku,
                    'status' => $status,
                    'jumlah_stok' => $stok,
                    'harga' => $harga,
                    'asuransi' => $asuransi
                ]);
                if ($insert) {
                    $successCount++;
                }
                sleep(1); // Default Sleep 1 Seconds
            }
        }

        return json_encode(['status' => 'OK', 'result' => "Scrap Done $successCount/$countAll Berhasil"]);
    }

    public function generateSKU($name)
    {
        $text = $name;
        $cleanspace = str_replace(" ", '', $text);
        $characters = preg_replace("/[^A-Za-z ]/", '', $cleanspace);
        $charactersLength = strlen($characters);
        $randomString = '';
        $length = 7;
        for ($nos = 0; $nos < $length; $nos++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return strtoupper($randomString) . '-' . rand(1111111, 9999999);
    }
}
