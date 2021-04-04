<div class="container-fluid content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-hesuggestioner">
                    <h3 class="card-title">الإقتراحات</h3>
                </div>
                <!-- /.card-hesuggestioner -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>

                            <th>كود مقدم الإقتراح</th>
                            <th>اسم مقدم الإقتراح</th>
                            <th>عنوان الإقتراح</th>
                            <th>محتوى الإقتراح</th>
                            <th>حالة الإقتراح</th>
                            <th>وقت الإقتراح</th>
                            <th>الرد على الإقتراح</th>
                            <th>وقت الرد على الإقتراح</th>
                            <th>التحكم</th>
                        </tr>

                        @foreach ($suggestions as $suggestion)
                        <tr>
                            <td>{{ $suggestion->user->id }}</td>
                            <td>{{ $suggestion->user->fullname }}</td>
                            <td>{{ $suggestion->title }}</td>
                            <td>{{ $suggestion->body }}</td>
                            <td>
                                @if ($suggestion->reply == null)
                                <span class="badge badge-danger">لم يتم الرد</span>
                                @else
                                <span class="badge badge-success">تم الرد</span>
                                @endif
                            </td>
                            <td>{{ $suggestion->created_at }}</td>

                            <td>{!! $suggestion->reply !!}</td>
                            <td>{{ $suggestion->replyed_at }}</td>
                            <td>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-primary" style="margin-left: 5px;"
                                                    href="{{ url('/create_suggestion_reply', $suggestion->id) }}"> إرسال
                                                    رد
                                                </a>
                                                <a class="btn btn-danger delete" style="margin-left: 5px;"
                                                    href="{{ url('/delete_suggestion', $suggestion->id) }}">حذف
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
            {{ $suggestions->links() }}

        </div>
    </div>
</div>