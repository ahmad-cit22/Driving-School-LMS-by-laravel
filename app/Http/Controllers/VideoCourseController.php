<?php

namespace App\Http\Controllers;

use App\Models\ClassVideo;
use App\Models\CourseCategory;
use App\Models\CourseType;
use App\Models\Enroll;
use App\Models\VidCourseEnroll;
use App\Models\VideoCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class VideoCourseController extends Controller {
    //quizzes list

    public function index() {
        return view('admin.video_courses.index', [
            'course_categories' => CourseCategory::all(),
            'course_types' => CourseType::all(),
            'vid_courses' => VideoCourse::all(),
        ]);
    }

    public function add(Request $request) {

        if ($request->image != '') {
            $request->validate([
                'image' => 'mimes:png,jpg,jpeg,webp,gif|max:1024',
                'course_category' => 'required',
                'course_type' => 'required',
                'course_title' => 'required',
            ], [
                'course_category.required' => 'Please select the course category.',
                'course_type.required' => 'Please select the course type.',
                'course_title.required' => 'Please enter a title for the course.',
            ]);

            $vid_course_id = VideoCourse::insertGetId([
                'course_category' => $request->course_category,
                'course_type' => $request->course_type,
                'course_title' => $request->course_title,
                'created_at' => Carbon::now(),
            ]);


            $uploaded_image = $request->image;
            $ext = $uploaded_image->getClientOriginalExtension();
            $photo_name = 'vid_course-' . $vid_course_id . '.' . $ext;

            Image::make($uploaded_image)->resize(275, 180)->save(public_path('assets/frontend/img/courses/' . $photo_name));
            VideoCourse::find($vid_course_id)->update([
                'image' => $photo_name
            ]);

            return back()->with('addSuccess', 'Course Added Successfully!');
        } else {
            $request->validate([
                'course_category' => 'required',
                'course_type' => 'required',
                'course_title' => 'required',
            ], [
                'course_category.required' => 'Please select the course category.',
                'course_type.required' => 'Please select the course type.',
                'course_title.required' => 'Please enter a title for the course.',
            ]);

            VideoCourse::insert([
                'course_category' => $request->course_category,
                'course_type' => $request->course_type,
                'course_title' => $request->course_title,
                'created_at' => Carbon::now(),
            ]);

            return back()->with('addSuccess', 'Course Added Successfully!');
        }
    }

    public function course_edit_modal($id) {
        return view('admin.madals.edit-vid-course', [
            'course' => VideoCourse::find($id),
            'course_categories' => CourseCategory::all(),
            'course_types' => CourseType::all(),
        ]);
    }

    public function course_update(Request $request) {


        if ($request->image != '') {
            $request->validate([
                'image' => 'mimes:png,jpg,jpeg,webp,gif|max:1024',
                'course_category' => 'required',
                'course_type' => 'required',
                'course_title' => 'required',
            ], [
                'course_category.required' => 'Please select the course category.',
                'course_type.required' => 'Please select the course type.',
                'course_title.required' => 'Please enter a title for the course.',
            ]);

            $course = VideoCourse::find($request->id);

            $uploaded_image = $request->file('image');
            $ext = $uploaded_image->getClientOriginalExtension();
            $photo_name = 'vid_course-' . $course->id . '.' . $ext;

            // if ($course->image != 'def-image.jpg') {
            //     $old_image = public_path('assets/frontend/img/courses/' . $course->image);
            //     unlink($old_image);
            // }

            Image::make($uploaded_image)
                ->resize(275, 180)
                ->save(public_path('assets/frontend/img/courses/' . $photo_name));

            $course->update([
                'image' => $photo_name,
                'course_category' => $request->course_category,
                'course_type' => $request->course_type,
                'course_title' => $request->course_title,
            ]);

            session()->flash('success', 'Course Edited Successfully!');
            return response()->json(['success' => true]);
        } else {
            $request->validate([
                'course_category' => 'required',
                'course_type' => 'required',
                'course_title' => 'required',
            ], [
                'course_category.required' => 'Please select the course category.',
                'course_type.required' => 'Please select the course type.',
                'course_title.required' => 'Please enter a title for the course.',
            ]);

            $course->update([
                'course_category' => $request->course_category,
                'course_type' => $request->course_type,
                'course_title' => $request->course_title,
            ]);

            session()->flash('success', 'Course Edited Successfully!');
            return response()->json(['success' => true]);
        }
    }

    public function course_delete($id) {

        if (VideoCourse::find($id)->image != 'def-image.jpg') {
            $old_image = public_path('assets/frontend/img/courses/' . VideoCourse::find($id)->image);
            unlink($old_image);
        }

        $videos = ClassVideo::where('vid_course_id', $id)->delete();

        if (VideoCourse::find($id)->delete()) {
            return back()->with('dltSuccess', 'Course deleted successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function vid_courses_videos($course_id) {
        $vid_course = VideoCourse::find($course_id);
        $videos = ClassVideo::where('vid_course_id', $course_id)->get();

        return view('admin.video_courses.videos', [
            'vid_course' => $vid_course,
            'videos' => $videos,
        ]);
    }

    public function videos_store(Request $request, $course_id) {
        $vid_course = VideoCourse::find($course_id);

        $request->validate([
            'class_no' => 'required',
            'video_title' => 'required',
            'video_link' => 'required',
        ], [
            'class_no.required' => 'Please enter the class no.',
            'video_title.required' => 'Please enter the video title.',
            'video_link.required' => 'Please enter the link to the video.',
        ]);

        ClassVideo::insert([
            'vid_course_id' => $course_id,
            'class_no' => $request->class_no,
            'video_title' => $request->video_title,
            'video_link' => $request->video_link,
            'created_at' => Carbon::now(),
        ]);

        return back()->with('addSuccess', 'New Video Added Successfully!');
    }

    public function video_edit_modal($id) {
        return view('admin.madals.edit-vid-course-video', [
            'video' => ClassVideo::find($id),
        ]);
    }

    public function video_update(Request $request) {

        $video = ClassVideo::find($request->id);

        $request->validate([
            'class_no' => 'required',
            'video_title' => 'required',
            'video_link' => 'required',
        ], [
            'class_no.required' => 'Please enter the class no.',
            'video_title.required' => 'Please enter the video title.',
            'video_link.required' => 'Please enter the link to the video.',
        ]);

        $video->update([
            'class_no' => $request->class_no,
            'video_title' => $request->video_title,
            'video_link' => $request->video_link,
        ]);

        session()->flash('success', 'Class Video Edited Successfully!');
    }

    public function video_delete($id) {
        if (ClassVideo::find($id)->delete()) {
            return back()->with('success', 'Class Video deleted successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }


    public function student_vid_courses() {
        $user_id = Auth::id();

        $offline_enroll_exists = Enroll::where('user_id', $user_id)->exists();
        $online_enroll = VidCourseEnroll::where('user_id', $user_id);
        $online_enroll_exists = $online_enroll->exists();

        if ($offline_enroll_exists || $online_enroll_exists) {
            if ($offline_enroll_exists) {
                return view('admin.video_courses.vid_courses_students', [
                    'vid_courses' => VideoCourse::all(),
                ], [
                    'online_enroll' => $online_enroll,
                    'online_enroll_exists' => $online_enroll_exists,
                ]);
            } else {
                return view('admin.video_courses.vid_courses_students', [
                    'vid_courses' => VideoCourse::all(),
                ], [
                    'online_enroll' => $online_enroll,
                    'online_enroll_exists' => $online_enroll_exists,
                ]);
            }
        } else {
            return back()->with('needToEnroll', 'You have to enroll to a course first in order to get access to the video courses.');
        }
    }

    public function student_vid_courses_videos($course_id) {

        $vid_course = VideoCourse::find($course_id);
        $videos = ClassVideo::where('vid_course_id', $course_id)->get();

        if (VidCourseEnroll::where('user_id', Auth::id())->where('vid_course_id', $course_id)->exists()) {
            $enroll_id = VidCourseEnroll::where('user_id', Auth::id())->where('vid_course_id', $course_id)->first()->id;

            if (VidCourseEnroll::find($enroll_id)->status) {
                return view('admin.video_courses.vid_courses_videos_students', [
                    'enroll_id' => $enroll_id,
                    'videos' => $videos,
                    'isOnline' => true,
                ]);
            } else {
                return back()->with('notApproved', 'Your enrollment has not been approved yet! Wait a bit or contact with us to get approved fast.');
            }
        } elseif (Enroll::where('user_id', Auth::id())->where('course_category',  $vid_course->course_category)->exists()) {
            $enroll_id = Enroll::where('user_id', Auth::id())->where('course_category',  $vid_course->course_category)->first()->id;

            if (Enroll::find($enroll_id)->status) {
                return view('admin.video_courses.vid_courses_videos_students', [
                    'enroll_id' => $enroll_id,
                    'videos' => $videos,
                    'isOnline' => false,
                ]);
            } else {
                return back()->with('notApproved', 'Your enrollment has not been approved yet! Wait a bit or contact with us to get approved fast.');
            }
        } else {
            return back()->with('notEnrolled', "You did't enroll for this video course yet! Visit our courses to get enrolled.");
        }
    }
}
