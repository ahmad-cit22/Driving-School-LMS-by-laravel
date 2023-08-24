@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-body">
            <form id="settings" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="site_name" class="form-label">Site Name</label>
                    <input type="text" class="form-control" id="site_name" name="site_name" value="{{ $settings->site_name }}"placeholder="Enter the Site Name">
                    <div class="error"></div>
                </div>
                <div class="mb-3">
                    <label for="site_tagline" class="form-label">Site Tagline</label>
                    <input type="text" class="form-control" id="site_tagline" name="site_tagline" value="{{ $settings->site_tagline }}" placeholder="Enter the Site Tagline">
                    <div class="error"></div>
                </div>
                <div class="mb-3">
                    <label for="head_office" class="form-label">Head Office Address</label>
                    <input type="text" class="form-control" id="head_office" name="head_office" value="{{ $settings->head_office }}" placeholder="Enter the Head Office Address">
                    <div class="error"></div>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Head Office Helpline No.</label>
                    <input type="text" class="form-control" id="phone" name="helpline_number" value="{{ $settings->phone }}" placeholder="Enter the Helpline No.">
                    <div class="error"></div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{ $settings->email }}" placeholder="Enter email address">
                    <div class="error"></div>
                </div>
                <div class="mb-3">
                    <label for="facebook_page" class="form-label">Facebook Page Link</label>
                    <input type="text" class="form-control" id="facebook_page" name="facebook_page" value="{{ $settings->facebook_page }}" placeholder="Facebook Page Link">
                    <div class="error"></div>
                </div>
                <div class="mb-3">
                    <label for="youtube_channel" class="form-label">Youtube Channel Link</label>
                    <input type="text" class="form-control" id="youtube_channel" name="youtube_channel" value="{{ $settings->youtube_channel }}" placeholder="Youtube Channel Link">
                    <div class="error"></div>
                </div>
                <div class="mb-3">
                    <label for="instagram" class="form-label">Instagram Link</label>
                    <input type="text" class="form-control" id="instagram" name="instagram" value="{{ $settings->instagram }}" placeholder="Instagram Link">
                    <div class="error"></div>
                </div>
                <div class="mb-3">
                    <label for="linkedin" class="form-label">Linkedin Link</label>
                    <input type="text" class="form-control" id="linkedin" name="linkedin" value="{{ $settings->linkedin }}" placeholder="Linkedin Link">
                    <div class="error"></div>
                </div>
                <div class="mb-3">
                    <label for="google_map_link" class="form-label">Google Map Location Link (Embed Link)</label>
                    <input type="text" class="form-control" id="google_map_link" name="google_map_link" value="{{ $settings->google_map_link }}" placeholder="Enter the embed link to be used in iframe">
                    <div class="error"></div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <div class="mb-3">
                            <label for="site_primary_color" class="form-label">Site Primary Color</label>
                            <div class="row">
                                <div class="col-2 col-md-3" style="padding-right: 5px">
                                    <div class="rounded-3" style="width: 100%; height: 100%; background: {{ $settings->site_primary_color }}"></div>
                                </div>
                                <div class="col-10 col-md-9" style="padding-left: 0px">
                                    <input type="text" class="form-control" id="site_primary_color" name="site_primary_color" value="{{ $settings->site_primary_color }}" placeholder="Enter the color code here">
                                    <div class="error"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="mb-3">
                            <label for="site_accent_color" class="form-label">Site Accent Color</label>
                            <div class="row">
                                <div class="col-2 col-md-3" style="padding-right: 5px">
                                    <div class="rounded-3" style="width: 100%; height: 100%; background: {{ $settings->site_accent_color }}"></div>
                                </div>
                                <div class="col-10 col-md-9" style="padding-left: 0px"> <input type="text" class="form-control" id="site_accent_color" name="site_accent_color" value="{{ $settings->site_accent_color }}" placeholder="Enter the color code here"></div>
                            </div>
                            <div class="error"></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="mb-3">
                            <label for="site_secondary_color" class="form-label">Site Secondary Color</label>
                            <div class="row">
                                <div class="col-2 col-md-3" style="padding-right: 5px">
                                    <div class="rounded-3" style="width: 100%; height: 100%; background: {{ $settings->site_secondary_color }}"></div>
                                </div>
                                <div class="col-10 col-md-9" style="padding-left: 0px"> <input type="text" class="form-control" id="site_secondary_color" name="site_secondary_color" value="{{ $settings->site_secondary_color }}" placeholder="Enter the color code here"></div>
                            </div>
                            <div class="error"></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="mb-3">
                            <label for="site_secondary_accent_color" class="form-label">Site Secondary Accent Color</label>
                            <div class="row">
                                <div class="col-2 col-md-3" style="padding-right: 5px">
                                    <div class="rounded-3" style="width: 100%; height: 100%; background: {{ $settings->site_secondary_accent_color }}"></div>
                                </div>
                                <div class="col-10 col-md-9" style="padding-left: 0px"> <input type="text" class="form-control" id="site_secondary_accent_color" name="site_secondary_accent_color" value="{{ $settings->site_secondary_accent_color }}" placeholder="Enter the color code here"></div>
                            </div>
                            <div class="error"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 mb-3">
                        <label for="logo_dark" class="form-label">Logo (Dark Verison)</label>
                        <img class="logo-preview" id="logo-dark" src="{{ asset("uploads/logos/$settings->logo_dark") }}" alt="{{ $settings->logo_dark }}">
                        <input type="file" class="form-control" id="logo_dark" name="logo_dark" onchange="document.getElementById('logo-dark').src = window.URL.createObjectURL(this.files[0])" accept="image/png">
                        <div class="error"></div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="logo_light" class="form-label">Logo (Light Verison)</label>
                        <img class="logo-preview" id="logo-light" style="background: #0007" src="{{ asset("uploads/logos/$settings->logo_light") }}" alt="{{ $settings->logo_light }}">
                        <input type="file" class="form-control" id="logo_light" name="logo_light" onchange="document.getElementById('logo-light').src = window.URL.createObjectURL(this.files[0])" accept="image/png">
                        <div class="error"></div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="favicon" class="form-label">Favicon</label>
                        <img class="favicon-preview" id="favicon-img" src="{{ asset("uploads/logos/$settings->favicon") }}" alt="{{ $settings->favicon }}">
                        <input type="file" class="form-control" id="favicon" name="favicon" onchange="document.getElementById('favicon-img').src = window.URL.createObjectURL(this.files[0])" accept="image/png">
                        <div class="error"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <h6 class="form-label">For SEO</h6>
                    <label for="header_meta_tags" class="form-label">Header Meta Tags</label>
                    <textarea rows="7" class="form-control" id="header_meta_tags" name="header_meta_tags" placeholder="Enter the meta tags that will be placed inside the head tag.">{{ $settings->header_meta_tags }}</textarea>
                    <div class="error"></div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('style')
    <style>
        .logo-preview {
            display: block;
            padding: 10px 15px;
            margin-bottom: 5px;
            width: 150px;
            height: 85px;
            object-fit: contain;
        }

        .favicon-preview {
            display: block;
            padding: 15px;
            width: 85px;
            height: 85px;
            object-fit: cover;
        }

        form .error {
            font-size: .9em;
            color: #dc3545;
            display: none;
        }
    </style>
@endsection

@section('script')
    <script>
        $('#settings').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.settings.update') }}",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('.error').html('');
                    $('input').removeClass('is-invalid');
                    $('select').removeClass('is-invalid');
                    if (response.success) {
                        // console.log(response);
                        window.location.reload();
                    } else {
                        let errors = response.errors;
                        $.each(errors, function(key, value) {
                            let field = '#' + key;
                            $(field).addClass('is-invalid');
                            $(field).siblings('.error').html(value);
                            $(field).siblings('.error').css('display', 'block');
                        });
                    }
                }
            });
        });
    </script>
@endsection
