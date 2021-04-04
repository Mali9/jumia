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
                                href=" {{ action('Admin\CountryController@create') }} ">إضافة جديد</a>
                            <th>البلد</th>
                            <th>التحكم</th>
                        </tr>

                        @foreach ($countries as $country)
                            <tr>
                                <td>{{ $country->name }}</td>
                                <td>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-primary" style="margin-left: 5px;"
                                                        href="{{ url('/country' . '/' . $country->id . '/edit') }}">تعديل
                                                    </a>
                                                    <a class="btn btn-danger delete"
                                                        href="{{ url('/country' . '/' . $country->id . '/delete') }}">حذف
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
            {{ $countries->links() }}

        </div>
    </div>
</div>
