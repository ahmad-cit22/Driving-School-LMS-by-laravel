<?php

namespace App\Http\Controllers;

use App\Mail\SlotChangeApply;
use App\Models\AccountExpense;
use App\Models\AccountIncome;
use App\Models\Branch;
use App\Models\Course;
use App\Models\CourseDoc;
use App\Models\CourseSlot;
use App\Models\Enroll;
use App\Models\Quiz;
use App\Models\QuizScore;
use App\Models\Review;
use App\Models\StudentAttendance;
use App\Models\User;
use App\Models\VidCourseEnroll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller {

    public function index(Request $request) {
        if (empty($request->y)) {
            $year = date('Y');
        } else {
            $year = $request->y;
        }

        if (auth()->user()->hasRole(1)) {
            $enrolls = Enroll::whereYear('created_at', '=', $year);
            $income = AccountIncome::whereYear('created_at', '=', $year);
            $expense = AccountExpense::whereYear('created_at', '=', $year);
            $branches = Branch::all();

            $students = Enroll::distinct('user_id');

            $branch_one_income = AccountIncome::whereYear('created_at', '=', $year)->where('branch_id', 1)->sum('amount');
            $branch_one_expense = AccountExpense::whereYear('created_at', '=', $year)->where('branch_id', 1)->sum('amount');
            $branch_two_income = AccountIncome::whereYear('created_at', '=', $year)->where('branch_id', 2)->sum('amount');
            $branch_two_expense = AccountExpense::whereYear('created_at', '=', $year)->where('branch_id', 2)->sum('amount');

            $data = [
                'page_title' => 'Dashboard',
                'enrolls' => $enrolls->get(),
                'branches' => $branches,
                'student_count' => $students->count(),

                'income' => $income->get(),
                'expense' => $expense->get(),
                'total_revenue' => $income->sum('amount') - $expense->sum('amount'),

                'jan' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 1)->count(),
                'feb' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 2)->count(),
                'mar' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 3)->count(),
                'apr' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 4)->count(),
                'may' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 5)->count(),
                'jun' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 6)->count(),
                'jul' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 7)->count(),
                'aug' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 8)->count(),
                'sep' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 9)->count(),
                'oct' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 10)->count(),
                'nov' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 11)->count(),
                'dec' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 12)->count(),

                'janInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 1)->sum('amount'),
                'febInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 2)->sum('amount'),
                'marInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 3)->sum('amount'),
                'aprInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 4)->sum('amount'),
                'mayInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 5)->sum('amount'),
                'junInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 6)->sum('amount'),
                'julInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 7)->sum('amount'),
                'augInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 8)->sum('amount'),
                'sepInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 9)->sum('amount'),
                'octInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 10)->sum('amount'),
                'novInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 11)->sum('amount'),
                'decInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 12)->sum('amount'),

                'branch_one_name' => Branch::where('id', 1)->first()->branch_name,
                'branch_one_enrolls' => $enrolls->where('branch_id', 1)->count(),
                'branch_one_students' => Enroll::distinct('user_id')->where('branch_id', 1)->count(),
                'branch_one_income' => $branch_one_income,
                'branch_one_expense' => $branch_one_expense,
                'branch_one_revenues' => $branch_one_income - $branch_one_expense,

                'branch_two_name' => Branch::where('id', 2)->first()->branch_name,
                'branch_two_enrolls' => Enroll::whereYear('created_at', '=', $year)->where('branch_id', 2)->count(),
                'branch_two_students' => Enroll::distinct('user_id')->where('branch_id', 2)->count(),
                'branch_two_income' => $branch_two_income,
                'branch_two_expense' => $branch_two_expense,
                'branch_two_revenues' => $branch_two_income - $branch_two_expense,

                'current_year' => Carbon::now()->format('Y'),
                'selected_year' => $year,
            ];

            return view('admin.dashboards.dashboard', $data);
        } else if (auth()->user()->hasRole(2)) {
            $branch_id = Auth::user()->branch_id;

            $enrolls = Enroll::whereYear('created_at', '=', $year)->where('branch_id', $branch_id);
            $income = AccountIncome::whereYear('created_at', '=', $year)->where('branch_id', $branch_id);
            $expense = AccountExpense::whereYear('created_at', '=', $year)->where('branch_id', $branch_id);

            $students = Enroll::distinct('user_id')->where('branch_id', $branch_id);

            $branch_income = AccountIncome::whereYear('created_at', '=', $year)->where('branch_id', $branch_id)->sum('amount');
            $branch_expense = AccountExpense::whereYear('created_at', '=', $year)->where('branch_id', $branch_id)->sum('amount');

            $data = [
                'page_title' => 'Dashboard',
                'enrolls' => $enrolls->get(),
                'enrolls_count' => $enrolls->count(),
                'student_count' => $students->count(),

                'income' => $income->get(),
                'expense' => $expense->get(),
                'total_revenue' => $income->sum('amount') - $expense->sum('amount'),

                'jan' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 1)->where('branch_id', $branch_id)->count(),
                'feb' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 2)->where('branch_id', $branch_id)->count(),
                'mar' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 3)->where('branch_id', $branch_id)->count(),
                'apr' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 4)->where('branch_id', $branch_id)->count(),
                'may' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 5)->where('branch_id', $branch_id)->count(),
                'jun' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 6)->where('branch_id', $branch_id)->count(),
                'jul' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 7)->where('branch_id', $branch_id)->count(),
                'aug' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 8)->where('branch_id', $branch_id)->count(),
                'sep' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 9)->where('branch_id', $branch_id)->count(),
                'oct' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 10)->where('branch_id', $branch_id)->count(),
                'nov' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 11)->where('branch_id', $branch_id)->count(),
                'dec' => Enroll::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 12)->where('branch_id', $branch_id)->count(),

                'janInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 1)->where('branch_id', $branch_id)->sum('amount'),
                'febInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 2)->where('branch_id', $branch_id)->sum('amount'),
                'marInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 3)->where('branch_id', $branch_id)->sum('amount'),
                'aprInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 4)->where('branch_id', $branch_id)->sum('amount'),
                'mayInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 5)->where('branch_id', $branch_id)->sum('amount'),
                'junInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 6)->where('branch_id', $branch_id)->sum('amount'),
                'julInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 7)->where('branch_id', $branch_id)->sum('amount'),
                'augInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 8)->where('branch_id', $branch_id)->sum('amount'),
                'sepInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 9)->where('branch_id', $branch_id)->sum('amount'),
                'octInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 10)->where('branch_id', $branch_id)->sum('amount'),
                'novInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 11)->where('branch_id', $branch_id)->sum('amount'),
                'decInc' => AccountIncome::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', 12)->where('branch_id', $branch_id)->sum('amount'),

                'branch_name' => Branch::where('id', $branch_id)->first()->branch_name,
                'branch_income' => $branch_income,
                'branch_expense' => $branch_expense,
                'branch_revenues' => $branch_income - $branch_expense,

                'current_year' => Carbon::now()->format('Y'),
                'selected_year' => $year,
            ];

            return view('admin.dashboards.dashboard_branch', $data);
        } else if (auth()->user()->hasRole(3)) {
            $i_id = Auth::id();
            $instructor = Auth::user();

            $data = [
                'page_title' => 'Dashboard',
                'instructor' => $instructor,
            ];

            return view('admin.dashboards.dashboard_instructor', $data);
        } else if (auth()->user()->hasRole(4)) {
            if (Auth::check()) {
                $s_id = Auth::id();
                $student = Auth::user();
                $enrolls = Enroll::where('user_id', $s_id)->get();
                $online_course_enrolls = VidCourseEnroll::where('user_id', $s_id)->get();
                $courses_completed = Enroll::where('user_id', $s_id)->where('status', 2)->count();

                $data = [
                    'page_title' => 'Dashboard',
                    'student' => $student,
                    'enrolls' => $enrolls,
                    'online_course_enrolls' => $online_course_enrolls,
                    'enrolls_count' => $enrolls->count(),
                    'courses_completed' => $courses_completed,
                ];

                return view('admin.dashboards.dashboard_student', $data);
            } else {
                session()->flash('error', 'Unauthorized Access!');
                return back();
            }
        } else {
            if (Auth::check()) {
                $s_id = Auth::id();
                $student = Auth::user();
                $enrolls = Enroll::where('user_i\d', $s_id)->get();
                $online_course_enrolls = VidCourseEnroll::where('user_id', $s_id)->get();
                $courses_completed = Enroll::where('user_id', $s_id)->where('status', 2)->count();

                $data = [
                    'page_title' => 'Dashboard',
                    'student' => $student,
                    'enrolls' => $enrolls,
                    'online_course_enrolls' => $online_course_enrolls,
                    'enrolls_count' => $enrolls->count(),
                    'courses_completed' => $courses_completed,
                ];

                return view('admin.dashboards.dashboard_student', $data);
            } else {
                session()->flash('error', 'Unauthorized Access!');
                return back();
            }
        }
    }

    public function view_course_details($enroll_id) {
        $student = Auth::user();
        $enroll = Enroll::find($enroll_id);
        $enroll_status = $enroll->status;
        $course = Course::find($enroll->course_id);
        $course_docs = CourseDoc::orderBy('created_at', 'DESC')->where('course_id', $course->id)->get();
        $duration = $enroll->type->duration;
        $class_count = $duration;
        $class_attended = StudentAttendance::where('enroll_id', $enroll_id)->count();
        $class_attended_per = $duration == 0 ? 0 : round(($class_attended * 100) / $duration);
        $quiz_count = Quiz::where('course_id', $enroll->course_category)->count();
        $passed_quiz_count = QuizScore::where('enrollment_id', $enroll->id)->where('score_in_percentage', '>=', 60)->count();
        $passed_quiz_per = $quiz_count == 0 ? 0 : round(($passed_quiz_count * 100) / $quiz_count);
        $review_exists = Review::where('enrollment_id', $enroll_id)->exists();

        $slots = CourseSlot::where('branch_id', $enroll->branch_id)->get();

        if (!$enroll_status) {
            return back()->with('notApproved', "You can't see the details until your enrollment gets approved. Please wait a bit or contact with us to get approved fast.");
        }

        $data = [
            'course_id' => $enroll_id,
            'student' => $student,
            'enroll' => $enroll,
            'enroll_status' => $enroll_status,
            'course' => $course,
            'class_count' => $class_count,
            'class_attended' => $class_attended,
            'class_attended_per' => $class_attended_per,
            'quiz_count' => $quiz_count,
            'passed_quiz_count' => $passed_quiz_count,
            'passed_quiz_per' => $passed_quiz_per,
            'course_docs' => $course_docs,
            'review_exists' => $review_exists,
            'slots' => $slots,
        ];

        return view('admin.dashboards.students_course_details', $data);
    }

    public function download_doc($id) {
        $doc = CourseDoc::find($id);

        $filePath = public_path('uploads/course_docs/' . $doc->name);
        // $headers = ['Content-Type: application/pdf'];
        $fileName = $doc->name;

        return response()->download($filePath, $fileName);
    }

    public function slot_change_apply(Request $request, $id) {
        $student = Auth::user();
        $enroll = Enroll::find($id);
        $branch = Branch::find($enroll->branch_id);
        $slot = CourseSlot::find($request->slot_id);

        $data = [
            'user' => $student,
            'enroll' => $enroll,
            'slot' => Carbon::parse($slot->start_time)->format('h:ia') . ' - ' . Carbon::parse($slot->end_time)->format('h:ia'),
        ];

        Mail::to($branch->email)->send(new SlotChangeApply($data));

        return back()->with('success', 'Done! Application Sent.');
    }

    public function slot_change(Request $request, $id) {
        $enroll = Enroll::find($id);
        $slot = CourseSlot::find($request->slot_id);

        $enroll->update([
            'course_slot' => $request->slot_id,
        ]);

        return back()->with('success', 'Done! Slot Changed Successfully.');
    }

    public function give_review($enroll_id) {
        $enroll = Enroll::find($enroll_id);
        $course = Course::find($enroll->course_id);

        return view('admin.madals.give-review', [
            'enroll' => $enroll,
            'course' => $course,
        ]);
    }

    public function review_add(Request $request) {
        $validator = Validator::make($request->all(), [
            'review' => 'required',
            'feedback' => 'required',
        ], [
            'review.required' => 'Please give a rating.',
            'feedback.required' => 'Please give your feedback.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        } else {
            Review::create([
                'enrollment_id' => $request->enrollment_id,
                'review' => $request->review,
                'review_text' => $request->feedback,
            ]);

            session()->flash('reviewSuccess', 'Thanks for your review!');
            return response()->json(['success' => true]);
        }
    }

    public function customers() {
        return view('admin.customers', [
            'users' => User::all(),
        ]);
    }

    public function test() {
        return view('admin.test', [
            'title' => 'Test Page',
        ]);
    }
}
