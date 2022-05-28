<?php

namespace App\Helpers;

use App\Models\Rumus;
use Illuminate\Support\Facades\Auth;

class RumusHarga
{
    public $setting;

    public function __construct($setting)
    {
        $this->setting = $setting;
    }

    private function nilaiRumus($metode, $harga)
    {
        $profit = 0;
        $result = Rumus::where('metode', '=', $metode)
            ->where('start_range', '<=', $harga)
            ->where('end_range', '>=', $harga)
            ->where('id_user', '=', Auth::user()->id);

        if ($result->count() > 0) {
            $res = $result->row();
            if (str_ends_with($res->nilai, '%')) {
                $pers = (int)str_replace('%', '', $res->nilai);
                $profit = (int)$harga * $pers / 100;
            } else {
                $profit = $res->nilai;
            }
        }

        return $profit;
    }

    private function nilaiMarkup($nilai, $harga)
    {
        $profit = 0;
        if (str_ends_with($nilai, '%')) {
            $pers = (int)str_replace('%', '', $nilai);
            $profit = (int)$harga * $pers / 100;
        } else {
            $profit = $nilai;
        }
        return $profit;
    }

    public function getHarga($harga)
    {
        $oriPrice = $harga;
        $n_markup = 0;
        $n_rumus = 0;
        if ($this->setting != null) {
            if ($this->setting->with_markup) {
                $n_markup = (int) $this->nilaiMarkup($this->setting->markup_value, $harga);
            }

            if ($this->setting->with_rumus) {
                $n_rumus = (int) $this->nilaiRumus($this->setting->rumus_value, $harga);
            }
        }

        return (int) $oriPrice + $n_markup + $n_rumus;
    }
}
