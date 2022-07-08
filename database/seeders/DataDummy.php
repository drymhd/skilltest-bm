<?php

namespace Database\Seeders;

use App\Models\Meja;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\TransaksiMenu;
use App\Models\TypeHalamanMeja;
use App\Models\TypeMeja;
use App\Models\TypeMenu;
use Illuminate\Database\Seeder;
use Str;

class DataDummy extends Seeder
{

    public function run()
    {
        $type_menu = [
            [
                "nm_type" => 'makanan berat'
            ],
            [
                "nm_type" => 'snack'
            ],
            [
                "nm_type" => 'minuman'
            ],
        ];
        $type_meja = [
            [
                "nm_type_meja" => 'single'
            ],
            [
                "nm_type_meja" => 'couple'
            ],
            [
                "nm_type_meja" => 'grub besar'
            ],
        ];
        $type_hal_meja = [
            [
                "nm_halaman_meja" => 'teras'
            ],
            [
                "nm_halaman_meja" => 'in door'
            ],
            [
                "nm_halaman_meja" => 'out door'
            ],
        ];



        $menu = [
            [
                "foto" => "ayam.png",
                "nama" => "ayam goreng",
                "harga" => 10000,
                "type_id" => "1"
            ],
            [
                "foto" => "burger.png",
                "nama" => "burger",
                "harga" => 12000,
                "type_id" => "2"
            ],
            [
                "foto" => "es teh.png",
                "nama" => "es teh",
                "harga" => 5000,
                "type_id" => "3"
            ],
            [
                "foto" => "esjeruk.png",
                "nama" => "es jeruk",
                "harga" => 5000,
                "type_id" => "3"
            ],
            [
                "foto" => "jamur.png",
                "nama" => "jamur krispi",
                "harga" => 8000,
                "type_id" => "2"
            ],
            [
                "foto" => "jus.png",
                "nama" => "jus",
                "harga" => 70000,
                "type_id" => "3"
            ],
            [
                "foto" => "kebab.png",
                "nama" => "kebab turki",
                "harga" => 10000,
                "type_id" => "2"
            ],
            [
                "foto" => "kentang.png",
                "nama" => "ayam goreng",
                "harga" => 10000,
                "type_id" => "2"
            ],
            [
                "foto" => "kopi.png",
                "nama" => "ayam goreng",
                "harga" => 4000,
                "type_id" => "3"
            ],
            [
                "foto" => "nasgor.png",
                "nama" => "nasi goreng",
                "harga" => 13000,
                "type_id" => "1"
            ],
            [
                "foto" => "sirup.png",
                "nama" => "Es sirup",
                "harga" => 5000,
                "type_id" => "3"
            ],
            [
                "foto" => "sosis.png",
                "nama" => "sosis bakar",
                "harga" => 10000,
                "type_id" => "2"
            ],
            [
                "foto" => "spageti.png",
                "nama" => "spageti",
                "harga" => 15000,
                "type_id" => "1"
            ],
        ];


        for ($i=0; $i < count($type_meja); $i++) { 
            TypeMeja::create($type_meja[$i]);
            TypeMenu::create($type_menu[$i]);
            TypeHalamanMeja::create($type_hal_meja[$i]);
        }
        
        
        for ($i=1; $i <= 30; $i++) { 
            Meja::create([
                'no_meja' => $i,
                'type_meja_id' => rand(1,3),
                'hal_meja_id' => rand(1,3), 
            ]);
        }
        for ($i=0; $i < count($menu); $i++) { 
            Menu::create($menu[$i]);
        }

        for ($i=0; $i < 5; $i++) { 
            Transaksi::create( [
                "kd_transaksi" => rand(),
                "nama_pembeli" => "dary ". Str::random(5),
                "tgl_transaksi" => date('Y-m-d'),
                "phone" => "0819219090",
                "c_pelanggan" => Str::random(40),
                "meja_id" => rand(1,3),
                "type_transaksi" => "tunai",
                "status" => "2",
            
        ]);
        }

        for ($i=1; $i <= 30; $i++) { 
            TransaksiMenu::create([
                "menu_id" => rand(1,13),
                "transaksi_id" => rand(1,5),
                "total_menu" => rand(1,5),
                "harga_menu" => 10000,
            ]);
        }
    }
}
