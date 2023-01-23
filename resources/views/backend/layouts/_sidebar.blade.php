<div class="leftside-menu">

    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="{{ asset('logo.png') }}" alt="" style=" width: 100%; background: white; ">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('backend/assets/images/logo_sm.png') }}" alt="" height="16">
        </span>
    </a>


    <div class="h-100" id="leftside-menu-container" data-simplebar="">

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-item" style=" margin-top: 40px; ">
                <a href="{{ route('dashboard.index') }}" class="side-nav-link">
                    <i class="fas fa-tachometer-alt"></i> <span>الرئيسية</span>
                </a>
            </li>
            @canany(['Read-Roles', 'Create-Role', 'Read-Roles', 'Create-Role'])
                <li class="side-nav-title side-nav-item">الصلاحيات والأدوار</li>

                @canany(['Read-Roles', 'Create-Role'])
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#outgoing" aria-expanded="false" aria-controls="outgoing"
                            class="side-nav-link">
                            <i class="fas fa-user-lock"></i><span>الأدوار</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="outgoing">
                            <ul class="side-nav-second-level">
                                @can('Read-Roles')
                                    <li>
                                        <a href="{{ route('roles.index') }}">عرض الجميع</a>
                                    </li>
                                @endcan
                                @can('Create-Role')
                                    <li>
                                        <a href="{{ route('roles.create') }}">أضف جديد</a>
                                    </li>
                                @endcan

                            </ul>
                        </div>
                    </li>
                @endcanany

            @endcanany

            <!--========================================================================================-->
            @canany(['Read-Admins', 'Create-Admin'])
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#admins" aria-expanded="false" aria-controls="admins"
                        class="side-nav-link">
                        <i class="fas fa-hotel"></i><span>البلديات</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="admins">
                        <ul class="side-nav-second-level">
                            @can('Read-Admins')
                                <li>
                                    <a href="{{ route('admins.index') }}">عرض الجميع</a>
                                </li>
                            @endcan
                            @can('Create-Admin')
                                <li>
                                    <a href="{{ route('admins.create') }}">أضف جديد</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcanany

            <!--========================================================================================-->
            @canany(['Read-Users', 'Create-User'])
                <li class="side-nav-title side-nav-item">المشتركين</li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#Subscribers" aria-expanded="false" aria-controls="Subscribers"
                        class="side-nav-link">
                        <i class="fas fa-user-friends"></i><span>المشتركين</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Subscribers">
                        <ul class="side-nav-second-level">
                            @can('Read-Users')
                                <li>
                                    <a href="{{ route('users.index') }}">عرض الجميع</a>
                                </li>
                            @endcan
                            @can('Create-User')
                                <li>
                                    <a href="{{ route('users.create') }}">أضف جديد</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcanany

            <!--========================================================================================-->

            {{-- <li class="side-nav-title side-nav-item">الدوائر والمعاملات</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#circle" aria-expanded="false" aria-controls="circle"
                    class="side-nav-link">
                    <i class="uil-store"></i>
                    <span>الدوائر</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="circle">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('circles.index') }}">عرض الجميع</a>
                        </li>
                        <li>
                            <a href="{{ route('circles.create') }}">أضف جديد</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#section" aria-expanded="false" aria-controls="section"
                    class="side-nav-link">
                    <i class="uil-store"></i>
                    <span>الأقسام</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="section">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('departments.index') }}">عرض الجميع</a>
                        </li>
                        <li>
                            <a href="{{ route('departments.create') }}">أضف جديد</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#transactions" aria-expanded="false" aria-controls="transactions"
                    class="side-nav-link">
                    <i class="uil-store"></i>
                    <span>المعاملات الالكترونية</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="transactions">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('treatments.index') }}">عرض الجميع</a>
                        </li>
                        <li>
                            <a href="{{ route('treatments.create') }}">أضف جديد</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#orders" aria-expanded="false" aria-controls="orders"
                    class="side-nav-link">
                    <i class="uil-store"></i>
                    <span>طلباتي</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="orders">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="#">عرض الجميع</a>
                        </li>
                        <li>
                            <a href="#">أضف جديد</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#readings" aria-expanded="false" aria-controls="readings"
                    class="side-nav-link">
                    <i class="uil-store"></i>
                    <span>القراءات</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="readings">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="#">عرض الجميع</a>
                        </li>
                        <li>
                            <a href="#">أضف جديد</a>
                        </li>
                    </ul>
                </div>
            </li> --}}


            <!--========================================================================================-->
            @canany(['Read-Problems', 'Create-Problem'])
                <li class="side-nav-title side-nav-item">الشكاوي</li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#complaints" aria-expanded="false" aria-controls="complaints"
                        class="side-nav-link">
                        <i class="fas fa-exclamation-circle"></i><span>الشكاوي</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="complaints">
                        <ul class="side-nav-second-level">
                            @can('Read-Problems')
                                <li>
                                    <a href="{{ route('problems.index') }}">عرض الجميع</a>
                                </li>
                            @endcan
                            @can('Create-Problem')
                                @if (auth('web')->check())
                                    <li>
                                        <a href="{{ route('problems.create') }}">أضف جديد</a>
                                    </li>
                                @endif
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcanany

            <!--========================================================================================-->

            <li class="side-nav-item">
                <a href="{{ route('auth.logout') }}" class="side-nav-link">
                    <i class="fas fa-sign-out-alt"></i><span>تسجيل الخروج</span>
                </a>
            </li>
        </ul>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->

</div>
