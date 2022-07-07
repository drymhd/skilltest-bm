<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\TypeMenu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
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
