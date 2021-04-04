<div class="container-fluid content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">الاسئلة</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <a class="btn btn-success" style="margin-bottom: 10px;" href="{{ url('/add_question') }}">إضافة جديد</a>
                            <th>السؤال</th>
                            <th>التحكم</th>
                        </tr>

                        @foreach ($questions as $question)
                            <tr>
                                <td>{{ $question->question }}</td>
                                <td>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-primary" style="margin-left: 5px;"
                                                        href="{{ url('/edit_question', $question->id) }}">تعديل
                                                    </a>
                                                    <a class="btn btn-danger delete"
                                                        href="{{ url('/delete_question', $question->id) }}">حذف
                                                    </a>

                                                </div>
                                                <a class="btn btn-info"
                                                    href="{{ url('/answers', $question->id) }}">الاجابات
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                </div>

            </div>
            {{ $questions->links() }}

        </div>
    </div>
</div>
