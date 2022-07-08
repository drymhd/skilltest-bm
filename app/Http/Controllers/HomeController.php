<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Menu;
use App\Models\TypeMenu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Str;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{


    public function favorit()
    {
        $data = Menu::withCount('Transaksi')->orderBy('transaksi_count', 'desc')->limit(10)->get();
        return response()->json(['data' => $data]);
    }

    public function Cookie(Request $request)
    {
        if(request()->cookie('id') == null){
            $keranjang = json_encode(['data' => []]);
            $response = new Response('credential');
            $response->withCookie(cookie()->forever('id', Str::random(40)))->withCookie(cookie()->forever('keranjang', $keranjang));
            return $response;
        } else {
            // $keranjang = json_encode(['jfsjkdbfskjdbf', 'jsbfkjbsk']);
            // $response = new Response('credential');
            // $response->withCookie(cookie()->forever('keranjang', $keranjang));
            return $request->cookie('keranjang');
        }
    }


    public function getMeja()
    {
        $data = Meja::with(['halaman', 'type'])->get();

        return response()->json(['data' => $data]);
    }

    public function keranjang(Request $request,$id)
    {
        $keranjang = json_decode($request->cookie('keranjang'));
        $arr = $keranjang->data;

        if(in_array($id, $arr)){
            return response()->json(['data' => 'data sudah ada'], 400);
        } else {
            array_push($arr, $id);
            $data = json_encode(['data'=>$arr]);
            $response = new Response('add');
            $response->withCookie(cookie()->forever('keranjang', $data));
            return $response;
        }
    }

    public function getKeranjang(Request $request)
    {
        $keranjang = json_decode($request->cookie('keranjang'));
        $arr = $keranjang->data;

        $data = Menu::with('type')->whereIn('id', $arr)->get();
        $data->map(function($q){
            $q->qty = 1;
        });
        $data->sortBy('type_id');

        return response()->json(['data' => $data]);
    }

    public function hapus(Request $request)
    {
        $kj = json_encode(['data' => $request->data]);
        $response = new Response('delete');
        $response->withCookie(cookie()->forever('keranjang', $kj));

        return $response;
        return $request->data;
    }

    public function index(Request $request)
    {

        if(count($request->data['type']) == 0){
            $data = Menu::with('type')->get();
            
        } else {
            $type = $request->data['type'];
            $data = Menu::with('type')->whereIn('type_id', $type)->get();
        }
        return response()->json(['data' => $data]);
    }

    public function getTypeMenu()
    {
        $data = TypeMenu::withCount('Menu')->get();
        return response()->json(['data' => $data]);
    }
}
