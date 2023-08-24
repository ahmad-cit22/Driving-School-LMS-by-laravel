<!DOCTYPE html>
<html>

<head>
    <title>Course Enrollment Details</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        /* CLIENT-SPECIFIC STYLES */
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        /* RESET STYLES */
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            width: 150px !important;
            margin-top: 70px;
        }

        table {
            border-collapse: collapse !important;
            border-color: #1c1f76 !important;
        }

        table tr td {
            border-collapse: collapse !important;
            padding-bottom: 12px !important;
            line-height: .1px !important;
            font-size: 14px;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            /* background: #eeeeee; */
        }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* ANDROID CENTER FIX */
        div[style*="margin:  15px 0;"] {
            margin: 0 !important;
        }

        :root {
            --purple: #5a3aa5;
            --pink: #b91bab;
            --blue: #2cbaef;
            --green: #23c467;
        }

        body {
            font-family: sans-serif !important;
        }

        .main-box {
            max-width: 800px !important;
            margin: auto !important;
            font-family: inherit !important;
            padding: 0 50px 0 0px !important;
            box-sizing: border-box !important;
        }

        .branch-name {
            font-size: 12px;
        }

        .signatures {
            /* width: 57.8% !important; */
            text-align: right;
            word-spacing: 2px;
            font-size: 14px;
            font-weight: normal;
        }

        .designation {
            font-family: "Poppins", sans-serif;
            font-size: 13px;
            margin-top: 9px;
        }

        .left {
            margin-top: 10px;
        }

        .sign img {
            width: 120px !important;
            margin-right: 30px !important;
        }

        .heading-text {
            color: #1c1f76;
        }
    </style>
</head>

