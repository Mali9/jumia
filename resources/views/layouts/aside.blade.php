<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/dashboard') }}" class="brand-link">
        <img src="{{ auth()->user()->image }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">لوحة التحكم</span>
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
                <a href="#" class="d-block">{{ auth()->user()->fullname }}</a>
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
                            صلاحيات لوحة التحكم
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/all-competitors') }}" class="nav-link competitors">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            سجل المشتركين
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ url('/all-rooms') }}" class="nav-link rooms">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        سجل الغرف
                        <p>
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ url('/all-competitions') }}" class="nav-link competitions">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        سجل المسابقات
                        <p>
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ url('/all-competitors-credits') }}" class="nav-link competitors-credits">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p> الأرصدة العامة للمشتركين </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/all-transfers') }}" class="nav-link transfers">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            التحويلات بين
                            المشتركين </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/all-withdrawals') }}" class="nav-link withdrawals">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            سحوبات المشتركين </p>
                    </a>
                </li>



                <li class="nav-item">
                    <a href="{{ url('/all-credit-cards') }}" class="nav-link credit_cards">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            البيانات البنكية </p>
                    </a>
                </li>






                <li class="nav-item">
                    <a href="{{ url('/all-questions') }}" class="nav-link questions">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            سجل الاسئلة
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/all-answers') }}" class="nav-link answers">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            سجل الإجابات
                        </p>
                    </a>
                </li>



                <li class="nav-item">
                    <a href="{{ url('/all-countries') }}" class="nav-link countries">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            البلدان
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ url('/all-ads') }}" class="nav-link ads">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            الإعلانات
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/all-bars') }}" class="nav-link bars">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            شريط الأخبار
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ url('/all-complaints') }}" class="nav-link complaints">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            سجل الشكاوى
                        </p>
                    </a>
                </li>



                <li class="nav-item">
                    <a href="{{ url('/all-suggestions') }}" class="nav-link suggestions">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            سجل المقترحات
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/all-violations') }}" class="nav-link violations">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            سجل المخالفات
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/conditions') }}" class="nav-link conditions">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            سجل الشروط والأحكام
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/mail_form') }}" class="nav-link mails">
                        <i class="nav-icon fa fa-pie-chart"></i>

                        <p>
                            البريد الالكتروني
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