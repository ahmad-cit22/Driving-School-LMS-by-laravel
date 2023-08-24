<?php

namespace App\Http\Controllers;

use App\Models\AccountExpense;
use App\Models\Branch;
use App\Models\Coupon;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller {
    public function index() {
        return view('admin.coupons.index', [
            'coupons' => Coupon::all(),
            'courses' => Course::all(),
            'branches' => Branch::all(),
        ]);
    }

    public function coupon_add(Request $request) {
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required',
            'coupon_type' => 'required|not_in:0',
            'discount_amount' => 'required',
            'available_for' => 'required|not_in:0',
            'branch_id' => 'required|not_in:0',
            'status' => 'required|not_in:0',
        ], [
            'coupon_type.not_in' => 'Please select coupon type.',
            'available_for.not_in' => 'Please choose availability of the coupon.',
            'branch_id.not_in' => 'Please choose branch for the discount.',
            'status.not_in' => 'Please select a status.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        } else {
            Coupon::create([
                'coupon_code' => $request->coupon_code,
                'coupon_type' => $request->coupon_type,
                'discount_amount' => $request->discount_amount,
                'available_for' => $request->available_for,
                'branch_id' => $request->branch_id,
                'limit' => $request->limit,
                'validity' => $request->validity,
                'status' => $request->status,
            ]);

            session()->flash('success', 'New Coupon Added Successfully!');
            return response()->json(['success' => true]);
        }
    }

    public function coupon_edit_modal($id) {
        return view('admin.madals.edit-coupon', [
            'coupon' => Coupon::find($id),
            'courses' => Course::all(),
            'branches' => Branch::all(),
        ]);
    }

    public function coupon_update(Request $request) {
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required',
            'coupon_type' => 'required|not_in:0',
            'discount_amount' => 'required',
            'available_for' => 'required|not_in:0',
            'branch_id' => 'required|not_in:0',
            'status' => 'required|not_in:0',
        ], [
            'coupon_type.not_in' => 'Please select coupon type.',
            'available_for.not_in' => 'Please choose availability.',
            'branch_id.not_in' => 'Please choose branch for the discount.',
            'status.not_in' => 'Please select a status.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        } else {
            $coupon = Coupon::find($request->id);

            $coupon->update([
                'coupon_code' => $request->coupon_code,
                'coupon_type' => $request->coupon_type,
                'discount_amount' => $request->discount_amount,
                'available_for' => $request->available_for,
                'branch_id' => $request->branch_id,
                'limit' => $request->limit,
                'validity' => $request->validity,
                'status' => $request->status,
            ]);

            session()->flash('success', 'Coupon Updated successfully!');
            return response()->json(['success' => true]);
        }
    }

    public function coupon_delete($id) {
        if (Coupon::find($id)->delete()) {
            return back()->with('success', 'Coupon Deleted Successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }
}
