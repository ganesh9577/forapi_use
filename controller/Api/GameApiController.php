<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Vendor;

class GameApiController extends Controller
{
    //all games view

    public function all(){
        $games = game::all();
        return $games;
    }
    // search game
    public function searchdata($name){
        $datas = game::where("game_name","like","%".$name."%")->get();
        return $datas;
        // return "hello";
    }

    //serach by city name (select city ma)
    public function serachplace($name)
    {
        // echo "hello";
        // die();
        $searchplace = Vendor::where("shop_city","like","%".$name."%")->get();
        return $searchplace;
    }

    //this for home serach if serach city wish also serach by name vendor
    public function serachcityandname($name)
    {
        // $searchplace = Vendor::where("shop_city,","like","%".$name."%","or","shop_name,","like","%".$name."%")
        // ->where("shop_name,","like","%".$name."%")->get();

        $searchplace = Vendor::where(function($query) use ($name) {
            $query->where("shop_city", "like", "%".$name."%")
                  ->orWhere("shop_name", "like", "%".$name."%");
        })
        ->get();
        
        return $searchplace;
    }
}
