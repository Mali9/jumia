<div class="container-fluid content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-heviolationer">
                    <h3 class="card-title">المخالفات</h3>
                </div>
                <!-- /.card-heviolationer -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>

                            <th>كود المخالف</th>
                            <th>اسم المخالف</th>
                            <th>عنوان المخالفة</th>
                            <th>محتوى المخالفة</th>
                            <th>حالة المخالفة</th>
                            <th>وقت المخالفة</th>
                            <th>الرد على المخالفة</th>
                            <th>وقت الرد على المخالفة</th>
                            <th>التحكم</th>
                        </tr>

                        @foreach ($violations as $violation)
                        <tr>
                            <td>{{ $violation->user->id }}</td>
                            <td>{{ $violation->user->fullname }}</td>
                            <td>{{ $violation->title }}</td>
                            <td>{{ $violation->body }}</td>
                            <td>
                                @if ($violation->reply == null)
                                <span class="badge badge-danger">لم يتم الرد</span>
                                @else
                                <span class="badge badge-success">تم الرد</span>
                                @endif
                            </td>
                            <td>{{ $violation->created_at }}</td>

                            <td>{!! $violation->reply !!}</td>
                            <td>{{ $violation->replyed_at }}</td>
                            <td>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-primary" style="margin-left: 5px;"
                                                    href="{{ url('/create_violation_reply', $violation->id) }}"> إرسال
                                                    رد
                                                </a>
                                                <a class="btn btn-danger delete" style="margin-left: 5px;"
                                                    href="{{ url('/delete_violation', $violation->id) }}">حذف
                                                </a>

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
            {{ $violations->links() }}

        </div>
    </div>
</div>