<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;
use App\Mail\AddVendorMail;
use Auth;
class LoginApicontroller extends Controller
{
    //
    //new
    //if insert email and name than register and if enter email and otp than login two function in one api
    public function login(Request $request)
{
    if ($request->isMethod('POST')) {
        $data = $request->all();

        if (isset($data['otp'])) {
            // OTP verification
            $user = User::where('email', $data['email'])->first();

            // Check if the user exists and the provided OTP matches
            if ($user && $data['otp'] == $user->password && $user->status == 1) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successful.'
                ], 200);
            } else {
                // Authentication failed
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid email or OTP. Please check.',
                ], 401);
            }
        } else {
            // Create new user
            $userdata = new User;
            $userdata->name = $data['name'];
            $userdata->email = $data['email'];
            $userdata->password = rand(999, 9999);
            $userdata->status = 1;
            $userdata->save();

            $maildata = [
                'title' => 'Your Vendor Id And Password',
                'username' => $userdata->email,
                'body' => $userdata->password
            ];
            Mail::to($request->email)->send(new AddVendorMail($maildata));

            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully.',
                'data' => $userdata
            ], 200);
        }
    }
}


}
