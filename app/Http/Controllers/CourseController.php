<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchCapability;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseDoc;
use App\Models\CourseSlot;
use App\Models\CourseType;
use App\Models\Enroll;
use App\Models\Quiz;
use App\Models\VidCourseEnroll;
use App\Models\VideoCourse;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class CourseController extends Controller {

    public function __construct() {
        // $this->middleware(['role:Super Admin']);
    }

    //course category

    public function index() {
        if (auth()->user()->hasRole(1)) {
            return view('admin.courses.index', [
                'course_categories' => CourseCategory::all(),
                'course_types' => CourseType::all(),
                'course_slots' => CourseSlot::with('branch')->orderBy('branch_id', 'ASC')->orderBy('start_time', 'ASC')->get(),
                'branches' => Branch::all(),
                'branch_capabilities' => BranchCapability::all()
            ]);
        } else {
            return view('admin.courses.index', [
                'course_slots' => CourseSlot::with('branch')->orderBy('branch_id', 'ASC')->orderBy('start_time', 'ASC')->get(),
                'branches' => Branch::all(),
            ]);
        }
    }
    public function category_add(Request $request) {

        if ($request->image != '') {
            $request->validate([
                'category_name' => 'required|unique:course_categories,category_name',
                'image' => 'mimes:png,jpg,jpeg,webp,gif|max:1024',
            ], [
                'category_name.required' => 'Please enter a valid course category.'
            ]);

            $category_id = CourseCategory::insertGetId([
                'category_name' => $request->category_name,
                'created_at' => Carbon::now(),
            ]);

            $uploaded_image = $request->image;
            $ext = $uploaded_image->getClientOriginalExtension();
            $photo_name = 'category-' . $category_id . '.' . $ext;

            Image::make($uploaded_image)->resize(270, 177)->save(public_path('assets/frontend/images/category/' . $photo_name));
            CourseCategory::find($category_id)->update([
                'image' => $photo_name
            ]);

            return back()->with('success', 'New Category added successfully');
        } else {
            $request->validate([
                'category_name' => 'required|unique:course_categories,category_name',
            ], [
                'category_name.required' => 'Please enter a valid course category.'
            ]);

            CourseCategory::insert([
                'category_name' => $request->category_name
            ]);

            return back()->with('success', 'New Category added successfully');
        }
    }

    public function category_edit_modal($id) {
        return view('admin.madals.edit-course-category', [
            'course_category' => CourseCategory::find($id)
        ]);
    }

    public function category_update(Request $request) {

        if ($request->image != '') {
            $validator = Validator::make($request->all(), [
                'category_name' => 'required',
                'image' => 'mimes:png,jpg,jpeg,webp,gif|max:1024',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
            } else {
                $CourseCategory = CourseCategory::find($request->id);

                $uploaded_image = $request->image;
                $ext = $uploaded_image->getClientOriginalExtension();
                $photo_name = 'category-' . $request->id . '.' . $ext;

                if ($CourseCategory->image != 'def-image.jpg') {
                    $old_image = public_path('assets/frontend/images/category/' . $CourseCategory->image);
                    if ($old_image) {
                        unlink($old_image);
                    }
                }

                Image::make($uploaded_image)->resize(270, 177)->save(public_path('assets/frontend/images/category/' . $photo_name));

                $CourseCategory->update([
                    'category_name' => $request->category_name ?? $CourseCategory->category_name,
                    'image' => $photo_name
                ]);

                session()->flash('success', 'Course category updated successfully!');
                return response()->json(['success' => true]);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'category_name' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
            } else {
                $CourseCategory = CourseCategory::find($request->id);

                $CourseCategory->update([
                    'category_name' => $request->category_name ?? $CourseCategory->category_name,
                ]);

                session()->flash('success', 'Course category updated successfully!');
                return response()->json(['success' => true]);
            }
        }
    }

    public function category_delete($id) {
        $CourseCategory = CourseCategory::find($id);

        if (VideoCourse::where('course_category', $id)->exists() || Enroll::where('course_category', $id)->exists() || Course::where('category_id', $id)->exists() || Quiz::where('course_id', $id)->exists()) {
            return back()->with('dltErr', "You can't delete this category because there is existing course, quiz or enrollment of this category.");
        } else {
            if ($CourseCategory->image != 'def-image.jpg') {
                $old_image = public_path('assets/frontend/images/category/' . $CourseCategory->image);
                if ($old_image) {
                    unlink($old_image);
                }
            }
            if ($CourseCategory->delete()) {
                return back()->with('success', 'Course category deleted successfully');
            } else {
                return back()->with('error', 'Something went wrong');
            }
        }
    }

    //course type
    public function type_add(Request $request) {
        $request->validate([
            'type_name' => 'required|unique:course_types,type_name',
            'duration' => 'required',
            'max_duration' => 'required',
        ], [
            'type_name.required' => 'Please enter a valid course type.',
            'duration.required' => 'Please enter a valid duration.'
        ]);

        CourseType::create([
            'type_name' => $request->type_name,
            'duration' => $request->duration,
            'max_duration' => $request->max_duration
        ]);
        return back()->with('success', 'Type name added successfully');
    }

    public function type_edit_modal($id) {
        return view('admin.madals.edit-course-type', [
            'course_type' => CourseType::find($id)
        ]);
    }

    public function type_update(Request $request) {
        $CourseType = CourseType::find($request->id);
        $CourseType->update([
            'type_name' => $request->type_name ?? $CourseType->type_name,
            'duration' => $request->duration ?? $CourseType->duration,
            'max_duration' => $request->max_duration ?? $CourseType->max_duration
        ]);
        session()->flash('success', 'Course type successfully!');
    }

    public function type_delete($id) {

        if (VideoCourse::where('course_type', $id)->exists() || Enroll::where('course_type', $id)->exists() || Course::where('type_id', $id)->exists() || Quiz::where('course_type', $id)->exists()) {
            return back()->with('dltErr', "You can't delete this type because there is existing course, quiz or enrollment of this type.");
        } else {
            if (CourseType::find($id)->delete()) {
                return back()->with('success', 'Course type deleted successfully');
            } else {
                return back()->with('error', 'Something went wrong');
            }
        }
    }

    //course slot
    public function slot_add(Request $request) {
        // return CourseSlot::where('branch_id', $request->branch_id_s)->where('type', $request->type)->where('day', $request->day)->exists();
        $errors = [];
        $validator = Validator::make($request->all(), [
            'start_time' => 'required',
            'end_time' => 'required',
            'branch_id_s' => 'required',
            'type' => 'required',
        ], [
            'start_time.required' => 'Please enter a valid start time.',
            'end_time.required' => 'Please enter a valid end time.',
            'branch_id_s.required' => 'Please select a branch.',
            'type.required' => 'Please select a class type.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        } else {
            if (CourseSlot::where('branch_id', $request->branch_id_s)->where('type', $request->type)->where('start_time', $request->start_time)->where('day', $request->day)->exists()) {
                $errors['start_time'] = ['Start Time has already been taken'];
            }
            if ($request->start_time == $request->end_time) {
                $errors['start_time'] = ['Please enter a different Start and Time'];
            }
            if (CourseSlot::where('branch_id', $request->branch_id_s)->where('type', $request->type)->where('end_time', $request->end_time)->where('day', $request->day)->exists()) {
                $errors['end_time'] = ['End Time has already been taken'];
            }
            if ($request->type == 2 && CourseSlot::where('branch_id', $request->branch_id_s)->where('type', $request->type)->where('day', $request->day)->exists()) {
                $errors['day'] = ['Day has already been taken'];
            }

            if (count($errors) > 0) {
                return response()->json(['errors' => $errors]);
            } else {
                CourseSlot::create([
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'type' => $request->type,
                    'branch_id' => $request->branch_id_s,
                    'day' => $request->type == 2 ? $request->day : null,
                ]);
                session()->flash('success', 'Slot added successfully!');
                return response()->json(['success' => true]);
            }
        }
    }

    public function slot_get_day($id) {
        $html = '<option></option>';
        foreach (Branch::with('theory_class.days')->find($id)->theory_class as $theory_class) {
            $html .= '<option value="' . $theory_class->days->id . '">' . $theory_class->days->day . '</option>';
        }
        return $html;
    }

    public function slot_delete($id) {
        $slot = CourseSlot::find($id);

        if (Enroll::where('course_slot', $id)->exists()) {
            return back()->with('dltErr', "You can't delete this slot because there is existing enrollment in this slot.");
        } else {
            if ($slot->delete()) {
                return back()->with('success', 'Course slot deleted successfully');
            } else {
                return back()->with('error', 'Something went wrong');
            }
        }
    }

    //Vehicle Capability
    public function capability_add(Request $request) {
        $request->validate([
            '*' => 'required',
            'available_vehical' => 'required|numeric|min:1'
        ], [
            'branch_id.required' => 'Branch field is required.',
            'category_id.required' => 'Course Category field is required.',
            'available_vehical.required' => 'Available Vehical field is required.',
            'available_vehical.min' => 'Please enter a valid number. Min value: 1'
        ]);

        if (BranchCapability::where('branch_id', $request->branch_id)->where('category_id', $request->category_id)->exists()) {
            return back()->withErrors(['branch_id' => 'Data already exist.'])->withInput();
        } else {
            BranchCapability::create([
                'branch_id' => $request->branch_id,
                'category_id' => $request->category_id,
                'available_vehical' => $request->available_vehical
            ]);
            return back()->with('success', 'Branch Capability added successfully');
        }
    }

    public function capability_edit_modal($id) {
        return view('admin.madals.edit-branch-capability', [
            'branch' => Branch::find($id),
            'course_categories' => CourseCategory::all(),
            'branch_capabilities' => BranchCapability::where('branch_id', $id)->get()
        ]);
    }

    public function capability_update(Request $request) {
        $alldata = $request->except('_token');
        foreach ($alldata as $key => $data) {
            BranchCapability::find($key)->update([
                'available_vehical' => $data
            ]);
        }
        session()->flash('success', 'Branch vehical capability updated successfully!');
    }

    public function capability_delete($id) {
        if (BranchCapability::where('branch_id', $id)->delete()) {
            return back()->with('success', 'Branch vehical capability deleted successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }

    //course list page view
    public function courses_list() {
        return view('admin.courses.course_list', [
            'course_categories' => CourseCategory::all(),
            'course_types' => CourseType::all(),
            'courses' => Course::all(),
        ]);
    }

    public function courses_add(Request $request) {
        if (empty($request->discount)) {
            $discount = 0;
        } else {
            $discount = $request->discount;
        }

        if ($request->image != '') {
            $request->validate([
                'category_id' => 'required',
                'type_id' => 'required',
                'price' => 'required',
                'priority' => 'required',
                'image' => 'mimes:png,jpg,jpeg,webp,gif|max:1024',
            ], [
                'category_id.required' => 'Please select a category for the course.',
                'type_id.required' => 'Please select the course type.',
                'price.required' => 'Please enter the course fee.',
            ]);

            $course_id = Course::insertGetId([
                'category_id' => $request->category_id,
                'type_id' => $request->type_id,
                'price' => $request->price,
                'discount' => $discount,
                'after_discount' => $request->price - (($request->price * $discount) / 100),
                'course_details' => $request->course_details,
                'priority' => $request->priority,
                'meta_description' => $request->meta_description,
                'created_at' => Carbon::now()
            ]);

            $uploaded_image = $request->image;
            $ext = $uploaded_image->getClientOriginalExtension();
            $photo_name = 'course-' . $course_id . '.' . $ext;

            Image::make($uploaded_image)->resize(275, 180)->save(public_path('assets/frontend/img/courses/' . $photo_name));
            Course::find($course_id)->update([
                'image' => $photo_name
            ]);

            return back()->with('success', 'Course Added successfully!');
        } else {
            $request->validate([
                'category_id' => 'required',
                'type_id' => 'required',
                'priority' => 'required',
                'price' => 'required',
            ], [
                'category_id.required' => 'Please select a category for the course.',
                'type_id.required' => 'Please select the course type.',
                'price.required' => 'Please enter the course fee.',
            ]);

            Course::create([
                'category_id' => $request->category_id,
                'type_id' => $request->type_id,
                'price' => $request->price,
                'discount' => $discount,
                'after_discount' => $request->price - (($request->price * $discount) / 100),
                'course_details' => $request->course_details,
                'priority' => $request->priority,
                'meta_description' => $request->meta_description,
            ]);

            return back()->with('success', 'Course Added successfully!');
        }
    }

    public function course_edit_modal($id) {
        return view('admin.madals.edit-course', [
            'course' => Course::find($id),
            'course_categories' => CourseCategory::all(),
            'course_types' => CourseType::all(),
        ]);
    }

    public function course_update(Request $request) {

        if (empty($request->discount)) {
            $discount = 0;
        } else {
            $discount = $request->discount;
        }

        if ($request->image != '') {
            $validator = Validator::make($request->all(), [
                'category_id' => 'required',
                'type_id' => 'required',
                'priority' => 'required',
                'price' => 'required',
                'image' => 'mimes:png,jpg,jpeg,webp,gif|max:1024',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
            } else {

                $course = Course::find($request->id);

                $uploaded_image = $request->file('image');
                $ext = $uploaded_image->getClientOriginalExtension();
                $photo_name = 'course-' . $course->id . '.' . $ext;

                if ($course->image != 'def-image.jpg') {
                    $old_image = public_path('assets/frontend/img/courses/' . $course->image);
                    unlink($old_image);
                }

                Image::make($uploaded_image)
                    ->resize(275, 180)
                    ->save(public_path('assets/frontend/img/courses/' . $photo_name));

                $course->update([
                    'category_id' => $request->category_id,
                    'type_id' => $request->type_id,
                    'price' => $request->price,
                    'discount' => $discount,
                    'after_discount' => $request->price - (($request->price * $discount) / 100),
                    'course_details' => $request->course_details,
                    'image' => $photo_name,
                    'priority' => $request->priority,
                    'meta_description' => $request->meta_description,
                ]);

                session()->flash('success', 'Course Updated Successfully!');
                return response()->json(['success' => true]);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'category_id' => 'required',
                'type_id' => 'required',
                'priority' => 'required',
                'price' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
            } else {
                $course = Course::find($request->id);

                $course->update([
                    'category_id' => $request->category_id,
                    'type_id' => $request->type_id,
                    'price' => $request->price,
                    'discount' => $discount,
                    'after_discount' => $request->price - (($request->price * $discount) / 100),
                    'course_details' => $request->course_details,
                    'priority' => $request->priority,
                    'meta_description' => $request->meta_description,
                ]);

                session()->flash('success', 'Course Updated successfully!');
                return response()->json(['success' => true]);
            }
        }
    }

    public function course_delete($id) {
        if (Course::find($id)->image != 'def-image.jpg') {
            $old_image = public_path('assets/frontend/img/courses/' . Course::find($id)->image);
            unlink($old_image);
        }
        if (Course::find($id)->delete()) {
            return back()->with('success', 'Course Deleted successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function docs_upload() {
        return view('admin.docs_upload.docs_upload', [
            'courses' => Course::all(),
            'course_docs' => CourseDoc::orderBy('created_at', 'DESC')->get(),
        ]);
    }

    public function docs_store(Request $request) {
        $validator = Validator::make($request->all(), [
            'course_id' => 'not_in:0',
            'file' => 'required|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf,zip',
        ], [
            'course_id.not_in' => 'Please select a course.',
            'file.required' => 'Please upload the file.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        } else {
            $fileName = $request->course_id . '_' . time() . '.' . $request->file->extension();

            $size = $request->file->getSize();

            if ($size >= 1073741824) {
                $size = number_format($size / 1073741824, 2) . ' GB';
            } elseif ($size >= 1048576) {
                $size = number_format($size / 1048576, 2) . ' MB';
            } elseif ($size >= 1024) {
                $size = number_format($size / 1024, 2) . ' KB';
            } elseif ($size > 1) {
                $size = $size . ' size';
            } elseif ($size == 1) {
                $size = $size . ' byte';
            } else {
                $size = '0 bytes';
            }

            $request->file->move(public_path('uploads/course_docs/'), $fileName);

            CourseDoc::create([
                'course_id' => $request->course_id,
                'name' => $fileName,
                'size' => $size,
                'note' => $request->note
            ]);

            session()->flash('success', 'New Course Document Added successfully!');
            return response()->json(['success' => true]);
        }
    }

    public function doc_edit_modal($id) {
        return view('admin.madals.edit-doc-modal', [
            'doc' => CourseDoc::find($id),
            'courses' => Course::all(),
        ]);
    }

    public function doc_update(Request $request) {
        $doc = CourseDoc::find($request->id);

        if ($request->file != '') {
            $validator = Validator::make($request->all(), [
                'course_id' => 'not_in:0',
                'file' => 'mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf,zip',
            ], [
                'course_id.not_in' => 'Please select a course.',
                'file.required' => 'Please upload the file.',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'course_id' => 'not_in:0',
            ], [
                'course_id.not_in' => 'Please select a course.',
            ]);
        }

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        } else {
            if ($request->file != '') {
                if ($doc->name != '') {
                    $old_file = public_path('uploads/course_docs/' . $doc->name);
                    if ($old_file) {
                        unlink($old_file);
                    }
                }
                $fileName = $request->course_id . '_' . time() . '.' . $request->file->extension();

                $size = $request->file->getSize();

                $request->file->move(public_path('uploads/course_docs/'), $fileName);

                $doc->update([
                    'course_id' => $request->course_id,
                    'name' => $fileName,
                    'size' => $size,
                    'note' => $request->note
                ]);

                session()->flash('success', 'Course Document Updated successfully!');
                return response()->json(['success' => true]);
            } else {
                $doc->update([
                    'course_id' => $request->course_id,
                    'note' => $request->note
                ]);

                session()->flash('success', 'Course Document Updated successfully!');
                return response()->json(['success' => true]);
            }
        }
    }

    public function docs_delete($id) {
        $doc = CourseDoc::find($id);

        $old_file = public_path('uploads/course_docs/' . $doc->name);
        if ($old_file) {
            unlink($old_file);
        }
        if ($doc->delete()) {
            return back()->with('success', 'Course document deleted successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }
}
