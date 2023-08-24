@extends('layouts.frontend')
@section('content')
    <div class="container py-5">
        <div class="card border-0">
            <div class="card-body">
                <form id="enroll">
                    @csrf
                    <div class="row">
                        @guest
                            <div class="form-group col-md-6">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Please enter your full name">
                                <div class="error"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mobile">Mobile Number</label>
                                <input type="phone" name="mobile" id="mobile" class="form-control" placeholder="Please Enter a valid mobile number">
                                <div class="error"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email Address">
                                <div class="error"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address">Present Address</label>
                                <input type="text" name="address" id="address" class="form-control" placeholder="Enter Your Present Address">
                                <div class="error"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="b_date">Date of Birth</label>
                                <input type="date" name="b_date" id="b_date" class="form-control" placeholder="Enter Your Date of Birth">
                                <div class="error"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nid">NID No.</label>
                                <input type="number" name="nid" id="nid" class="form-control" placeholder="Enter Your NID Number">
                                <div class="error"></div>
                            </div>
                        @endguest
                        <div class="form-group col-md-6">
                            <label for="branch">Branch Name</label>
                            <select name="branch" id="branch" class="form-control select2" required>
                                <option></option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                            <div class="error"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="course_category">Course Category <sub>(Select branch to get categories)</sub></label>
                            <select name="course_category" id="course_category" class="form-control select2" required>
                                <option></option>
                            </select>
                            <div class="error"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="course_type">Course Type</label>
                            <select name="course_type" id="course_type" class="form-control select2" required>
                                <option></option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->type_name }} ({{ $type->duration }} Day{{ $type->duration > 1 ? 's' : '' }})</option>
                                @endforeach
                            </select>
                            <div class="error"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price">Course Fee (BDT)</label>
                            <input readonly type="number" name="price" id="price" class="form-control" placeholder="Select Course Category & Type to get the Fee">
                            <div class="error"></div>
                        </div>

                        {{-- discount_coupon_view --}}
                        <div class="form-group col-md-6" id="discount_coupon_box" style="display: none;">
                            <label for="price">Discount (From Coupon)</label>
                            {{-- discount_amount show to user --}}
                            <input readonly type="text" id="discount_coupon_view" name="discount_coupon_view" class="form-control" value="" placeholder="Get Discount form Coupon">

                        </div>
                        {{-- discount_coupon_view --}}

                        {{-- discount_amount sending to enroll_store  --}}
                        <div>
                            <input readonly hidden type="number" name="discount_coupon_exists" id="discount_coupon_exists" class="form-control" value="">
                            <input readonly hidden type="number" name="discount_coupon" id="discount_coupon" class="form-control" value="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="payment_process">Payment Process</label>
                            <select name="payment_process" id="payment_process" class="form-control select2">
                                <option value="1" selected> Online Payment </option>
                                <option value="2"> Office Payment </option>
                            </select>
                            <div class="error"></div>
                        </div>
                        <div class="form-group col-md-6" id="paidBox" style="">
                            <label for="paid">Enter the amount you want to pay now (BDT)</label>
                            <input type="number" name="paid" id="paid" class="form-control" placeholder="Minimum paying amount - BDT 1000">
                            <div class="error"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="start_date">Start Date</label>
                            <input type="text" name="start_date" id="start_date" class="form-control datepicker" placeholder="Choose a date" autocomplete="off" required>
                            <div class="error"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="course_slot">Time Slot</label>
                            <select name="course_slot" id="course_slot" class="form-control select2" required>
                                <option></option>
                            </select>
                            <div class="error"></div>
                        </div>
                        @guest
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <span id="show-password"><i class="fa-solid fa-eye"></i></span>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off">
                                <div class="error"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" autocomplete="off">
                                <div class="error"></div>
                            </div>
                        @endguest
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn site-bg-primary text-white" id="submit-btn">Enroll Now</button>
                    </div>
                </form>

                <!-- Coupon -->
                <div class="row">
                    <div class="col-5 mx-auto">
                        <form class="mt-3 mb-7 mb-md-0" id="couponForm">
                            @csrf
                            {{-- <form class="mt-3 mb-7 mb-md-0" id="couponForm" action="{{ route('enroll.index') }}" method="GET"> --}}
                            <label class="fs-sm ft-medium text-dark">Coupon code:</label>
                            <div class="row form-row display-flex justify-content-between">
                                <div class="col">
                                    <input class="form-control" type="text" placeholder="Enter coupon code if available" name="coupon_code">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" id="couponBtn" class="btn site-bg-secondary">Apply</button>
                                </div>
                            </div>
                            <p class="errorCoupon text-danger"></p>
                        </form>
                    </div>
                </div>
                <!-- Coupon -->
            </div>
        </div>
    </div>

    <!-- login-Modal -->
    <div class="modal fade" id="login-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <!-- checkout-Modal -->
    <div class="modal fade" id="checkout-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        form .error {
            font-size: .9em;
            color: #dc3545;
            display: none;
        }

        form .form-control.is-invalid {
            background-image: unset;
        }

        form #show-password {
            position: absolute;
            right: 30px;
            top: 40px;
        }
    </style>
@endsection

