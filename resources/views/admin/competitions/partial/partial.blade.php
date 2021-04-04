<div class="container-fluid content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-hecompetitioner">
                    <h3 class="card-title">سجل المسابقات</h3>
                </div>
                <!-- /.card-hecompetitioner -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>كود المسابقة</th>
                            <th>رقم الغرفة</th>
                            <th>نوع الغرفة</th>

                            <th>كود المتسابق</th>
                            <th>اسم المتسابق </th>
                            <th>وقت دخول المسابقة</th>
                            <th>المبلغ المكتسب</th>
                            <th>حالة المسابقة</th>

                        </tr>

                        @foreach ($competitions as $competition)
                        <tr>
                            <td>{{ $competition->id ?? '' }}</td>
                            <td>{{ $competition->room->id ?? '' }}</td>
                            <td>{{ $competition->room->type == 'free' ? 'بدون رصيد ' : 'برصيد' }}</td>
                            <td>{{ $competition->user->id ?? '' }}</td>
                            <td>{{ $competition->user->fullname ?? '' }}</td>

                            <td>{{ $competition->created_at }}</td>
                            <td>{{ $competition->total_earned }}</td>
                            <td>{{ $competition->status == 'closed' ? 'مغلقة' : 'متاحة' }}</td>

                        </tr>
                        @endforeach

                    </table>
                </div>

            </div>
            {{ $competitions->links() }}

        </div>
    </div>
</div>