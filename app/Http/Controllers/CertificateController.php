<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Certificate;
use App\Models\Enroll;
use App\Models\VidCourseCertificate;
use App\Models\VidCourseEnroll;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CertificateController extends Controller {

    public function certificate_view($id) {
        $enroll = Enroll::find($id);
        $category = explode(' ', $enroll->category->category_name);
        $certificate_id = Str::upper($category[0]) . '-' . rand(111111, 999999);

        if (Certificate::where('enroll_id', $id)->exists()) {
            $certificate = Certificate::where('enroll_id', $id)->first();
        } else {
            $certificate = Certificate::create([
                'certificate_id' => $certificate_id,
                'enroll_id' => $enroll->id,
            ]);
        }

        // setOption(['defaultFont' => 'sans-serif'])->
        $data = [
            'certificate' => $certificate,
            'enroll' => $enroll,
        ];

        // $pdf = Pdf::loadView('admin.certificate.certificate', $data)->setPaper('a4', 'portrait');
        // return $pdf->download('certificate.pdf');

        return view('admin.certificate.certificate-view', [
            'certificate' => $certificate,
            'enroll' => $enroll,
        ]);
    }

    public function certificate_generate($id) {
        $enroll = Enroll::find($id);
        $certificate = Certificate::where('enroll_id', $id)->first();

        $data = [
            'certificate' => $certificate,
            'enroll' => $enroll,
        ];

        $pdf = Pdf::loadView('admin.certificate.certificate', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('certificate-' . rand(1111, 9999) . $id . '.pdf');
    }

    public function certificate_verify_view() {
        return view('admin.certificate.verify');
    }

    public function certificate_verify(Request $request) {
        $request->validate([
            'certificate_id' => 'required',
        ]);

        $c_id = $request->certificate_id;

        if (Certificate::where('certificate_id', $c_id)->exists()) {
            $certificate = Certificate::where('certificate_id', $c_id)->first();

            $student_name = $certificate->rel_to_enroll->user->name;
            $course_category = $certificate->rel_to_enroll->category->category_name;
            $course_type = $certificate->rel_to_enroll->type->type_name;

            return back()->with([
                'verifySuccess' => 'Certificate Verified Successfully!',
                'student_name' => $student_name,
                'course_category' => $course_category,
                'course_type' => $course_type,
                'c_id' => $c_id,
            ]);
        } else {
            return back()->with('verifyFailed', 'Certificate not found in our records!');
        }
    }


    public function online_course_certificate_view($id) {
        $enroll = VidCourseEnroll::find($id);
        $category = explode(' ', $enroll->vid_course->rel_to_course_cat->category_name);
        $certificate_id = Str::upper($category[0]) . 'ON-' . rand(111111, 999999);

        // return $certificate_id; 

        if (VidCourseCertificate::where('enroll_id', $id)->exists()) {
            $certificate = VidCourseCertificate::where('enroll_id', $id)->first();
        } else {
            $certificate = VidCourseCertificate::create([
                'certificate_id' => $certificate_id,
                'enroll_id' => $enroll->id,
            ]);
        }

        $data = [
            'certificate' => $certificate,
            'enroll' => $enroll,
            'manager_signature' => Branch::all()->first()->branch_manager_signature,
        ];

        return view('admin.vid-course-certificate.certificate-view', $data);
    }

    public function online_course_certificate_generate($id) {
        $enroll = VidCourseEnroll::find($id);
        $certificate = VidCourseCertificate::where('enroll_id', $id)->first();

        $data = [
            'certificate' => $certificate,
            'enroll' => $enroll,
            'manager_signature' => Branch::all()->first()->branch_manager_signature,
        ];

        $pdf = Pdf::loadView('admin.vid-course-certificate.certificate', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('certificate-' . rand(1111, 9999) . $id . '.pdf');
    }
}
