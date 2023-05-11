<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use PhpParser\Node\Scalar\MagicConst\Method;

class ProfileApiController extends Controller
{
    //
    public function profileview($id,Request $request){
        $data = $request->all();
        // $validated = $request->validate([
        //     'shop_name' => 'required',
        //     'shop_address' => 'required',
        //     'shop_city' => 'required',
        //     'shop_state' => 'required',
        //     'shop_country' => 'required',
        //     'shop_pincode' => 'required',
        //     'shop_description' => 'required',

        // ]);
        if ($data) {
            User::where('id',$id)
                ->update([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    // 'password' => $data['password'],
                    'phone' => $data['phone'],
                    'image' => $data['image'],
                    'gender' => $data['gender'],
                    'dob' => $data['dob'],
                    'city' => $data['city']
                ]);
            // return redirect()->back()->with('success_b_message', 'Your Personal Details are updated successfully!!');
                return response()->json([
                'status' => 'success',
                'message' => 'update data  successfully.',
                'data' => $data
                ], 200);
        }
        return User::where('id',$id)->get();
    }
}
