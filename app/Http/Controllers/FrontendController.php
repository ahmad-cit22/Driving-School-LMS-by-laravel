<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Mail\StudentEnroll;
use App\Models\AboutPart;
use App\Models\AccountIncome;
use App\Models\BannerPart;
use App\Models\Blog;
use App\Models\BlogTag;
use App\Models\BookedSchedule;
use App\Models\Branch;
use App\Models\BranchCapability;
use App\Models\BranchPart;
use App\Models\CertifiedByPart;
use App\Models\ContactPart;
use App\Models\CounterFact;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSlot;
use App\Models\CourseType;
use App\Models\DirectorSpeechPart;
use App\Models\Enroll;
use App\Models\FaqImage;
use App\Models\FaqQuestion;
use App\Models\Feature;
use App\Models\FeaturePart;
use App\Models\GalleryImage;
use App\Models\PrivacyPolicy;
use App\Models\RefundPolicy;
use App\Models\Review;
use App\Models\Setting;
use App\Models\TermsAndCondition;
use App\Models\TrainingProcessVideo;
use App\Models\User;
use App\Models\UserOtp;
use App\Models\VideoCourse;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FrontendController extends Controller {
    public function test() {
        return view('admin.otp_verification.index');
        // send_sms('01839096877', 'কাজ করে');
        // $data = 'https://google.com';
        // Mail::to('rhrony0009@gmail.com')->send(new StudentEnroll($data));
    }

    public function index() {
        $page_title = '';

        return view('frontend.index', [
            'page_title' => $page_title,
            'banner_part' => BannerPart::all()->first(),
            'featurePart' => FeaturePart::all()->first(),
            'features' => Feature::orderBy('priority')->take(6)->get(),
            'counters' => CounterFact::orderBy('priority')->take(4)->get(),
            'categories' => CourseCategory::all(),
            'video' => TrainingProcessVideo::all()->first(),
            'courses' => Course::orderBy('priority')->get(),
            'certified_by_parts' => CertifiedByPart::all(),
            'faq_questions' => FaqQuestion::all(),
            'faq_image' => FaqImage::all()->first(),
            'gallery_images' => GalleryImage::all(),
            'reviews' => Review::where('review', '>=', 3)->get(),
        ]);
    }

    public function enroll(Request $request) {
        $page_title = 'Offline Courses';
        $branches = Branch::where('status', 1)
            ->with('capability')
            ->with('slot')
            ->get()
            ->reject(function ($data) {
                return $data->capability == null;
            })
            ->reject(function ($data) {
                return $data->slot == null;
            });

        $data = [
            'page_title' => $page_title,
            'branches' => $branches,
            'types' => CourseType::all(),
            'courses' => Course::all(),
            'certified_by_parts' => CertifiedByPart::all(),
        ];
        return view('frontend.enroll', $data);
    }

    public function coupon_apply(Request $request, $id) {
        $idArr = explode('.', $id);
        $branch_id = $idArr[0];
        $category_id = $idArr[1];
        $type_id = $idArr[2];
        $price = $idArr[3];

        $course = Course::where('category_id', $category_id)->where('type_id', $type_id)->first();
        $coupon = $request->coupon_code;

        //here
        $message = '';
        $coupon_type = '';
        $available_for = '';
        $for_branch = '';
        $limit = '';
        $discount_coupon = 0;

        if (!empty($coupon)) {
            if (Coupon::where('coupon_code', $coupon)->exists()) {
                $coupon_data = Coupon::where('coupon_code', $coupon)->first();
                if (Carbon::now()->format('Y-m-d') <= $coupon_data->validity) {
                    if ($coupon_data->branch_id == 1 || ($coupon_data->branch_id - 1) == $branch_id) {
                        if ($coupon_data->available_for == 1 || ($coupon_data->available_for - 1) == $course->id) {
                            if ($coupon_data->coupon_type == '1') {
                                $discount_coupon = $coupon_data->discount_amount;
                                $message = 'Coupon applied successfully! You got ' . round($discount_coupon) . ' TK discount.';

                                return response()->json([
                                    'success' => $message,
                                    'discount_coupon' => round($discount_coupon),
                                ]);
                            } else {
                                $limit = $coupon_data->limit;
                                $discount_coupon = ($coupon_data->discount_amount * $price) / 100;

                                if ($discount_coupon > $limit) {
                                    $discount_coupon = $limit;

                                    $message = 'Coupon applied successfully! You got ' . round($discount_coupon) . ' TK discount.';

                                    return response()->json([
                                        'success' => $message,
                                        'discount_coupon' => round($discount_coupon),
                                    ]);
                                }

                                $message = 'Coupon applied successfully! You got ' . $coupon_data->discount_amount . '% (BDT ' . round($discount_coupon) . ') discount.';

                                return response()->json([
                                    'success' => $message,
                                    'discount_coupon' => round($discount_coupon),
                                ]);
                            }
                        } else {
                            $message = 'This coupon code is not applicable for this course.';
                            return response()->json([
                                'error' => $message,
                                'discount_coupon' => $discount_coupon,
                            ]);
                        }
                    } else {
                        $message = 'This coupon code is not applicable for this branch.';
                        return response()->json([
                            'error' => $message,
                            'discount_coupon' => $discount_coupon,
                        ]);
                    }
                } else {
                    $message = 'This coupon code is expired.';
                    return response()->json([
                        'error' => $message,
                        'discount_coupon' => $discount_coupon,
                    ]);
                }
            } else {
                $message = 'This coupon code does not exist.';
                return response()->json([
                    'error' => $message,
                    'discount_coupon' => $discount_coupon,
                ]);
            }
        } else {
            $message = "Sorry! You didn't enter any code!";
            return response()->json([
                'error' => $message,
                'discount_coupon' => $discount_coupon,
                'coupon_type' => $coupon_type,
                'available_for' => $available_for,
                'for_branch' => $for_branch,
                'limit' => $limit,
            ]);
        }
        //coupon process
    }

    public function get_category($id) {
        $all_categories = BranchCapability::where('branch_id', $id)->where('available_vehical', '>', 0)->with('category')->orderBy('category_id', 'ASC')->get();

        $html = '<option></option>';
        foreach ($all_categories as $category) {
            $html .= '<option value="' . $category->category->id . '">' . $category->category->category_name . '</option>';
        }
        return $html;
    }

    public function get_price($id) {
        $idArr = explode('.', $id);
        $category_id = $idArr[0];
        $type_id = $idArr[1];

        if (Course::where('category_id', $category_id)->where('type_id', $type_id)->exists()) {
            $price = Course::where('category_id', $category_id)->where('type_id', $type_id)->first()->after_discount;
            return $price;
        } else {
            return response()->json(['priceError' => 'No Courses Available Now Under this Course Type! Please Select Branch, Course Category & Type again Correctly to Proceed.']);
        }
    }

    public function get_slot($id) {
        $all_slot = CourseSlot::where('branch_id', $id)->where('type', 1)->orderBy('start_time', 'ASC')->get();
        $html = '<option></option>';
        foreach ($all_slot as $slot) {
            $html .= "<option value='" . $slot->id . "'>" . Carbon::parse($slot->start_time)->format('h:i A') . "-" . Carbon::parse($slot->end_time)->format('h:i A') . "</option>";
        }
        return $html;
    }

    public function enroll_store(Request $request) {
        // return response()->json(['errors' => $request->all()]);
        if (User::where('mobile', $request->mobile)->exists()) {
            return view('frontend.modals.login-modal', ['mobile' => $request->mobile]);
        }
        if (Auth::check()) {
            if ($request->payment_process == '1') {
                $validator = Validator::make($request->all(), [
                    'branch' => 'required',
                    'course_category' => 'required',
                    'course_type' => 'required',
                    'course_slot' => 'required',
                    'price' => 'required',
                    'paid' => 'required|numeric|min:1000',
                    'start_date' => 'required'
                ], [
                    'price.required' => 'Please select Course Category & Type to get the Fee.',
                    'paid.min' => "The paying amount must be not less than BDT 1000.",
                ]);

                if ($request->price < $request->paid) {
                    return response()->json(['paidErr' => "You can't pay more than the course fee! <br> Please fill up the form fields properly."]);
                }
            } else {
                $validator = Validator::make($request->all(), [
                    'branch' => 'required',
                    'course_category' => 'required',
                    'course_type' => 'required',
                    'course_slot' => 'required',
                    'price' => 'required',
                    'payment_process' => 'required',
                    'start_date' => 'required'
                ], [
                    'price.required' => 'Please select Course Category & Type to get the Fee.',
                ]);
            }
        } else {
            if ($request->payment_process == '1') {
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'mobile' => 'required|unique:users,mobile|regex:/(01)[0-9]{9}/',
                    'email' => 'required|unique:users,email',
                    'nid' => 'required|unique:users,nid',
                    'b_date' => 'required',
                    'branch' => 'required',
                    'course_category' => 'required',
                    'course_type' => 'required',
                    'course_slot' => 'required',
                    'price' => 'required',
                    'paid' => 'required|numeric|min:1000',
                    'start_date' => 'required',
                    'password' => 'required|same:confirm_password',
                    'confirm_password' => 'required',
                ], [
                    'paid.min' => "The paying amount must be not less than BDT 1000.",
                    'mobile.unique' => 'Mobile number has already been taken.',
                    'nid.required' => 'NID number is required.',
                    'email.unique' => 'Email has already been taken.',
                    'price.required' => 'Please select Course Category & Type to get the Fee.',
                    'password.same' => 'Password and confirm password does not match.'
                ]);

                if ($request->price < $request->paid) {
                    return response()->json(['paidErr' => "You can't pay more than the course fee! Please fill up the form fields properly."]);
                }
            } else {
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'mobile' => 'required|unique:users,mobile|regex:/(01)[0-9]{9}/',
                    'email' => 'required|unique:users,email',
                    'address' => 'required',
                    'nid' => 'required|unique:users,nid',
                    'b_date' => 'required',
                    'branch' => 'required',
                    'course_category' => 'required',
                    'course_type' => 'required',
                    'course_slot' => 'required',
                    'price' => 'required',
                    'payment_process' => 'required',
                    'start_date' => 'required',
                    'password' => 'required|same:confirm_password',
                    'confirm_password' => 'required',
                ], [
                    'mobile.unique' => 'Mobile number has already been taken.',
                    'nid.required' => 'NID number is required.',
                    'email.unique' => 'Email has already been taken.',
                    'price.required' => 'Please select Course Category & Type to get the Fee.',
                    'password.same' => 'Password and confirm password does not match.'
                ]);
            }
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        } else {

            $capability = BranchCapability::where('branch_id', $request->branch)->where('category_id', $request->course_category)->first()->available_vehical;

            for ($i = 0; $i < CourseType::find($request->course_type)->max_duration; $i++) {
                $date = Carbon::parse($request->start_date)->addDay($i);
                if (Enroll::where('branch_id', $request->branch)->where('course_category', $request->course_category)->where('course_slot', $request->course_slot)->where('status', 1)->with('booked')->whereHas('booked', function ($q) use ($date) {
                    $q->where('date', $date);
                })->count() >= $capability) {
                    return response()->json(['errors' => ['start_date' => 'Schedule already booked. Please choose another date or time slot.', 'course_slot' => '', 'course_category' => '', 'branch' => '']]);
                }
            }

            if (Auth::check()) {
                $user = auth()->user();
            } else {
                $id_no = '#' . Str::upper(Str::random(2)) . rand(11111, 99999);

                $password =  $request->password;
                $user = User::create([
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'email' => $request->email,
                    'address' => $request->address,
                    'nid' => $request->nid,
                    'b_date' => $request->b_date,
                    'id_no' => $id_no,
                    'password' => bcrypt($password),
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

            $course = Course::where('category_id', $request->course_category)->where('type_id', $request->course_type)->first();
            $course_id = $course->id;

            $discount = round($course->price - round($request->price));
            $discount_coupon_exists = $request->discount_coupon_exists;
            $discount_coupon = $request->discount_coupon;

            if ($request->payment_process == '1') {

                if ($discount_coupon_exists && $discount_coupon != '') {
                    $discount = round($discount + $discount_coupon);
                }

                //enroll store
                $enroll = Enroll::create([
                    'user_id' => $user->id,
                    'branch_id' => $request->branch,
                    'course_id' => $course_id,
                    'course_category' => $request->course_category,
                    'course_type' => $request->course_type,
                    'course_slot' => $request->course_slot,
                    'price' => $course->price,
                    'discount' => $discount,
                    'payable_amount' => ($course->price - $discount),
                    'payment_process' => $request->payment_process,
                    'paid' => $request->paid,
                    'payment_status' => 0,
                    'start_date' => $request->start_date,
                ]);

                $data = [
                    'user' => $user,
                    'course' => $course,
                    'enroll_data' => $request->all(),
                    'enroll_id' => $enroll->id,
                    'discount' => $discount,
                ];

                return redirect()->route('ssl.checkout.box')->with('enroll_details', $data);
            } else if ($request->payment_process == '2') {

                if ($discount_coupon_exists && $request->discount_coupon != '') {
                    $discount = round($discount + $discount_coupon);
                }

                //enroll store
                $enroll = Enroll::create([
                    'user_id' => $user->id,
                    'branch_id' => $request->branch,
                    'course_id' => $course_id,
                    'course_category' => $request->course_category,
                    'course_type' => $request->course_type,
                    'course_slot' => $request->course_slot,
                    'price' => $course->price,
                    'discount' => $discount,
                    'payable_amount' => ($course->price - $discount),
                    'payment_process' => $request->payment_process,
                    'start_date' => $request->start_date,
                ]);

                for ($i = 0; $i < CourseType::find($request->course_type)->max_duration; $i++) {
                    BookedSchedule::create([
                        'enroll_id' => $enroll->id,
                        'date' => Carbon::parse($request->start_date)->addDay($i)
                    ]);
                }

                $data1 = [
                    'user' => $user,
                    'enroll' => $enroll,
                ];

                // $invoicePdf = Pdf::setOption(['defaultFont' => 'sans-serif'])->loadView('invoice.invoice', $data1)->setPaper('a4', 'portrait');

                // Mail::send('emails.student_enroll', $data1, function ($message) use ($invoicePdf, $user) {
                //     $message->to($user->email)
                //         ->subject('Course Enrollment Confirmation.')
                //         ->attachData($invoicePdf->output(), 'invoice.pdf');
                // });

                // $formPdf = Pdf::setOption(['defaultFont' => 'sans-serif'])->loadView('invoice.enrollment_form', $data1)->setPaper('a4', 'portrait');

                // Mail::send('emails.enrollment_form', $data1, function ($message) use ($formPdf, $user) {
                //     $message->to($user->email)
                //         ->subject('Course Enrollment Form.')
                //         ->attachData($formPdf->output(), 'enrollment_form.pdf');
                // });

                session([
                    'enrollSuccess' => 'Course enrollment successful! You can see your course details in your dashboard.',
                ]);

                return response()->json(['success' => true]);
            }
        }
    }

    public function due_pay($id) {
        $enroll = Enroll::find($id);

        $data = [
            'enroll' => $enroll,
        ];

        return view('SSLCommerz.due_checkout', $data);
        // return redirect()->route('ssl.due_checkout.box')->with('enroll_details_due', $data);
    }

    public function rcv_pay_offline(Request $request) {
        $enroll = Enroll::find($request->enroll_id);

        $previous_paid = $enroll->paid;
        $due = $enroll->payable_amount - $enroll->paid;

        $request->validate([
            'pay' => 'required'
        ]);

        if ($request->pay > 0) {
            if ($enroll->payment_status < 1) {
                $enroll->update([
                    'paid' => 0,
                ]);

                if ($request->pay > $enroll->payable_amount) {
                    return back()->with('errPay', "Can't pay more than the payable amount!");
                } elseif ($request->pay < 10) {
                    return back()->with('errPay', "Can't pay less than BDT 10!");
                }
            } else {
                if ($request->pay > $enroll->payable_amount - $enroll->paid) {
                    return back()->with('errPay', "Can't pay more than the due amount!");
                } elseif ($request->pay < 10) {
                    return back()->with('errPay', "Can't pay less than BDT 10!");
                }
            }

            if ($enroll->payable_amount > $enroll->paid + $request->pay) {
                $enroll->update([
                    'paid' => $enroll->paid + $request->pay,
                    'payment_process' => 2,
                    'payment_status' => 1,
                ]);
            } else {
                $enroll->update([
                    'paid' => $enroll->paid + $request->pay,
                    'payment_process' => 2,
                    'payment_status' => 2,
                ]);
            }


            AccountIncome::create([
                'amount' => $request->pay,
                'branch_id' => $enroll->branch_id,
                'enroll_id' => $enroll->id,
            ]);


            $user_id = $enroll->user_id;
            $user = User::find($user_id);

            $data1 = [
                'user' => $user,
                'enroll' => $enroll,
                'due' => $due,
                'now_paid' => $request->pay,
                'previous_paid' => $previous_paid,
            ];

            // $pdf = Pdf::setOption(['defaultFont' => 'sans-serif'])->loadView('invoice.invoice', $data1)->setPaper('a4', 'portrait');

            // Mail::send('emails.student_due_pay', $data1, function ($message) use ($pdf, $user) {
            //     $message->to($user->email)
            //         ->subject('Due Payment Received.')
            //         ->attachData($pdf->output(), 'invoice.pdf');
            // });

            return back()->with('success', 'Payment Received Successfully!');
        } else {
            return back()->with('extraPay', "Please enter the amount correctly!");
        }
    }

    public function enroll_form_generate($id) {
        $enroll = Enroll::find($id);
        $user = User::find($enroll->user->id);

        $data = [
            'user' => $user,
            'enroll' => $enroll,
        ];

        $formPdf = Pdf::setOption(['defaultFont' => 'sans-serif'])->loadView('invoice.enrollment_form', $data)->setPaper('a4', 'portrait');
        return $formPdf->stream('enroll_form-00' . $id . '.pdf');
    }

    public function enroll_invoice_generate($id) {
        $enroll = Enroll::find($id);
        $user = User::find($enroll->user->id);

        $data = [
            'user' => $user,
            'enroll' => $enroll,
        ];

        $pdf = Pdf::loadView('invoice.invoice', $data)->setPaper('a4', 'portrait');
        return $pdf->stream('invoice-' . Carbon::parse($enroll->created_at)->format('Ymdhis') . $id . '.pdf');
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'login_password' => 'required'
        ], [
            'login_password.required' => 'The password field is required.'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        }

        if (Auth::attempt(['mobile' => $request->mobile, 'password' => $request->login_password])) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['errors' => ['login_password' => 'Password not match.']]);
        }
    }

    public function about() {
        $page_title = 'About Us';
        return view('frontend.about', [
            'page_title' => $page_title,
            'banner_part' => BannerPart::all()->first(),
            'featurePart' => FeaturePart::all()->first(),
            'features' => Feature::orderBy('priority')->take(6)->get(),
            'counters' => CounterFact::orderBy('priority')->take(4)->get(),
            'about_part' => AboutPart::all()->first(),
            'video' => TrainingProcessVideo::all()->first(),
            'director_speech_part' => DirectorSpeechPart::all()->first(),
            'certified_by_parts' => CertifiedByPart::all(),
            'faq_questions' => FaqQuestion::all(),
            'faq_image' => FaqImage::all()->first(),
        ]);
    }

    public function contact() {
        $page_title = 'Contact With Us';
        $rand_1 = rand(1, 9);
        $rand_2 = rand(1, 9);
        $branches = Branch::where('status', 1)->get();
        $branch_content = BranchPart::all()->first();
        $contact_content = ContactPart::all()->first();

        return view('frontend.contact', [
            'page_title' => $page_title,
            'rand_1' => $rand_1,
            'rand_2' => $rand_2,
            'branches' => $branches,
            'branch_content' => $branch_content,
            'contact_content' => $contact_content,
            'certified_by_parts' => CertifiedByPart::all(),
        ]);
    }



    public function privacy_policy() {
        $page_title = 'Privacy Policy';
        $privacy_policy = PrivacyPolicy::all()->first();

        return view('frontend.privacy_policy', [
            'page_title' => $page_title,
            'privacy_policy' => $privacy_policy,
            'certified_by_parts' => CertifiedByPart::all(),
        ]);
    }

    public function terms_and_conditions() {
        $page_title = 'Terms & Conditions';
        $terms_and_conditions = TermsAndCondition::all()->first();

        return view('frontend.terms_and_conditions', [
            'page_title' => $page_title,
            'terms_and_conditions' => $terms_and_conditions,
            'certified_by_parts' => CertifiedByPart::all(),
        ]);
    }

    public function refund_policy() {
        $page_title = 'Refund Policy';
        $refund_policy = RefundPolicy::all()->first();

        return view('frontend.refund_policy', [
            'page_title' => $page_title,
            'refund_policy' => $refund_policy,
            'certified_by_parts' => CertifiedByPart::all(),
        ]);
    }

    public function courses_view() {
        $page_title = 'Our Courses';

        return view('frontend.courses', [
            'page_title' => $page_title,
            'categories' => CourseCategory::all(),
            'courses' => Course::all(),
            'online_courses' => VideoCourse::all(),
            'faq_questions' => FaqQuestion::all(),
            'faq_image' => FaqImage::all()->first(),
            'certified_by_parts' => CertifiedByPart::all(),
        ]);
    }

    public function course_details_view($id) {
        $course = Course::find($id);

        $page_title = $course->rel_to_course_cat->category_name . ' - ' . $course->rel_to_course_type->type_name;

        return view('frontend.course-details', [
            'page_title' => $page_title,
            'single_course' => $course,
            'courses' => Course::all(),
            'faq_questions' => FaqQuestion::all(),
            'faq_image' => FaqImage::all()->first(),
            'certified_by_parts' => CertifiedByPart::all(),
        ]);
    }

    public function blogs_view() {
        $page_title = 'Blogs';

        return view('frontend.blogs.blogs', [
            'page_title' => $page_title,
            'blogs' => Blog::orderBy('created_at', 'desc')->take(8)->get(),
            'certified_by_parts' => CertifiedByPart::all(),
        ]);
    }

    public function blogs_filter_view($id) {
        $tag = BlogTag::find($id);
        $page_title = "Blogs with the tag '" . $tag->tag_name . "'";

        return view('frontend.blogs.blogs', [
            'page_title' => $page_title,
            'blogs' => Blog::orderBy('created_at', 'desc')->whereRelation('blog_tags', 'tag_id', $id)->get(),
            'certified_by_parts' => CertifiedByPart::all(),
        ]);
    }

    public function blogs_view_all() {
        $page_title = 'Blogs';

        return view('frontend.blogs.blogs', [
            'page_title' => $page_title,
            'blogs' => Blog::orderBy('created_at', 'desc')->get(),
            'certified_by_parts' => CertifiedByPart::all(),
        ]);
    }

    public function single_blogs_view($id) {
        $blog = Blog::find($id);
        $page_title = $blog->blog_title;

        return view('frontend.blogs.single-blog', [
            'page_title' => $page_title,
            'blog' => $blog,
            'certified_by_parts' => CertifiedByPart::all(),
        ]);
    }

    public function contact_mail(Request $request) {

        $request->validate([
            'name' => 'required|max:30',
            'email' => 'required|email',
            'number' => 'required|max:20',
            'subject' => 'required',
            'message' => 'required',
            'contact-agreement' => 'required',
        ], [
            'contact-agreement.required' => 'You must agree with the Terms of Use and Privacy Policy to send message to us.'
        ]);

        $contact_email = Setting::where('key', 'email')->first()->value;

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        Mail::to($contact_email)->send(new ContactMail($data));

        return back()->with('contactSuccess', 'Thanks for contacting. Your message was sent successfully!');
    }
}
