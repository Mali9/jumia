<div class="container-fluid content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-hebarer">
                    <h3 class="card-title">شريط الأخبار</h3>
                </div>
                <!-- /.card-hebarer -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <a class="btn btn-success" style="margin-bottom: 10px;"
                                href=" {{ action('Admin\BarController@create') }} ">إضافة جديد</a>
                            <th>المحتوى</th>

                            <th>التحكم</th>
                        </tr>

                        @foreach ($bars as $bar)
                            <tr>
                                <td>{!! $bar->body !!}</td>
                                <td>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-primary" style="margin-left: 5px;"
                                                        href="{{ url('/edit_bar', $bar->id) }}">تعديل
                                                    </a>
                                                    <a class="btn btn-danger delete" style="margin-left: 5px;"
                                                        href="{{ url('/delete_bar', $bar->id) }}">حذف
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
            {{ $bars->links() }}

        </div>
    </div>
</div>
