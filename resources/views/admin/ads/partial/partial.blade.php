<div class="container-fluid content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">البلدان</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <a class="btn btn-success" style="margin-bottom: 10px;"
                                href=" {{ action('Admin\AdController@create') }} ">إضافة جديد</a>
                            <th>العنوان</th>
                            <th>الرابط</th>
                            <th>الصورة</th>
                            <th>التحكم</th>
                        </tr>

                        @foreach ($ads as $ad)
                        <tr>
                            <td>{{ $ad->title }}</td>
                            <td>{{ $ad->url }}</td>
                            <td>
                                @if (!empty($ad->image))
                                <img src="{{ $ad->image }}" height="150" width="200">
                                @else
                                <img src="https://images.sftcdn.net/images/t_app-cover-l,f_auto/p/ce2ece60-9b32-11e6-95ab-00163ed833e7/260663710/the-test-fun-for-friends-screenshot.jpg"
                                    alt="" height="150" width="200">
                                @endif
                            </td>
                            <td>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-primary" style="margin-left: 5px;"
                                                    href="{{ url('/edit_ad', $ad->id) }}">تعديل
                                                </a>
                                                <a class="btn btn-danger delete" style="margin-left: 5px;"
                                                    href="{{ url('/delete_ad', $ad->id) }}">حذف
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
            {{ $ads->links() }}

        </div>
    </div>
</div>