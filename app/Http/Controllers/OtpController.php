<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class OtpController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    public function index() {
        if (auth()->user()->otp_verified_at == null) {
            return view('otp_verification.index');
        } else {
            return redirect()->route('admin.index');
        }
    }
    public function otp_verify(Request $request) {
        $user = User::find(auth()->id());
        if ($user->otp->otp == $request->otp) {
            $user->update([
                'otp_verified_at' => now(),
            ]);

            UserOtp::where('user_id', auth()->id())->delete();
            session()->flash('success', 'OTP verification successfully!');
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'errors' => ['Invalid OTP.']]);
        }
    }

    public function resend() {
        $user = auth()->user();
        $number = $user->mobile;
        $message = "আপনার ওটিপি হল: " . bangla_digit($user->otp->otp);
        return send_sms($number, $message);
    }
}
