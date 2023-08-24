<?php

namespace App\Http\Controllers;

use App\Models\Enroll;
use App\Models\StudentAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentAttendanceController extends Controller {
    //course category

    public function index($enroll_id) {
        $enroll = Enroll::find($enroll_id);
        $max_classes = $enroll->type->max_duration;
        $attendances = StudentAttendance::where('enroll_id', $enroll_id)->get();

        if ($max_classes == $attendances->count()) {
            return response()->json(['error' => 'Class Limit Exceeded!']);
        }
        $remaining_classes = $enroll->type->duration - $attendances->count();
        $current_date = Carbon::now()->format('Y-m-d');

        return view('admin.madals.attendance', [
            'enroll' => $enroll,
            'attendances' => $attendances,
            'remaining_classes' => $remaining_classes,
            'current_date' => $current_date,
        ]);
    }

    public function attendance_add(Request $request) {

        $validator = Validator::make($request->all(), [
            'class_no' => 'not_in:0',
            'date' => 'required',
        ], [
            'class_no.not_in' => 'Please select the class no.',
            'date.required' => 'Please select the class no.'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        } else {
            StudentAttendance::create([
                'enroll_id' => $request->id,
                'class_no' => $request->class_no,
                'date' => $request->date,
            ]);

            session()->flash('success', 'Attendance Added Successfully!');
            return response()->json(['success' => true]);
        }
    }

    // public function category_edit_modal($id) {
    //     return view('admin.madals.edit-course-category', [
    //         'course_category' => CourseCategory::find($id)
    //     ]);
    // }

    // public function category_update(Request $request) {

    //     if ($request->image != '') {
    //         $validator = Validator::make($request->all(), [
    //             'category_name' => 'required',
    //             'image' => 'mimes:png,jpg,jpeg,webp,gif|max:1024',
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
    //         } else {
    //             $CourseCategory = CourseCategory::find($request->id);

    //             $uploaded_image = $request->image;
    //             $ext = $uploaded_image->getClientOriginalExtension();
    //             $photo_name = 'category-' . $request->id . '.' . $ext;

    //             if ($CourseCategory->image != 'def-image.jpg') {
    //                 $old_image = public_path('assets/frontend/images/category/' . $CourseCategory->image);
    //                 unlink($old_image);
    //             }

    //             Image::make($uploaded_image)->resize(270, 177)->save(public_path('assets/frontend/images/category/' . $photo_name));

    //             $CourseCategory->update([
    //                 'category_name' => $request->category_name ?? $CourseCategory->category_name,
    //                 'image' => $photo_name
    //             ]);

    //             session()->flash('success', 'Course category updated successfully!');
    //             return response()->json(['success' => true]);
    //         }
    //     } else {
    //         $validator = Validator::make($request->all(), [
    //             'category_name' => 'required',
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
    //         } else {
    //             $CourseCategory = CourseCategory::find($request->id);

    //             $CourseCategory->update([
    //                 'category_name' => $request->category_name ?? $CourseCategory->category_name,
    //             ]);

    //             session()->flash('success', 'Course category updated successfully!');
    //             return response()->json(['success' => true]);
    //         }
    //     }
    // }

    // public function category_delete($id) {
    //     $CourseCategory = CourseCategory::find($id);
    //     if ($CourseCategory->image != 'def-image.jpg') {
    //         $old_image = public_path('assets/frontend/images/category/' . $CourseCategory->image);
    //         unlink($old_image);
    //     }
    //     if ($CourseCategory->delete()) {
    //         return back()->with('success', 'Course category deleted successfully');
    //     } else {
    //         return back()->with('error', 'Something went wrong');
    //     }
    // }
}
