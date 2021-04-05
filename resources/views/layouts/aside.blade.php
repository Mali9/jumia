<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/dashboard') }}" class="brand-link">
        <img src="{{ auth()->guard('web')->user()->image }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ auth()->guard('web')->user()->fullname }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                {{-- <div class="image">
                      <img src="{{ Auth::user()->image }}" class="img-circle elevation-2" alt="User Image">
            </div> --}}
            <div class="info">
                <a href="/dashboard" class="d-block">لوحة التحكم</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->



                <li class="nav-item">
                    <a href="{{ url('/all-users') }}" class="nav-link users">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            كل المستخدمين
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ url('/all-packages') }}" class="nav-link packages">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            كل الباقات
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ url('/all-subscription') }}" class="nav-link subscription">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            تفاصيل المشتركين
                        </p>
                    </a>
                </li>





                <li class="nav-item">
                    <a href="{{ url('/mail_form') }}" class="nav-link mails">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            كل الإشعارات
                        </p>
                    </a>
                </li>




                <li class="nav-item">
                    <a href="{{ url('/site_settings') }}" class="nav-link site_settings">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            إعدادات الموقع
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ url('/logout') }}" class="nav-link">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            تسجيل الخروج
                        </p>
                    </a>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    </div>
    <!-- /.sidebar -->
</aside>