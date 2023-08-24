<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <a href="{{ route('index') }}"><img src='{{ asset("uploads/logos/$settings->logo_light") }}' class="logo-icon" alt="logo icon"></a>
        </div>
        <div class="toggle-icon ms-auto"> <i class="bi bi-list"></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('admin.index') }}">
                <div class="parent-icon"><i class="bi bi-person-lines-fill"></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li class="menu-label">Admin Area</li>
        @hasrole([1, 2, 3])
            <li>
                <a href="{{ route('admin.enroll.index') }}">
                    <div class="parent-icon"><i class="fa-regular fa-server"></i>
                    </div>
                    <div class="menu-title">Enrolls</div>
                </a>
            </li>
        @endhasrole
        @hasrole([1, 2])
            <li>
                <a href="{{ route('certificate.verify.view') }}">
                    <div class="parent-icon"><i class="far fa-credit-card"></i>
                    </div>
                    <div class="menu-title">Verify Certificate</div>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <div class="parent-icon"><i class="fa-solid fa-users"></i></div>
                    <div class="menu-title">Users</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.users') }}"><i class="fa-solid fa-user-shield"></i>Admins/Instructors</a></li>
                    <li><a href="{{ route('admin.students') }}"><i class="fa-solid fa-user-group"></i>Students</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <div class="parent-icon"><i class="fa-solid fa-money-bill-trend-up"></i></div>
                    <div class="menu-title">Accounts</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.income') }}"><i class="fa-regular fa-money-bills"></i>Income</a></li>
                    <li><a href="{{ route('admin.expense') }}"><i class="fa-solid fa-money-bill-transfer"></i>Expense</a></li>
                </ul>
            </li>
        @endhasrole
        @hasrole(1)
            <li>
                <a href="{{ route('admin.branches') }}">
                    <div class="parent-icon"><i class="fa-solid fa-list-timeline"></i>
                    </div>
                    <div class="menu-title">Branches</div>
                </a>
            </li>
        @endhasrole
        @hasrole([1, 2])
            <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <div class="parent-icon"><i class="fa-solid fa-car-garage"></i></div>
                    <div class="menu-title">Courses</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.courses') }}"><i class="fa-solid fa-gear"></i>Course Settings</a></li>
                    <li><a href="{{ route('admin.courses.list') }}"><i class="fa-solid fa-list"></i>Add Course</a></li>
                </ul>
            </li>
        @endhasrole
        @hasrole([1, 2, 3])
            <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <div class="parent-icon"><i class="fa-regular fa-pen-nib"></i></div>
                    <div class="menu-title">Quizzes</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.quizzes') }}"><i class="fa-solid fa-user-shield"></i>Quizzes (Admin)</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.docs_upload') }}">
                    <div class="parent-icon"><i class="fa-solid fa-list-timeline"></i>
                    </div>
                    <div class="menu-title">Upload Docs</div>
                </a>
            </li>
        @endhasrole
        @hasrole(1)
            <li>
                <a href="{{ route('admin.vid_courses') }}">
                    <div class="parent-icon"><i class="fas fa-video"></i>
                    </div>
                    <div class="menu-title">Video Courses (Admin)</div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.coupons.index') }}">
                    <div class="parent-icon"><i class="fas fa-ticket"></i>
                    </div>
                    <div class="menu-title">Coupons</div>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <div class="parent-icon"><i class="fa-solid fa-gear"></i></div>
                    <div class="menu-title">Settings</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.settings.index') }}"><i class="fa-solid fa-screwdriver-wrench"></i>Site
                            Setting</a></li>
                    <li>
                        <a href="javascript:void(0);" class="has-arrow">
                            <div class="parent-icon"><i class="fas fa-globe"></i></div>
                            <div class="menu-title">Site Customization</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('admin.customize.home') }}"><i class="fa-solid fa-home"></i>Homepage</a></li>
                            <li><a href="{{ route('admin.customize.about') }}"><i class="fas fa-list-alt"></i>About Page</a></li>
                            <li><a href="{{ route('admin.customize.contact') }}"><i class="fas fa-id-card-alt"></i>Contact Page</a></li>
                            <li><a href="{{ route('admin.customize.privacy_policy') }}"><i class="fas fa-id-card-alt"></i>Privacy Policy Page</a></li>
                            <li><a href="{{ route('admin.customize.terms_and_conditions') }}"><i class="fas fa-id-card-alt"></i>Terms & Conditions Page</a></li>
                            <li><a href="{{ route('admin.customize.refund_policy') }}"><i class="fas fa-id-card-alt"></i>Refund Policy Page</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <div class="parent-icon"><i class="fa-regular fa-pen-nib"></i></div>
                    <div class="menu-title">Blogs</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.blogs') }}"><i class="fa-solid fa-note"></i>Blog Posts</a></li>
                    <li><a href="{{ route('admin.blogs.tags') }}"><i class="fa-solid fa-tag"></i>Blog Tags</a></li>
                </ul>
            </li>
        @endhasrole
        @hasrole(4)
            <li>
                <a href="{{ route('admin.student.vid_courses') }}">
                    <div class="parent-icon"><i class="fas fa-video"></i>
                    </div>
                    <div class="menu-title">Video Courses</div>
                </a>
            </li>
        @endhasrole
    </ul>
    <!--end navigation-->
</aside>
