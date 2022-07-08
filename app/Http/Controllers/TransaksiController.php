<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiMenu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class TransaksiController extends Controller
{

  public function done(Request $request)
  {
    $data = Transaksi::where('token', $request->data)->first();
    $data->update(['status' => '1']);

    return 'sukses';
  }

  public function kasirUpdate(Request $request)
  {
    $data = Transaksi::where('id', $request->data)->first();
    $data->update(['status' => '1']);

    return 'sukses';
  }
    public function Index(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {
          // Set Request Per Page
          $per = (($request->per) ? $request->per : 10);
          
          $id = $request->cookie('id');

          // Get User By Search And Per Page
          $user = Transaksi::with('meja')->where('c_pelanggan', $id)->where(function($q) use ($request) {
              $q->where('kd_transaksi', 'LIKE', '%'.$request->search.'%');
          })->orderBy('id','asc')->paginate($per);

          // Add Columns
          $user->map(function($a) {
            if($a->status == 0){
              if($a->type_transaksi == 'tunai'){
                $a->statusT = 'silahkan bayar di kasir';
              } else {
                  $a->action = '<span class="btn btn-sm btn-clean btn-icon btn-outline-danger btn-icon-md delete" title="Detail" data-id="'.$a->token.'">bayar</span>';
                  $a->statusT = 'silahkahkan bayar terlebih dahulu';
                }
              } else {
                $a->statusT = 'pesanan sedang di proses';
              }
              return $a;
          });
          return response()->json($user);

      }else{
          abort(404);
      }


    }
    public function kasirIndex(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {
          // Set Request Per Page
          $per = (($request->per) ? $request->per : 10);
          
          $id = $request->cookie('id');

          // Get User By Search And Per Page
          $user = Transaksi::with('meja')->where(function($q) use ($request) {
              $q->where('kd_transaksi', 'LIKE', '%'.$request->search.'%');
          })->orderBy('id','asc')->paginate($per);

          // Add Columns
          $user->map(function($a) {
            if($a->status == 0){
              if($a->type_transaksi == 'tunai'){
                $a->statusT = 'silahkan bayar di kasir';
                $a->action = '<span class="btn btn-sm btn-clean btn-icon btn-outline-danger btn-icon-md delete" title="Detail" data-id="'.$a->id.'">sudah bayar</span>';
              } else {
                $a->statusT = 'belum membayar';
              }
            } else {
                $a->statusT = 'pesanan sedang di proses';
              }
              return $a;
          });
          return response()->json($user);

      }else{
          abort(404);
      }


    }


    public function transaksi(Request $request)
    {
      $dataKeranjang = [];
      $pelanggan = $request->cookie('id');
      
      for ($i=0; $i < count($request->data); $i++) { 
        $data = ['id' => $request->data[$i]['id'],
                  'price' => $request->data[$i]['harga'],
                  'quantity' => $request->data[$i]['qty'],
                  'name' => $request->data[$i]['nama']];

        array_push($dataKeranjang, $data);
      }



      $rand = rand();

      if($request->form['type'] != 'tunai'){
        
        \Midtrans\Config::$serverKey = 'SB-Mid-server-3ohM6SlVNhlkrs92DNBGVUoM';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
  
        $params = array(
            'transaction_details' => array(
                'order_id' => $rand,
                'gross_amount' => 10000,
            ),
            'customer_details' => array(
                'first_name' => $request->form['nama'],
                'phone' => $request->form['phone'],
            ),
           "item_details" => $dataKeranjang
        );
  
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $datat = [
          "nama_pembeli" => $request->form['nama'],
          "phone" => $request->form['phone'],
          "type_transaksi" => 'non tunai',
          "alamat" => $request->form['alamat'],
          "tgl_transaksi" => date("Y-m-d"),
          "kd_transaksi" => $rand,
          "token" => $snapToken,
          'meja_id' => $request->form['meja'],
          'c_pelanggan' => $pelanggan
        ];
      } else {
        $datat = [
          "nama_pembeli" => $request->form['nama'],
          "phone" => $request->form['phone'],
          "alamat" => $request->form['alamat'],
          "tgl_transaksi" => date("Y-m-d"),
          "kd_transaksi" => $rand,
          "type" => $request->form['type'],
          'c_pelanggan' => $pelanggan,
          'meja_id' => $request->form['meja']
        ];
      }


      

      $transaksi = Transaksi::create($datat);

      for ($i=0; $i < count($dataKeranjang); $i++) { 
        TransaksiMenu::create([
          "menu_id" => $dataKeranjang[$i]['id'],
          "transaksi_id" => $transaksi->id,
          "total_menu" => $dataKeranjang[$i]['quantity'],
          "harga_menu" => $dataKeranjang[$i]['price']
        ]);
      }

      $dt = json_encode(['data' => []]);

      $response = new Response('sukses');
      $response->withCookie(cookie()->forever('keranjang', $dt));
      

      return $response;
    }
    // public function index(Request $request)
    // {
    // if(!empty($request->cookie('name'))){
    //     return $request->cookie('name');

    // }
    // return 'false';
    // }
}
