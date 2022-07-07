<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class TransaksiController extends Controller
{
    public function Index()
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-3ohM6SlVNhlkrs92DNBGVUoM';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            ),
            'customer_details' => array(
                'first_name' => 'budi',
                'last_name' => 'pratama',
                'email' => 'budi.pra@example.com',
                'phone' => '08111222333',
            ),
            "item_details"=> [
                [
                  "id"=> "a01",
                  "price"=> 7000,
                  "quantity"=> 1,
                  "name"=> "Apple"
                ],
                [
                  "id"=> "b02",
                  "price"=> 3000,
                  "quantity"=> 2,
                  "name"=> "Orange"
                ]
              ],
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return $snapToken;
    }

    // public function index(Request $request)
    // {
    // if(!empty($request->cookie('name'))){
    //     return $request->cookie('name');

    // }
    // return 'false';
    // }
}
