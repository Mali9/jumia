<div class="container-fluid content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-hecomplainter">
                    <h3 class="card-title">الشكاوى</h3>
                </div>
                <!-- /.card-hecomplainter -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>

                            <th>كود مقدم الشكوى</th>
                            <th>اسم مقدم الشكوى</th>
                            <th>عنوان الشكوى</th>
                            <th>محتوى الشكوى</th>
                            <th>حالة الشكوى</th>
                            <th>وقت الشكوى</th>
                            <th>الرد على الشكوى</th>
                            <th>وقت الرد على الشكوى</th>
                            <th>التحكم</th>
                        </tr>

                        @foreach ($complaints as $complaint)
                        <tr>
                            <td>{{ $complaint->user->id }}</td>
                            <td>{{ $complaint->user->fullname }}</td>
                            <td>{{ $complaint->title }}</td>
                            <td>{{ $complaint->body }}</td>
                            <td>
                                @if ($complaint->reply == null)
                                <span class="badge badge-danger">لم يتم الرد</span>
                                @else
                                <span class="badge badge-success">تم الرد</span>
                                @endif
                            </td>
                            <td>{{ $complaint->created_at }}</td>

                            <td>{!! $complaint->reply !!}</td>
                            <td>{{ $complaint->replyed_at }}</td>
                            <td>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-primary" style="margin-left: 5px;"
                                                    href="{{ url('/create_reply', $complaint->id) }}"> إرسال رد
                                                </a>
                                                <a class="btn btn-danger delete" style="margin-left: 5px;"
                                                    href="{{ url('/delete_complaint', $complaint->id) }}">حذف
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
            {{ $complaints->links() }}

        </div>
    </div>
</div>