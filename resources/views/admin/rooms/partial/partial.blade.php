<div class="container-fluid content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-heroomer">
                    <h3 class="card-title">الغرفة</h3>
                </div>
                <!-- /.card-heroomer -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <a class="btn btn-success" style="margin-bottom: 10px;"
                                href=" {{ action('Admin\RoomController@create') }} ">إضافة جديد</a>
                            <th>المبلغ المرصود للغرفة</th>
                            <th>المبلغ المرصود للسؤال</th>
                            <th>المبلغ المكتسب من الغرفة </th>

                            <th>نوع الغرفة</th>
                            <th>حالة الغرفة</th>
                            <th>تاريخ انشاء الغرفة</th>
                            <th>تاريخ بدء المسابقة</th>
                            <th>تاريخ انتهاء المسابقة</th>
                            <th>التحكم</th>
                        </tr>

                        @foreach ($rooms as $room)
                        <tr>
                            <td>{{ $room->room_credit }}</td>
                            <td>{{ $room->credit_per_question }}</td>
                            <td>{{ $room->earned ?? 0 }}</td>
                            <td>{{ $room->type == 'credit' ? 'برصيد' : 'بدون رصيد' }}</td>
                            <td> @if($room->status == 'opened')
                                مغلقة
                                @elseif($room->status == 'closed')
                                متاحة
                                @else
                                منتهية
                                @endif

                            </td>
                            <td>{{ $room->created_at }}</td>
                            <td>{{ $room->started_at }}</td>
                            <td>{{ $room->finished_at }}</td>
                            <td>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-primary" style="margin-left: 5px;"
                                                    href="{{ url('/edit_room', $room->id) }}">تعديل
                                                </a>
                                                <a class="btn btn-danger delete" style="margin-left: 5px;"
                                                    href="{{ url('/delete_room', $room->id) }}">حذف
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
            {{ $rooms->links() }}

        </div>
    </div>
</div>