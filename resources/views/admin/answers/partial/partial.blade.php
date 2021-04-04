<div class="container-fluid content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">الاجابات</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            {{-- <a class="btn btn-success" style="margin-bottom: 10px;" href="/add_answer">إضافة جديد</a> --}}
                            <th> رقم الاجابة</th>

                            <th>الاجابة</th>
                            <th>السؤال</th>
                            <th>التحكم</th>
                        </tr>

                        @foreach ($answers as $answer)
                        <tr>
                            <td>{{ $answer->answer_num }}</td>
                            <td>{{ $answer->answer }}</td>
                            <td>{{ $answer->question->question }}</td>
                            <td>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-primary" style="margin-left: 5px;"
                                                    href="{{ url('/edit_answer', $answer->id) }}">تعديل
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
            {{ $answers->links() }}

        </div>
    </div>
</div>