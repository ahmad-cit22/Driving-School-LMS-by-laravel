<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Mail\StudentEnroll;
use App\Models\AccountIncome;
use App\Models\BookedSchedule;
use App\Models\Course;
use App\Models\CourseType;
use App\Models\Enroll;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SslCommerzPaymentController extends Controller {

    public function easyCheckout() {
        // $data = [
        //     'user' => $user,
        //     'course' => Course::where('category_id', $request->course_category)->where('type_id', $request->course_type)->first(),
        //     'enroll_data' => $request->all(),
        //   'enroll_id' => $enroll->id,
        //         'discount' => $discount,
        // ];
        $enroll_data = session('enroll_details');

        return view('SSLCommerz.easy_checkout', $enroll_data);
    }

    public function easyCheckout_due() {
        // $data = [
        //     'user' => $user,
        //     'course' => Course::where('category_id', $request->course_category)->where('type_id', $request->course_type)->first(),
        //     'enroll_data' => $request->all(),
        //   'enroll_id' => $enroll->id,
        //         'discount' => $discount,
        // ];
        $enroll_data = [
            'enroll_data' => session('enroll_details_due')
        ];
        // return $enroll_data;

        return view('SSLCommerz.due_checkout', $enroll_data);
    }

    public function index(Request $request) {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "ssl_payments"
        # In "ssl_payments" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.
        if ($request->due != '') {
            $user = session('user');
            $enroll_data = session('enroll_data');
            $enroll_id = session('enroll_id');

            $enroll = Enroll::find($enroll_id);

            $due = $enroll->payable_amount - $enroll->paid;

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
                if ($request->pay > $due) {
                    return back()->with('errPay', "Can't pay more than the due amount!");
                } elseif ($request->pay < 10) {
                    return back()->with('errPay', "Can't pay less than BDT 10!");
                }
            }

            $post_data                 = array();
            $post_data['total_amount'] = $request->pay; # You cant not pay less than 10
            $post_data['currency']     = "BDT";
            $post_data['tran_id']      = uniqid(); // tran_id must be unique

            # CUSTOMER INFORMATION
            $post_data['cus_name']  = $user->name;
            $post_data['cus_email'] = $user->email;
            $post_data['cus_phone'] = $user->mobile;

            # SHIPMENT INFORMATION
            $post_data['ship_name'] = "Store Test";
            $post_data['ship_add1'] = "Dhaka";
            $post_data['ship_add2'] = "Dhaka";
            $post_data['ship_city'] = "Dhaka";
            $post_data['ship_state'] = "Dhaka";
            $post_data['ship_postcode'] = "1000";
            $post_data['ship_phone'] = "";
            $post_data['ship_country'] = "Bangladesh";

            $post_data['shipping_method'] = "NO";
            $post_data['product_name'] = "Computer";
            $post_data['product_category'] = "Goods";
            $post_data['product_profile'] = "physical-goods";

            #Before  going to initiate the payment order status need to insert or update as Pending.
            $update_product = DB::table('ssl_payments')
                ->where('transaction_id', $post_data['tran_id'])
                ->updateOrInsert([
                    'enroll_id' => $enroll_id,
                    'name' => $post_data['cus_name'],
                    'email' => $post_data['cus_email'],
                    'phone' => $post_data['cus_phone'],
                    'amount' => $post_data['total_amount'],
                    'status' => 'Pending',
                    'transaction_id' => $post_data['tran_id'],
                    'currency' => $post_data['currency'],
                    'created_at' => Carbon::now(),
                ]);

            $sslc = new SslCommerzNotification();
            # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
            $payment_options = $sslc->makePayment($post_data, 'hosted');

            if (!is_array($payment_options)) {
                print_r($payment_options);
                $payment_options = array();
            }
        } else {
            $user = session('user');
            $course = session('course');
            $enroll_data = session('enroll_data');
            $enroll_id = session('enroll_id');

            $post_data = array();
            $post_data['total_amount'] = $enroll_data['paid']; # You can not pay less than 10
            $post_data['currency'] = "BDT";
            $post_data['tran_id'] = uniqid(); // tran_id must be unique

            # CUSTOMER INFORMATION
            $post_data['cus_name'] = $user->name;
            $post_data['cus_email'] = $user->email;
            $post_data['cus_phone'] = $user->mobile;

            # SHIPMENT INFORMATION
            $post_data['ship_name'] = "Store Test";
            $post_data['ship_add1'] = "Dhaka";
            $post_data['ship_add2'] = "Dhaka";
            $post_data['ship_city'] = "Dhaka";
            $post_data['ship_state'] = "Dhaka";
            $post_data['ship_postcode'] = "1000";
            $post_data['ship_phone'] = "";
            $post_data['ship_country'] = "Bangladesh";

            $post_data['shipping_method'] = "NO";
            $post_data['product_name'] = "Computer";
            $post_data['product_category'] = "Goods";
            $post_data['product_profile'] = "physical-goods";

            #Before  going to initiate the payment order status need to insert or update as Pending.
            $update_product = DB::table('ssl_payments')
                ->where('transaction_id', $post_data['tran_id'])
                ->updateOrInsert([
                    'enroll_id' => $enroll_id,
                    'name' => $post_data['cus_name'],
                    'email' => $post_data['cus_email'],
                    'phone' => $post_data['cus_phone'],
                    'amount' => $post_data['total_amount'],
                    'status' => 'Pending',
                    'transaction_id' => $post_data['tran_id'],
                    'currency' => $post_data['currency'],
                    'created_at' => Carbon::now(),
                ]);

            $sslc = new SslCommerzNotification();
            # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
            $payment_options = $sslc->makePayment($post_data, 'hosted');

            if (!is_array($payment_options)) {
                print_r($payment_options);
                $payment_options = array();
            }
        }
    }

    public function payViaAjax(Request $request) {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "ssl_payments"
        # In ssl_payments table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('ssl_payments')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);


        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function success(Request $request) {
        // return "Transaction is Successful";

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_details = DB::table('ssl_payments')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending' || $order_details->status == 'Processing') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $enroll_id = DB::table('ssl_payments')
                    ->where('transaction_id', $tran_id)->first()->enroll_id;
                $enroll = Enroll::find($enroll_id);

                if ($enroll->payable_amount <= $enroll->paid && $enroll->payment_status == 2) {
                    return redirect()->route('admin.index')->with('enrollSuccess', 'You have already given the payment. Thanks!');
                }

                if (
                    DB::table('account_incomes')
                    ->where('enroll_id', $enroll_id)->get()->count() > 0
                ) {
                    if ($order_details->amount > 0) {
                        $previous_paid = $enroll->paid;
                        $due = $enroll->payable_amount - $enroll->paid;

                        if ($enroll->payable_amount > $enroll->paid + $order_details->amount) {
                            $enroll->update([
                                'paid' => $enroll->paid + $order_details->amount,
                                'payment_process' => 1,
                                'payment_status' => 1,
                            ]);
                        } else {
                            $enroll->update([
                                'paid' => $enroll->paid + $order_details->amount,
                                'payment_process' => 1,
                                'payment_status' => 2,
                            ]);
                        }

                        $update_product = DB::table('ssl_payments')
                            ->where('transaction_id', $tran_id)
                            ->update(['status' => 'Processing']);


                        // if ($order_details->amount > 0) {
                        AccountIncome::create([
                            'amount' => $order_details->amount,
                            'branch_id' => $enroll->branch_id,
                            'enroll_id' => $enroll_id,
                        ]);
                        // }

                        $user_id = $enroll->user_id;
                        $user = User::find($user_id);

                        $data1 = [
                            'user' => $user,
                            'enroll' => $enroll,
                            'due' => $due,
                            'now_paid' => $order_details->amount,
                            'previous_paid' => $previous_paid,
                        ];

                        // $invoicePdf = Pdf::setOption(['defaultFont' => 'sans-serif'])->loadView('invoice.invoice', $data1)->setPaper('a4', 'portrait');

                        // Mail::send('emails.student_due_pay', $data1, function ($message) use ($invoicePdf, $user) {
                        //     $message->to($user->email)
                        //         ->subject('Due Payment Received.')
                        //         ->attachData($invoicePdf->output(), 'invoice.pdf');
                        // });

                        return redirect()->route('admin.index')->with('enrollSuccess', 'Due Payment Successful!');
                    }
                } else {
                    if ($enroll->payable_amount > $enroll->paid) {
                        $enroll->update([
                            'payment_status' => 1,
                        ]);
                    } else {
                        $enroll->update([
                            'payment_status' => 2,
                        ]);
                    }

                    $update_product = DB::table('ssl_payments')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);


                    if ($enroll->paid > 0) {
                        AccountIncome::create([
                            'amount' => $enroll->paid,
                            'branch_id' => $enroll->branch_id,
                            'enroll_id' => $enroll_id,
                        ]);
                    }

                    for (
                        $i = 0;
                        $i < CourseType::find($enroll->course_type)->max_duration;
                        $i++
                    ) {
                        BookedSchedule::create([
                            'enroll_id' => $enroll_id,
                            'date' => Carbon::parse($enroll->start_date)->addDay($i)
                        ]);
                    }

                    $user_id = $enroll->user_id;
                    $user = User::find($user_id);

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

                    return redirect()->route('admin.index')->with('enrollSuccess', 'Transaction & Course Enrollment Successful! You can see your course details in your dashboard.');
                }
            }
        } else if ($order_details->status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            return redirect()->route('admin.index')->with('enrollSuccess', 'Transaction is successfully Completed! You can see your course details in your dashboard.');
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            return redirect()->route('enroll.index')->with('error', 'Invalid Transaction. Try Again Please.');
        }
    }

    public function fail(Request $request) {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('ssl_payments')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('ssl_payments')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function cancel(Request $request) {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('ssl_payments')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('ssl_payments')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function ipn(Request $request) {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('ssl_payments')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('ssl_payments')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to update database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }
}