@section('script')
    <script>
        function getDataAjax(id) {
            let url_category = "{{ route('enroll.get.catgory', ':id') }}";
            let url_slot = "{{ route('enroll.get.slot', ':id') }}";
            $.ajax({
                method: 'get',
                url: url_category.replace(':id', id),
                success: function(response) {
                    $('#course_category').html(response);
                    if (formData.course_category) {
                        $("#course_category").val(formData.course_category).trigger('change');
                    }
                }
            });
            $.ajax({
                method: 'get',
                url: url_slot.replace(':id', id),
                success: function(response) {
                    $('#course_slot').html(response);
                    if (formData.course_category) {
                        $("#course_slot").val(formData.course_slot).trigger('change');
                    }
                }
            });
        }

        function getPriceAjax(id) {
            let url = "{{ route('enroll.get.price', ':id') }}";

            $.ajax({
                method: 'get',
                url: url.replace(':id', id),
                success: function(response) {
                    if (response.priceError) {
                        Swal.fire(
                            'Sorry!',
                            response.priceError,
                            'error'
                        );
                    } else {
                        document.getElementById('price').value = response;
                    }
                }
            });
        }

        $('#course_type').change(function() {
            let category_id = $('#course_category').val();
            let type_id = $('#course_type').val();
            // alert(category_id + '.' + type_id);

            getPriceAjax(category_id + '.' + type_id);
        });

        let formData = JSON.parse(localStorage.getItem("formData"));
        if (!formData) {
            formData = {};
        }
        if (formData.branch) {
            $("#branch").val(formData.branch).trigger('change');
            getDataAjax(formData.branch);
        }
        if (formData.branch) {
            $("#course_type").val(formData.course_type).trigger('change');
        }
        if (formData.start_date) {
            $("#start_date").val(formData.start_date).trigger('change');
        }
        $('#branch').change(function() {
            let branch_id = $(this).val();
            getDataAjax(branch_id);
        });
        $('#payment_process').change(function() {
            let payment_process = $(this).val();
            if (payment_process == '1') {
                $('#paidBox').show();
            } else {
                $('#paidBox').hide();
            }
        });

        $('#couponForm').submit(function(e) {
            e.preventDefault();
            let branch_id = $('#branch').val();
            let category_id = $('#course_category').val();
            let type_id = $('#course_type').val();
            let price = $('#price').val();

            if (branch_id && category_id && type_id && price) {
                let url = "{{ route('enroll.coupon.apply', ':id') }}";
                url = url.replace(':id', branch_id + '.' + category_id + '.' + type_id + '.' + price);
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        // console.log(response);
                        if (response.success) {
                            $('.errorCoupon').hide();
                            $('#discount_coupon_box').show();
                            $('#discount_coupon_view').val(response.discount_coupon);
                            $('#discount_coupon_exists').val(1);
                            $('#discount_coupon').val(Number(response.discount_coupon));
                            Swal.fire(
                                'Done!',
                                response.success,
                                'success'
                            );
                        } else {
                            $('#discount_coupon_box').hide();
                            $('#discount_coupon_view').val('');
                            $('#discount_coupon_exists').val(0);
                            $('#discount_coupon').val('');
                            $('.errorCoupon').html(response.error)
                            Swal.fire(
                                'Sorry!',
                                response.error,
                                'warning'
                            );
                        }
                    }
                });
            } else {
                Swal.fire(
                    'Sorry!',
                    'Select branch, course category & type first to get course fee and after that you can apply coupon code.',
                    'warning'
                );
                if (!branch_id) {
                    $('#branch').addClass('is-invalid');
                    $('#branch').siblings('.error').html('Please select branch.');
                }
                if (!category_id) {
                    $('#course_category').addClass('is-invalid');
                    $('#course_category').siblings('.error').html('Please select course category.');
                }
                if (!type_id) {
                    $('#course_type').addClass('is-invalid');
                    $('#course_type').siblings('.error').html('Please select course type.');
                }
            }
            // $("#enroll").submit();
        });

        $("#enroll").submit(function(e) {
            e.preventDefault();
            $('#pageLoader').show();
            let data = {
                branch: $('#branch').val(),
                course_category: $('#course_category').val(),
                course_type: $('#course_type').val(),
                start_date: $('#start_date').val(),
                course_slot: $('#course_slot').val(),
            };
            localStorage.setItem('formData', JSON.stringify(data));
            $.ajax({
                method: 'POST',
                url: "{{ route('enroll.store') }}",
                data: $(this).serialize(),
                success: function(response) {
                    $('.error').html('');
                    $('input').removeClass('is-invalid');
                    $('select').removeClass('is-invalid');
                    if (response.success) {
                        localStorage.removeItem("formData");
                        $('#pageLoader').hide();
                        window.location.href = '{{ route('otp') }}';
                    } else if (response.errors) {
                        // console.log(response.errors);
                        $('#pageLoader').hide();
                        let errors = response.errors;
                        $.each(errors, function(key, value) {
                            let field = '#' + key;
                            $(field).addClass('is-invalid');
                            $(field).siblings('.error').html(value);
                            $(field).siblings('.error').css('display', 'block');
                        });
                    } else if (response.paidErr) {
                        $('#pageLoader').hide();
                        Swal.fire(
                            'Oops',
                            response.paidErr,
                            'warning',
                        )
                    } else {
                        $('#pageLoader').hide();
                        $('#login-modal').modal('show');
                        $('#login-modal .modal-content').html(response);
                    }
                }
            });
        });

        $('#show-password').click(function() {
            if ($('#password').attr('type') == 'password') {
                $('#password').attr('type', 'text');
                $('#confirm_password').attr('type', 'text');
                $('#show-password i').removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                $('#password').attr('type', 'password');
                $('#confirm_password').attr('type', 'password');
                $('#show-password i').removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    </script>
@endsection
