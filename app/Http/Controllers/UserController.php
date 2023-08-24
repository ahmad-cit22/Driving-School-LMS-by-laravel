<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Enroll;
use App\Models\StudentIdCard;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Image;
use Spatie\Permission\Models\Role;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserController extends Controller {
    public function users() {
        $admin_users = User::role(1)->where('id', '!=', 2)->get();
        $branch_manager_users = User::role(2)->get();
        $instructor_users = User::role(3)->get();
        $branches = Branch::all();

        if (auth()->user()->hasRole(1)) {
            return view('admin.users.index', [
                'admin_users' => $admin_users,
                'branch_manager_users' => $branch_manager_users,
                'instructor_users' => $instructor_users,
                'branches' => $branches,
                'roles' => Role::all()->filter(function ($value, $key) {
                    return  $value->id != 4;
                }),
            ]);
        } elseif (auth()->user()->hasRole(2)) {
            return view('admin.users.index', [
                'instructor_users' => $instructor_users,
                'branches' => $branches,
                'roles' => Role::all()->filter(function ($value, $key) {
                    return  $value->id != 4;
                }),
            ]);
        }
    }

    public function users_edit($id) {

        return view('admin.users.edit', [
            'user' => User::find($id),
            'roles' => Role::all()->filter(function ($value, $key) {
                return  $value->id != 4;
            }),
            'branches' => Branch::all(),
            'page_title' => 'Edit User'
        ]);
    }

    public function users_add(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile' => 'required|unique:users,mobile|regex:/(01)[0-9]{9}/',
            'email' => 'unique:users,email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => bcrypt($request->password),
                'otp_verified_at' => Carbon::now(),
            ]);
            if ($request->role) {
                $user->syncRoles($request->role);
            } else {
                $user->syncRoles(4);
            }
            session()->flash('success', 'User added successfully!');
            return response()->json(['success' => true]);
        }
    }

    public function users_update_info(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'nid' => 'required',
        ]);

        $user = User::find($request->id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'nid' => $request->nid,
            'b_date' => $request->b_date,
        ]);

        if (!empty($request->branch_id)) {
            $user->update([
                'branch_id' => $request->branch_id
            ]);
        }

        if (!empty($request->role_id)) {
            $user->syncRoles($request->role_id);
        }

        return back()->with('success', 'User information updated successfully.');
    }

    public function users_update_password(Request $request) {
        $request->validate([
            'password' => ['required'],
            'confirm_password' => ['same:password'],
        ]);
        User::find($request->id)->update([
            'password' => Hash::make($request->password),
        ]);
        return back()->with('success', 'User password updated successfully.');
    }

    public function users_update_profile_pic(Request $request) {
        $request->validate([
            'image' => 'required|mimes:jpg,png',
        ]);
        $image = $request->image;
        $user = User::find($request->id);
        $file_name = Str::lower('profile-' . $request->id . '-' . uniqid() . '.' . $image->getClientOriginalExtension());
        if ($user->image != '') {
            unlink(public_path('/uploads/users/' . $user->image));
        }
        Image::make($image)->fit(200, 200)->save(public_path('/uploads/users/' . $file_name));
        $user->update([
            'image' => $file_name
        ]);

        return back()->with('success', 'Profile picture updated successfully.');
    }

    public function users_delete($id) {
        if (User::with('enroll')->find($id)->enroll) {
            return back()->with('error', "Can't delete. User has already in a course.");
        } else {
            if (User::find($id)->delete()) {
                return back()->with('success', 'User deleted successfully.');
            } else {
                return back()->with('error', 'Something went wrong.');
            }
        }
    }

    public function students() {
        return view('admin.students.students', [
            'users' => User::role(4)->with('idcard')->get(),
            // 'users_without_course' => User::role(4)->with('idcard')->get(),
            'roles' => Role::all(),
        ]);
    }

    public function generate_id($id) {
        $enroll = Enroll::orderBy('created_at', 'desc')->where('user_id', $id)->first();

        if ($enroll->user->image) {
            if (StudentIdCard::where('enroll_id', $enroll->id)->exists()) {
                $uuid = StudentIdCard::where('enroll_id', $enroll->id)->first()->verification_id;
            } else {
                $uuid = Str::uuid();
                StudentIdCard::create([
                    'user_id' => $enroll->user_id,
                    'enroll_id' => $enroll->id,
                    'verification_id' => $uuid,
                ]);
            }

            $data = [
                'enroll' => $enroll,
                'url' => request()->getHost(),
                'uuid' => $uuid,
            ];
            // return view('admin.id-cards.index', $data);
            $pdf = Pdf::setOption(['defaultFont' => 'sans-serif'])->loadView('admin.id-cards.index', $data);
            return $pdf->download();
        } else {
            return redirect()->route('admin.users.edit', $enroll->user_id)->with('error', 'Please upload user photo first.');
        }
    }

    public function verify_id($id) {
        $data = [
            'page_title' => 'Verify Student ID',
            'studend_id' => StudentIdCard::where('verification_id', $id)->first(),
        ];
        return view('frontend.id-verify', $data);
    }
}