<body style="margin: 0 !important; padding: 0 !important">
    <div class="main-box">
        <p class="" align="center" style="text-align: center; tab-stops: 176.25pt 206.8pt; margin-left: 30px !important;">
            <img src="{{ asset('uploads/logos/' . $settings->logo_dark) }}" width="130" height="27" style="
                                                            display: block;
                                                            border: 0px;
                                                            margin: 0 auto !important;
                                                        " alt="{{ $settings->logo_dark }}" /><span></span>
            <!--[endif]-->

        </p>
        <p class="heading-text" align="center" style="text-align: center; line-height: 100%; tab-stops: 372.1pt; margin-left: 30px !important;">
            <b><span style="font-size: 15pt; line-height: 100%">Course Enrollment Form </span></b>
        </p>
        <table class="MsoTableGrid" border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="border: none">
            <tr>
                <td style="padding: 20px 10px; font-size:  15px">Branch:&nbsp;{{ $enroll->branch->branch_name }}</td>
                <td style="text-align: right; padding: 20px 10px; font-size:  15px">
                    Date: &nbsp;{{ Carbon\Carbon::parse($enroll->created_at)->format('d-m-Y') }}
                </td>
            </tr>
        </table>
        <!-- <p class="" style="line-height: 150%; tab-stops: 372.1pt">
        Branch:&nbsp;
        asd&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Date: &nbsp;123
      </p> -->
        <table class="MsoTableGrid" border="1" cellspacing="0" cellpadding="0" align="left" width="100%" style="/* width: 468.85pt; */ border: none">
            <tbody>
                <tr style="mso-yfti-irow: 0; mso-yfti-firstrow: yes; height: 19.05pt">
                    <td width="114" valign="top" style="
                width: 85.25pt;
                border: solid windowtext 1pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            Name
                        </p>
                    </td>
                    <td width="199" colspan="" valign="top" style="
                width: 149.1pt;
                border: solid windowtext 1pt;
                border-left: none;
                mso-border-left-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            {{ $user->name }}
                        </p>
                    </td>
                    <td width="114" valign="top" style="
                width: 85.25pt;
                border: solid windowtext 1pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            Student ID
                        </p>
                    </td>
                    <td width="199" colspan="" valign="top" style="
                width: 149.1pt;
                border: solid windowtext 1pt;
                border-left: none;
                mso-border-left-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            {{ $user->id_no }}
                        </p>
                    </td>
                </tr>
                <tr style="mso-yfti-irow: 1; height: 0.25in">
                    <td width="114" valign="top" style="
                width: 85.25pt;
                border: solid windowtext 1pt;
                border-top: none;
                mso-border-top-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
                height: 0.25in;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            Mobile
                        </p>
                    </td>
                    <td width="199" valign="top"
                        style="
                width: 149.1pt;
                border-top: none;
                border-left: none;
                border-bottom: solid windowtext 1pt;
                border-right: solid windowtext 1pt;
                mso-border-top-alt: solid windowtext 0.5pt;
                mso-border-left-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
                height: 0.25in;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            {{ $user->mobile }}
                        </p>
                    </td>
                    <td width="89" valign="top"
                        style="
                width: 66.9pt;
                border-top: none;
                border-left: none;
                border-bottom: solid windowtext 1pt;
                border-right: solid windowtext 1pt;
                mso-border-top-alt: solid windowtext 0.5pt;
                mso-border-left-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
                height: 0.25in;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            Email
                        </p>
                    </td>
                    <td width="223" valign="top"
                        style="
                width: 167.6pt;
                border-top: none;
                border-left: none;
                border-bottom: solid windowtext 1pt;
                border-right: solid windowtext 1pt;
                mso-border-top-alt: solid windowtext 0.5pt;
                mso-border-left-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
                height: 0.25in;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            {{ $user->email }}
                        </p>
                    </td>
                </tr>
                <tr style="mso-yfti-irow: 2; height: 19.05pt">
                    <td width="114" valign="top" style="
                width: 85.25pt;
                border: solid windowtext 1pt;
                border-top: none;
                mso-border-top-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            NID
                        </p>
                    </td>
                    <td width="199" valign="top"
                        style="
                width: 149.1pt;
                border-top: none;
                border-left: none;
                border-bottom: solid windowtext 1pt;
                border-right: solid windowtext 1pt;
                mso-border-top-alt: solid windowtext 0.5pt;
                mso-border-left-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            {{ $user->nid }}
                        </p>
                    </td>
                    <td width="89" valign="top"
                        style="
                width: 66.9pt;
                border-top: none;
                border-left: none;
                border-bottom: solid windowtext 1pt;
                border-right: solid windowtext 1pt;
                mso-border-top-alt: solid windowtext 0.5pt;
                mso-border-left-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            Date of Birth
                        </p>
                    </td>
                    <td width="223" valign="top"
                        style="
                width: 167.6pt;
                border-top: none;
                border-left: none;
                border-bottom: solid windowtext 1pt;
                border-right: solid windowtext 1pt;
                mso-border-top-alt: solid windowtext 0.5pt;
                mso-border-left-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            {{ Carbon\Carbon::parse($user->b_date)->format('d-m-Y') }}
                        </p>
                    </td>
                </tr>
                <tr style="mso-yfti-irow: 3; height: 0.25in">
                    <td width="114" valign="top" style="
                width: 85.25pt;
                border: solid windowtext 1pt;
                border-top: none;
                mso-border-top-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
                height: 0.25in;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            Course Category
                        </p>
                    </td>
                    <td width="199" valign="top"
                        style="
                width: 149.1pt;
                border-top: none;
                border-left: none;
                border-bottom: solid windowtext 1pt;
                border-right: solid windowtext 1pt;
                mso-border-top-alt: solid windowtext 0.5pt;
                mso-border-left-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
                height: 0.25in;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            {{ $enroll->category->category_name }}
                        </p>
                    </td>
                    <td width="89" valign="top"
                        style="
                width: 66.9pt;
                border-top: none;
                border-left: none;
                border-bottom: solid windowtext 1pt;
                border-right: solid windowtext 1pt;
                mso-border-top-alt: solid windowtext 0.5pt;
                mso-border-left-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
                height: 0.25in;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            Course Type
                        </p>
                    </td>
                    <td width="223" valign="top"
                        style="
                width: 167.6pt;
                border-top: none;
                border-left: none;
                border-bottom: solid windowtext 1pt;
                border-right: solid windowtext 1pt;
                mso-border-top-alt: solid windowtext 0.5pt;
                mso-border-left-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
                height: 0.25in;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            {{ $enroll->type->type_name }} ({{ $enroll->type->duration }} Days)
                        </p>
                    </td>
                </tr>
                <tr style="mso-yfti-irow: 4; mso-yfti-lastrow: yes; height: 19.05pt">
                    <td width="114" valign="top" style="
                width: 85.25pt;
                border: solid windowtext 1pt;
                border-top: none;
                mso-border-top-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            Course Slot
                        </p>
                    </td>
                    <td width="199" valign="top"
                        style="
                width: 149.1pt;
                border-top: none;
                border-left: none;
                border-bottom: solid windowtext 1pt;
                border-right: solid windowtext 1pt;
                mso-border-top-alt: solid windowtext 0.5pt;
                mso-border-left-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            {{ Carbon\Carbon::parse($enroll->slot->start_time)->format('h:i A') }} - {{ Carbon\Carbon::parse($enroll->slot->end_time)->format('h:i A') }}
                        </p>
                    </td>
                    <td width="89" valign="top"
                        style="
                width: 66.9pt;
                border-top: none;
                border-left: none;
                border-bottom: solid windowtext 1pt;
                border-right: solid windowtext 1pt;
                mso-border-top-alt: solid windowtext 0.5pt;
                mso-border-left-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            Course Fee
                        </p>
                    </td>
                    <td width="223" valign="top"
                        style="
                width: 167.6pt;
                border-top: none;
                border-left: none;
                border-bottom: solid windowtext 1pt;
                border-right: solid windowtext 1pt;
                mso-border-top-alt: solid windowtext 0.5pt;
                mso-border-left-alt: solid windowtext 0.5pt;
                mso-border-alt: solid windowtext 0.5pt;
                padding: 0in 5.4pt 0in 5.4pt;
              ">
                        <p class="" style="
                  margin-bottom: 0in;
                  line-height: normal;
                  mso-element: frame;
                  mso-element-frame-hspace: 9pt;
                  mso-element-wrap: around;
                  mso-element-anchor-vertical: page;
                  mso-element-anchor-horizontal: margin;
                  mso-element-top: 189pt;
                  mso-height-rule: exactly;
                ">
                            BDT {{ number_format($enroll->price) }}
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p></p>
        <p class="heading-text" style="text-align: right !important; margin-right: 34px">
            <b><span style="
              font-size:  15px;
              /* line-height: 107%; */
              text-align: right !important;
            ">Payment Details</span>

            </b>
        </p>
        <div style="margin-left: 400px !important;">
            <table class="MsoTableGrid" border="1" cellspacing="0" cellpadding="0" style="border: none">
                <tbody>
                    <tr style="mso-yfti-irow: 0; mso-yfti-firstrow: yes; height:  10pt">
                        <td width="140" valign="top" style="
                  width: 104.8pt;
                  border: solid windowtext 1pt;
                  mso-border-alt: solid windowtext 0.5pt;
                  padding: 0in 5.4pt 0in 5.4pt;
                  height:  10pt;
                ">
                            <p class="" style="
                    margin-bottom: 0in;
                    line-height: normal;
                    tab-stops: 372.1pt;
                  ">
                                Course Fee
                            </p>
                        </td>
                        <td width="140" valign="top" style="
                  width: 104.8pt;
                  border: solid windowtext 1pt;
                  border-left: none;
                  mso-border-left-alt: solid windowtext 0.5pt;
                  mso-border-alt: solid windowtext 0.5pt;
                  padding: 0in 5.4pt 0in 5.4pt;
                  height:  10pt;
                ">
                            <p class="" style="
                    margin-bottom: 0in;
                    line-height: normal;
                    tab-stops: 372.1pt;
                  ">
                                BDT {{ number_format($enroll->price) }}
                            </p>
                        </td>
                    </tr>
                    <tr style="mso-yfti-irow: 1; height:  10pt">
                        <td width="140" valign="top" style="
                  width: 104.8pt;
                  border: solid windowtext 1pt;
                  border-top: none;
                  mso-border-top-alt: solid windowtext 0.5pt;
                  mso-border-alt: solid windowtext 0.5pt;
                  padding: 0in 5.4pt 0in 5.4pt;
                  height:  10pt;
                ">
                            <p class="" style="
                    margin-bottom: 0in;
                    line-height: normal;
                    tab-stops: 372.1pt;
                  ">
                                Discount
                            </p>
                        </td>
                        <td width="140" valign="top"
                            style="
                  width: 104.8pt;
                  border-top: none;
                  border-left: none;
                  border-bottom: solid windowtext 1pt;
                  border-right: solid windowtext 1pt;
                  mso-border-top-alt: solid windowtext 0.5pt;
                  mso-border-left-alt: solid windowtext 0.5pt;
                  mso-border-alt: solid windowtext 0.5pt;
                  padding: 0in 5.4pt 0in 5.4pt;
                  height:  10pt;
                ">
                            <p class="" style="
                    margin-bottom: 0in;
                    line-height: normal;
                    tab-stops: 372.1pt;
                  ">
                                BDT {{ number_format($enroll->discount) }}
                            </p>
                        </td>
                    </tr>
                    <tr style="mso-yfti-irow: 2; height: 19.45pt">
                        <td width="140" valign="top" style="
                  width: 104.8pt;
                  border: solid windowtext 1pt;
                  border-top: none;
                  mso-border-top-alt: solid windowtext 0.5pt;
                  mso-border-alt: solid windowtext 0.5pt;
                  padding: 0in 5.4pt 0in 5.4pt;
                  height: 19.45pt;
                ">
                            <p class="" style="
                    margin-bottom: 0in;
                    line-height: normal;
                    tab-stops: 372.1pt;
                  ">
                                Total Payable
                            </p>
                        </td>
                        <td width="140" valign="top"
                            style="
                  width: 104.8pt;
                  border-top: none;
                  border-left: none;
                  border-bottom: solid windowtext 1pt;
                  border-right: solid windowtext 1pt;
                  mso-border-top-alt: solid windowtext 0.5pt;
                  mso-border-left-alt: solid windowtext 0.5pt;
                  mso-border-alt: solid windowtext 0.5pt;
                  padding: 0in 5.4pt 0in 5.4pt;
                  height: 19.45pt;
                ">
                            <p class="" style="
                    margin-bottom: 0in;
                    line-height: normal;
                    tab-stops: 372.1pt;
                  ">
                                BDT {{ number_format($enroll->payable_amount) }}
                            </p>
                        </td>
                    </tr>
                    <tr style="mso-yfti-irow: 3; height:  10pt">
                        <td width="140" valign="top" style="
                  width: 104.8pt;
                  border: solid windowtext 1pt;
                  border-top: none;
                  mso-border-top-alt: solid windowtext 0.5pt;
                  mso-border-alt: solid windowtext 0.5pt;
                  padding: 0in 5.4pt 0in 5.4pt;
                  height:  10pt;
                ">
                            <p class="" style="
                    margin-bottom: 0in;
                    line-height: normal;
                    tab-stops: 372.1pt;
                  ">
                                Total Paid
                            </p>
                        </td>
                        <td width="140" valign="top"
                            style="
                  width: 104.8pt;
                  border-top: none;
                  border-left: none;
                  border-bottom: solid windowtext 1pt;
                  border-right: solid windowtext 1pt;
                  mso-border-top-alt: solid windowtext 0.5pt;
                  mso-border-left-alt: solid windowtext 0.5pt;
                  mso-border-alt: solid windowtext 0.5pt;
                  padding: 0in 5.4pt 0in 5.4pt;
                  height:  10pt;
                ">
                            <p class="" style="
                    margin-bottom: 0in;
                    line-height: normal;
                    tab-stops: 372.1pt;
                  ">
                                BDT {{ $enroll->payment_status ? number_format($enroll->paid) : 0 }}
                            </p>
                        </td>
                    </tr>
                    <tr style="mso-yfti-irow: 4; mso-yfti-lastrow: yes; height:  10pt">
                        <td width="140" valign="top" style="
                  width: 104.8pt;
                  border: solid windowtext 1pt;
                  border-top: none;
                  mso-border-top-alt: solid windowtext 0.5pt;
                  mso-border-alt: solid windowtext 0.5pt;
                  padding: 0in 5.4pt 0in 5.4pt;
                  height:  10pt;
                ">
                            <p class="" style="
                    margin-bottom: 0in;
                    line-height: normal;
                    tab-stops: 372.1pt;
                  ">
                                Current Due
                            </p>
                        </td>
                        <td width="140" valign="top"
                            style="
                  width: 104.8pt;
                  border-top: none;
                  border-left: none;
                  border-bottom: solid windowtext 1pt;
                  border-right: solid windowtext 1pt;
                  mso-border-top-alt: solid windowtext 0.5pt;
                  mso-border-left-alt: solid windowtext 0.5pt;
                  mso-border-alt: solid windowtext 0.5pt;
                  padding: 0in 5.4pt 0in 5.4pt;
                  height:  10pt;
                ">
                            <p class="" style="
                    margin-bottom: 0in;
                    line-height: normal;
                    tab-stops: 372.1pt;
                  ">
                                BDT {{ $enroll->payment_status ? number_format($enroll->payable_amount - $enroll->paid) : number_format($enroll->payable_amount) }}
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="">
            &nbsp;
        </p>
        <div style="font-size: 14px !important;">
            <p class="">
                In case of any further query, feel free to contact with us.
            </p>
            <p class="">
                &nbsp;
            </p>
            <p class="">With regards,
            </p>
            <p class="">{{ env('APP_NAME') }}
            </p>
            <div class="signatures">
                <div class="left">
                    <div class="sign">
                        <img src="{{ asset('uploads/signature/' . $enroll->branch->branch_manager_signature) }}" alt="Pathway-Driving-School" />
                    </div>
                    <div class="designation">Signature of Branch Manager</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
