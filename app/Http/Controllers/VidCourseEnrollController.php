<?php

namespace App\Http\Controllers;

use App\Mail\OnlineCourseStudentEnroll;
use App\Mail\StudentEnroll;
use App\Models\CertifiedByPart;
use App\Models\User;
use App\Models\UserOtp;
use App\Models\VidCourseEnroll;
use App\Models\VideoCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class VidCourseEnrollController extends Controller {
    public function video_course_enroll() {
        $page_title = 'Online Courses';

        $data = [
            'page_title' => $page_title,
            'online_courses' => VideoCourse::all(),
            'certified_by_parts' => CertifiedByPart::all(),
        ];
        return view('frontend.online_courses_enroll', $data);
    }

    public function vid_course_enroll_store(Request $request) {
        if (User::where('mobile', $request->mobile)->exists()) {
            return view('frontend.modals.login-modal', ['mobile' => $request->mobile]);
        }

        if (Auth::check()) {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|not_in:0',
            ], [
                'course_id.not_in' => 'Please select a Course.',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'mobile' => 'required|unique:users,mobile|regex:/(01)[0-9]{9}/',
                'email' => 'unique:users,email',
                'password' => 'required|same:confirm_password',
                'confirm_password' => 'required',
                'course_id' => 'required|not_in:0',
            ], [
                'mobile.unique' => 'Mobile number has already been taken.',
                'email.unique' => 'Email has already been taken.',
                'password.same' => 'Password and confirm password does not match.',
                'course_id.not_in' => 'Please select a Course.',
            ]);
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        } else {
            if (Auth::check()) {
                $user = auth()->user();
            } else {
                $password =  $request->password;
                $user = User::create([
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'email' => $request->email,
                    'password' => bcrypt($password),
                    'branch_id' => $request->branch
                ]);
                $user->syncRoles(4);
                Auth::login($user);
                $otp = UserOtp::create([
                    'user_id' => $user->id,
                    'otp' => rand(1000, 9999),
                ]);
                $number = $user->mobile;
                $message = "আপনার ওটিপি হল: " . bangla_digit($otp->otp);
                send_sms($number, $message);
            }

            $vid_course_id = VideoCourse::find($request->course_id)->id;

            $enroll = VidCourseEnroll::create([
                'user_id' => $user->id,
                'vid_course_id' => $vid_course_id,
            ]);

            $data = [
                'user' => $user,
                'enroll' => $enroll,
            ];

            Mail::to($user->email)->send(new OnlineCourseStudentEnroll($data));

            session([
                'enrollSuccess' => 'Online Course enrollment successful! You can see the class videos in your dashboard.',
            ]);

            // session()->flash('enrollSuccess', 'Course enrollment successful! You can see the class videos in your dashboard.');

            return response()->json(['success' => true]);
        }
    }
}
