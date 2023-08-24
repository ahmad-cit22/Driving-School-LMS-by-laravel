<?php

namespace App\Http\Controllers;

use App\Models\BookedSchedule;
use App\Models\CourseSlot;
use App\Models\Enroll;
use App\Models\VidCourseEnroll;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EnrollController extends Controller {
    public function __construct() {
    }

    public function index() {
        if (auth()->user()->hasRole(1)) {
            $data = [
                'enrolls' => Enroll::orderBy('created_at', 'desc')->with('user')->with('branch')->with('category')->with('type')->with('slot')->get(),
                'online_course_enrolls' => VidCourseEnroll::all(),
            ];
        } elseif (auth()->user()->hasRole(2)) {
            $data = [
                'enrolls' => Enroll::orderBy('created_at', 'desc')->with('user')->with('branch')->with('category')->with('type')->with('slot')->get(),
                'online_course_enrolls' => VidCourseEnroll::all(),
            ];
        } elseif (auth()->user()->hasRole(4)) {
            $data = ['enrolls' => Enroll::orderBy('created_at', 'desc')->where('user_id', auth()->id())->with('user')->with('branch')->with('category')->with('type')->with('slot')->get()];
        } else {
            $data = [
                'enrolls' => Enroll::orderBy('created_at', 'desc')->with('user')->with('branch')->with('category')->with('type')->with('slot')->get(),
                'online_course_enrolls' => VidCourseEnroll::all(),
            ];
        }

        return view('admin.enroll.index', $data);
    }

    public function approve($id) {
        if (auth()->user()->hasRole([1, 2])) {
            Enroll::find($id)->update([
                'status' => 1
            ]);
            return back()->with('success', 'The enrollment approved successfully.');
        } else {
            return back()->with('error', 'Access Denied.');
        }
    }

    public function delete($id) {
        if (auth()->user()->hasRole([1, 2])) {
            BookedSchedule::where('enroll_id', $id)->delete();
            Enroll::find($id)->delete();
            return back()->with('success', 'The enrollment deleted successfully.');
        } else {
            return back()->with('error', 'Access Denied.');
        }
    }

    public function online_course_approve($id) {
        if (auth()->user()->hasRole([1, 2])) {
            VidCourseEnroll::find($id)->update([
                'status' => 1
            ]);
            return back()->with('success', 'The enrollment has been approved successfully.');
        } else {
            return back()->with('error', 'Access Denied.');
        }
    }

    public function online_course_delete($id) {
        if (auth()->user()->hasRole([1, 2])) {
            VidCourseEnroll::find($id)->delete();
            return back()->with('success', 'The enrollment has been deleted successfully.');
        } else {
            return back()->with('error', 'Access Denied.');
        }
    }

    public function show($id) {
        $enroll = Enroll::with('user')->with('branch')->with('category')->with('type')->with('slot')->find($id);
        $slots = CourseSlot::where('branch_id', $enroll->branch_id)->get();

        $data = [
            'enroll' => $enroll,
            'slots' => $slots,
            'page_title' => 'Enroll: ' . $enroll->user->name
        ];

        return view('admin.enroll.show', $data);
    }
    public function fetch($id) {
        $event = [];
        $enroll = Enroll::with('slot')->with('branch')->find($id);
        $theory_slot = CourseSlot::with('days')->where('branch_id', $enroll->branch_id)->where('type', 2)->orderBy('start_time', 'ASC')->get();
        foreach ($theory_slot as $key => $day) {
            $days[$key] = $day->days->day;
        }

        foreach (BookedSchedule::with('enroll.type')->where('enroll_id', $id)->get() as $key => $schedule) {
            $duration = $schedule->enroll->type->duration;
            $serial = $key + 1;
            if ($serial <= $duration) {
                $class = "C-$serial ";
            } else {
                $sub = $serial - $duration;
                $class = "EC-$sub ";
            }
            if (in_array(Carbon::parse($schedule->date)->format('l'), $days)) {
                foreach ($theory_slot as $key => $day) {
                    if (Carbon::parse($schedule->date)->format('l') == $day->days->day) {
                        $event[] = [
                            "title" => $class . Carbon::parse($day->start_time)->format('h:ia') . "-" . Carbon::parse($day->end_time)->format('h:ia'),
                            "start" => $schedule->date,
                            "end" => $schedule->date,
                            "color" => "#ea1d22",
                        ];
                    }
                }
            } else {
                $event[] = [
                    "title" => $class . Carbon::parse($enroll->slot->start_time)->format('h:ia') . "-" . Carbon::parse($enroll->slot->end_time)->format('h:ia'),
                    "start" => $schedule->date,
                    "end" => $schedule->date,
                    "color" => "#F5821F",
                ];
            }
        }

        return $event;
    }
}
