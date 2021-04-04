<div class="container-fluid content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">

                <div class="card-header">
                    <div style="float: left">
                        <a href="{{ url('/add_user') }}" class="btn btn-block btn-info btn-lg">أضافة</a>
                    </div>
                    <h3 class="card-title">الاعضاء</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow: scroll;">
                    <table class="table table-bordered">
                        <th> الكود</th>

                        <th> الاسم الكامل</th>
                        <th>الاسم</th>
                        <th>البلد</th>
                        <th>الصورة</th>
                        <th>البريد الالكتروني</th>
                        <th>الجوال</th>
                        <th>الجنس</th>
                        <th>النوع</th>
                        <th>الحالة</th>
                        <th>تاريخ الاشتراك</th>
                        <th>التحكم</th>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->fullname }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->country->name ?? '' }}</td>
                            <td>
                                @if (!empty($user->image))
                                <img src="{{ $user->image }}" height="150" width="200">
                                @else
                                <img src="https://images.sftcdn.net/images/t_app-cover-l,f_auto/p/ce2ece60-9b32-11e6-95ab-00163ed833e7/260663710/the-test-fun-for-friends-screenshot.jpg"
                                    alt="" height="150" width="200">
                                @endif

                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->gender == 'male' ? 'ذكر' : 'أنثى' }}</td>
                            <td>
                                @if ($user->type == 'user')
                                متسابق
                                @elseif($user->type == 'admin')
                                مدير نظام
                                @else
                                مشرف
                                @endif
                            </td>
                            <td>
                                @if ($user->status == 1)
                                <span class="badge badge-success">نشط</span>
                                @else
                                <span class="badge badge-danger">غير نشط</span>
                                @endif
                            </td>
                            <td>
                                {{ $user->created_at }}
                            </td>
                            <td>
                                <table class="table table-bordered">
                                    <tr>

                                        <td>
                                            <div class="btn-group">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success dropdown-toggle"
                                                        data-toggle="dropdown">التحكم</button>

                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        <a class="dropdown-item"
                                                            href="{{ url('/edit_user') }}/{{ $user->id }}">تعديل</a>
                                                        <a class="dropdown-item delete"
                                                            href="{{ url('/delete_user') }}/{{ $user->id }}">حذف</a>
                                                        @if ($user->status == 1)
                                                        <a class="dropdown-item"
                                                            href="{{ url('/change_user_status') }}/{{ $user->id }}">تعطيل</a>
                                                        @else
                                                        <a class="dropdown-item"
                                                            href="{{ url('/change_user_status') }}/{{ $user->id }}">تنشيط</a>
                                                        @endif
                                                        @if ($user->type == 'sub_admin')
                                                        <a class="dropdown-item"
                                                            href="{{ url('/show_user') }}/{{ $user->id }}">الصلاحيات</a>

                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        @endforeach

                    </table>
                </div>

            </div>
            {{ $users->links() }}

        </div>
    </div>
</div>