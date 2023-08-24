<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="SSLCommerz">
    <title>Pathway - SSl Checkout </title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-2 px-4">
        <div class="py-2 text-center">
            <h2>Course Enrollment Checkout</h2>
        </div>

        <div class="row pb-3">
            <div class="col-12 order-md-1">
                @php
                    session([
                        'user' => $user,
                        'course' => $course,
                        'enroll_data' => $enroll_data,
                        'enroll_id' => $enroll_id,
                    ]);
                @endphp
                <form method="POST" class="needs-validation" novalidate action="{{ route('pay.ssl') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="firstName">Full name</label>
                            <input readonly type="text" name="name" class="form-control" id="name" placeholder="" value="{{ $user->name }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="mobile">Mobile</label>
                        <div class="input-group">
                            <input readonly type="text" name="mobile" class="form-control" id="mobile" placeholder="Mobile" value="{{ $user->mobile }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="course_category">Course Category</label>
                                <input readonly type="text" class="form-control" id="course_category" placeholder="" value="{{ $course->rel_to_course_cat->category_name }}" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="course_type">Course Type</label>
                                <input readonly type="text" class="form-control" id="course_type" placeholder="" value="{{ $course->rel_to_course_type->type_name }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="price">Course Fee</label>
                                <input readonly type="text" class="form-control" id="price" placeholder="" value="BDT {{ $course->price }}" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="discount">Discount</label>
                                <input readonly type="text" class="form-control" id="discount" placeholder="" value="BDT {{ $discount }}" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="payable_amount">Payable Amount</label>
                                <input readonly type="text" class="form-control" id="payable_amount" placeholder="" value="BDT {{ $course->price - $discount }}" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="pay">Now Paying</label>
                                <input readonly type="text" class="form-control" id="pay" placeholder="" value="BDT {{ $enroll_data['paid'] }}" required>
                            </div>
                        </div>
                    </div>
                    @if ($course->price - $discount > $enroll_data['paid'])
                        <p class="text-orange">Your Due will be BDT {{ $course->price - $discount - $enroll_data['paid'] }}.</p>
                    @endif

                    @if ($course->price - $discount < $enroll_data['paid'])
                        <p class="text-danger">You are trying to pay more than needed! Please correct the paying amount.</p>
                    @else
                        <p class="site-text-primary">Click on the 'Pay Now' button to proceed to online payment.</p>
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" id="sslczPayBtn" token="if you have any token validation" postdata="your javascript arrays or objects which requires in backend" order="If you already have the transaction generated for current order" endpoint=""> Pay Now (BDT {{ $enroll_data['paid'] }})
                        </button>
                    @endif

                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    <!-- If you want to use the popup integration, -->
    <script>
        var obj = {};
        obj.cus_name = $('#name').val();
        obj.cus_phone = $('#mobile').val();
        obj.cus_email = $('#email').val();
        obj.cus_addr1 = $('#branch').val();
        obj.amount = $('#total_amount').val();

        $('#sslczPayBtn').prop('postdata', obj);

        (function(window, document) {
            var loader = function() {
                var script = document.createElement("script"),
                    tag = document.getElementsByTagName("script")[0];
                // script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR LIVE
                script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR SANDBOX
                tag.parentNode.insertBefore(script, tag);
            };

            window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
        })(window, document);
    </script>

</html>
