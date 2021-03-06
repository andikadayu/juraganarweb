<?php

namespace App\Http\Controllers;

use App\Models\ShopeeScrap;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;


class APIController extends Controller
{
    public function scrapping(Request $request)
    {
        $shopeelink = $request->input('shopeelink');
        $id_user = $request->input('id_user');
        $dateNow = date('Y-m-d');
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
        $values = stripslashes(str_replace('"', '', $shopeelink));
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
            try {
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
                    return json_encode(['status' => 'OK']);
                }
            } catch (Exception $ex) {
                return json_encode(['status' => 'FAILED']);
            }
        } else {
            return json_encode(['status' => 'FAILED']);
        }
    }

    public function fromfile(Request $request)
    {
        $id_user = $request->input('id_user');
        $dateNow = date('Y-m-d');
        if ($request->hasFile('file')) {
            $files = $request->file('file');
            foreach ($files as $file) {
                // read file json
                $jsons = json_decode(file_get_contents($file));
                foreach ($jsons as $json) {

                    $nama = str_replace("'", "", $json->name);
                    $deskripsi = str_replace("'", "", $json->description);
                    $catid = 0;
                    $kondisi = 'Baru';
                    $status =  'Aktif';
                    $stok = $json->stock;
                    $harga = $json->price;
                    $gambar1 = json_encode($json->images);
                    $video1 = null;
                    $sku = $this->generateSKU($nama);
                    $linkss = "https://shopee.co.id/" . str_replace(" ", "-", $nama);
                    $berat = 0;
                    $min = 1;
                    $etalase = NULL;
                    $preorder = 1;
                    $asuransi = "optional";
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
                }
            }
            return json_encode(['RESULT' => 'SUCCESS']);
        } else {
            return json_encode(['RESULT' => 'FAILED']);
        }
    }

    public function beta(Request $request)
    {
        // $url = $request->get('url');
        $url = "xh-m601-Papan-Modul-Kontrol-Charger-12V-i.41253123.1004457341.sp_atk=66a6a812-6401-4e22-bfd4-5257deac547b";
        $http = Http::get("https://shopee.co.id/$url");
        if ($http->successful()) {
            $html = $http->body();
            dd($html);
        }
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

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        if ($email == null || $password == null) {
            $data['error'] = true;
            $data['error_msg'] = "Invalid Parameter";
        } else {
            $user = User::where('email', '=', $email)
                ->where('is_active', '=', 1);
            if ($user->count() > 0) {
                $row = $user->first();
                if (Hash::check($password, $row->password)) {
                    $data['error'] = false;
                    $data['error_msg'] = null;
                    $data['data'] = ["name" => $row->name, "email" => $row->email, "id" => Crypt::encryptString($row->id)];
                } else {
                    $data['error'] = true;
                    $data['error_msg'] = "Password Invalid";
                }
            } else {
                $data['error'] = true;
                $data['error_msg'] = "Email Invalid or User not Active";
            }
        }
        $response = json_encode($data, JSON_PRETTY_PRINT);

        return response($response, 200)
            ->header('Content-Type', 'application/json');
    }

    public function cekAktif(Request $request)
    {
        $id = $request->input('id');
        if ($id == null) {
            $data['error'] = true;
            $data['error_msg'] = "Invalid Parameter";
        } else {
            $user = User::where('id', '=', Crypt::decryptString($id))
                ->where('is_active', '=', 1)
                ->count();
            if ($user > 0) {
                $data['error'] = false;
                $data['error_msg'] = null;
            } else {
                $data['error'] = true;
                $data['error_msg'] = "User Not Active";
            }
        }

        $response = json_encode($data, JSON_PRETTY_PRINT);

        return response($response, 200)
            ->header('Content-Type', 'application/json');
    }

    public function getData(Request $request)
    {
        $id = $request->input('id');
        $date = $request->input('date');
        if ($id == null && $id == null) {
            $data['error'] = true;
            $data['error_msg'] = "Invalid Parameter";
        } else {
            if (!is_numeric($id)) {
                $id = Crypt::decryptString($id);
                if ($date != null) {
                    $all = ShopeeScrap::select("url_scrape", "nama_produk", "deskripsi", "cat1", "berat", "minimum_pemesanan", "nomor_etalase", "waktu_preorder", "kondisi", "gambar1", "video1", "sku_name", "status", "jumlah_stok", "harga", "asuransi")
                        ->where('id_user', '=', $id)
                        ->where('date_scrape', '=', $date)
                        ->get();
                    $count = ShopeeScrap::where('id_user', '=', $id)->where('date_scrape', '=', $date)->count();
                } else {
                    $all = ShopeeScrap::select("url_scrape", "nama_produk", "deskripsi", "cat1", "berat", "minimum_pemesanan", "nomor_etalase", "waktu_preorder", "kondisi", "gambar1", "video1", "sku_name", "status", "jumlah_stok", "harga", "asuransi")
                        ->where('id_user', '=', $id)
                        ->get();
                    $count = ShopeeScrap::where('id_user', '=', $id)->count();
                }

                $data['error'] = false;
                $data['error_msg'] = null;
                $data['count'] = $count;
                $data['data'] = $all;
            } else {
                $data['error'] = true;
                $data['error_msg'] = "Paramater is Invalid";
            }
        }

        $response = json_encode($data, JSON_PRETTY_PRINT);

        return response($response, 200)
            ->header('Content-Type', 'application/json');
    }
}
