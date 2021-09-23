<div class="container-fluid content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">

                <div class="card-header">
                    <div style="float: left">
                        <a href="{{ url('/add_subscription') }}" class="btn btn-block btn-info btn-lg">أضافة</a>
                    </div>
                    <h3 class="card-title">الإشتراكات</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow: scroll;">
                    <table class="table table-bordered">
                        <th>الكود</th>

                        <th>اسم المشترك</th>
                        <th>اسم الباقة</th>
                        <th>مدة الباقة / يوم</th>
                        <th>تاريخ بدء الإشتراك</th>
                        <th>تاريخ إنتهاء الإشتراك</th>
                        <th> حالة الإشتراك</th>
                        {{-- <th> مدة الإشتراك</th> --}}
                        {{-- <th> staff</th> --}}

                        <th>التحكم</th>
                        @foreach ($subscriptions as $subscription)
                        <tr>
                            <td>{{ $subscription->id }}</td>
                            <td>{{ $subscription->user->username }}</td>
                            <td>{{ $subscription->package->name }}</td>
                            <td>{{ $subscription->package->duration }}</td>

                            <td>{{ $subscription->started_at }}</td>
                            <td>{{ $subscription->expired_at }}</td>

                            {{-- 
                            <td>
                                @if ($subscription->status == 1)
                                <span class="badge badge-success">مفعل</span>
                                @else
                                <span class="badge badge-danger">غير مفعل</span>
                                @endif
                            </td> --}}

                            <td>
                                @if ($subscription->expired_at > \Carbon\carbon::now('Asia/Riyadh'))
                                <span class="badge badge-success">ساري</span>
                                @else
                                <span class="badge badge-danger">غير ساري</span>
                                @endif
                            </td>
                            {{-- <td>{{ $subscription->staff ? 'نعم' : 'لا' }}</td> --}}
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
                                                            href="{{ url('/edit_subscription') }}/{{ $subscription->id }}">تعديل</a>
                                                        <a class="dropdown-item delete"
                                                            href="{{ url('/delete_subscription') }}/{{ $subscription->id }}">حذف</a>

                                                        {{-- <a class="dropdown-item"
                                                            href="{{ url('/change_subscription_status') }}/{{ $subscription->id }}">تغيير
                                                        حالة الإشتراك</a> --}}

                                                        {{-- <a class="dropdown-item"
                                                            href="{{ url('/change_subscription_status') }}/{{ $subscription->id }}">تمديد
                                                        الإشتراك</a> --}}


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
            {{ $subscriptions->links() }}

        </div>
    </div>
</div>