<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopeeScrap extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'table_shopeescrap';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user',
        'date_scrape',
        'url_scrape',
        'nama_produk',
        'deskripsi',
        'cat1',
        'berat',
        'minimum_pemesanan',
        'nomor_etalase',
        'waktu_preorder',
        'kondisi',
        'gambar1',
        'video1',
        'sku_name',
        'status',
        'jumlah_stok',
        'harga',
        'asuransi'
    ];
}
