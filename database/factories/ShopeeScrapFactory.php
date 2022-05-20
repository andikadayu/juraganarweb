<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShopeeScrapFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_user' => 1,
            'date_scrape' => "2022-05-18",
            'url_scrape' => $this->faker->url(),
            'nama_produk' => $this->faker->streetName(),
            'deskripsi' => $this->faker->paragraphs(3, true),
            'cat1' => $this->faker->randomNumber(),
            'berat' => $this->faker->randomNumber(),
            'minimum_pemesanan' => $this->faker->randomNumber(),
            'nomor_etalase' => $this->faker->randomNumber(),
            'waktu_preorder' => $this->faker->randomNumber(),
            'kondisi' => 'Baik',
            'gambar1' => $this->faker->paragraphs(3, true),
            'video1' => $this->faker->paragraphs(3, true),
            'sku_name' => $this->faker->colorName(),
            'status' => 'Aktif',
            'jumlah_stok' => $this->faker->randomNumber(),
            'harga' => $this->faker->randomNumber(),
            'asuransi' => 'optional'
        ];
    }
}
