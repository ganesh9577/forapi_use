<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Booking;
use App\Models\Game;
use App\Models\GameTable;
use App\Models\VendorImages;
class VendorApiController extends Controller
{
    //

        //
        public function getallvendor(){
            $vdetails = Vendor::leftjoin('vendor_images','vendor_images.vendor_id','=','vendors.id')
            ->get([
                "vendors.id",
                "vendors.shop_name",
                // "vendors.shop_address",
                "vendors.shop_city",
                "vendors.shop_state",
                // "vendors.shop_country",
                "vendors.shop_pincode",
                // "vendors.shop_discription",
                "vendor_images.image_path",
            ]);
    
            return $vdetails;
    
        }
        public function selectedvendor($id){
            // $svendor = Vendor::where('id',$id)->get();
    
            $selectv = Vendor::join('vendor_images','vendor_images.vendor_id','=','vendors.id')
            ->where('vendors.id',$id)
            ->select([
                'vendors.id as vendor_id',
                'vendor_images.id as images_id',
                'vendors.shop_name',
                'vendors.shop_address',
                'vendors.shop_city',	
                'vendors.shop_state',
                'vendors.shop_country',
                'vendors.shop_pincode',
                'vendors.shop_description',
                'vendors.opening_time',
                'vendors.closing_time',
                'vendor_images.image_path'
                
            ])
            ->get();
            $games = game::select([
                'id',
                'game_name',
                'game_image',
            ])->get();
            $aa = [$selectv,$games];
    
            // $games = table::join('games','games.vendor_id','=','tables','tables.')
            return $aa;
            // return $selectv;
    
        }
    
        //after selcting perticulat games
        public function selectedgame($gameid){
            // echo "hello";
            $selectgames = game::where('id',$gameid)->get([
                'id as gameid',
                'game_name',
                'game_image'
            ]);
            // // add vendor id
            return $selectgames;
        }
    
        //selected games and view table 
        public function gettablesbygame($gameid,$vid){
            $tableview = GameTable::where('game_id',$gameid)
            ->where('game_tables.vendor_id',$vid)->get([
                'game_tables.id as table_id',
                'vendor_id',
                'game_id',
                'table_name',
                'table_image',
                'slot_duration',
                'per_slot_price',
                'table_description'
            ]);
            
            return $tableview;
        }
    
        //selected table data view
        public function selectedtable($id){
    
            $selecttable = GameTable::join('vendors', 'vendors.id', '=', 'game_tables.vendor_id')
            ->join('games', 'games.id', '=', 'game_tables.game_id')
            ->where('game_tables.id', $id)
            ->select(['game_tables.id as table_id',
            'game_tables.vendor_id',
            'vendors.shop_name',
            'vendors.opening_time',
            'vendors.closing_time',
            'game_tables.game_id',
            'games.game_name',
            'game_tables.table_name',
            'game_tables.table_image',
            'game_tables.slot_duration',
            'game_tables.per_slot_price',
            'game_tables.table_description'])
            ->get();
            return $selecttable;
        }
    
        //psot api fro booking
        public function booking(Request $request){
            // $rule = [
            //     'name'=> 'required',
            //     'email' => 'required|email',
            //     'phone' => 'required|min:10|max:12',
            //     'table_id' => 'required',
            //     'no_of_person' => 'required|max:10',
            //     'select_slot' => 'required',
            //     'date' => 'required',
            // ];
    
            // $custommassage = [
            //     'name.required' => ' name is required',
            //     'email.required' => 'email is required',
            //     'email.email' => 'enter right email ',
            //     'phone.required' => 'phone is required',
            //     'phone.min' => 'phone number mininum 10 is required',
            //     'phone.max' => 'phone number maximum 12  allowed',
            //     'table_id.required' => 'table_id is required',
            //     'no_of_person.required' => 'no_of_person is required',
            //     'no_of_person.max' => 'maximum 10 person allowed',
            //     'select_slot.required' => 'select_slot is required',
            //     'date.required' => 'date is required',
            // ];
    
        try {
            $booking = new Booking;
            $booking->user_id = $request->input('user_id');
            $booking->user_email = $request->input('user_email');
            $booking->user_phone = $request->input('user_phone');
            $booking->vendor_id = $request->input('vendor_id');
            $booking->table_id = $request->input('table_id');
            $booking->person = $request->input('person');
            $booking->slot_time = $request->input('slot_time');
            $booking->booking_date = $request->input('booking_date');
            $booking->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Booking created successfully.',
                'data' => $booking
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error creating booking.',
                'error' => $e->getMessage()
            ], 500);
        }
        }
        public function showbooking($id){
            $bookdata = booking::join('game_tables', 'game_tables.id', '=', 'bookings.table_id')
                ->join('games', 'games.id', '=', 'game_tables.game_id')
                ->where('user_id', $id)
                ->select([
                "bookings.id",
                "bookings.user_id",
                "bookings.user_email",
                "bookings.user_phone",
                // "bookings.vendor_id",
                // "bookings.table_id",
                "bookings.person",
                "bookings.slot_time",
                "bookings.booking_date",
                'game_tables.table_name',
                'game_tables.table_image',
                'games.game_name',
                'game_tables.per_slot_price'
                ])
                ->get();
        
            return $bookdata;
        }
    
}
