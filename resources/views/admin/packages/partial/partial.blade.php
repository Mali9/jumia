<div class="container-fluid content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">

                <div class="card-header">
                    <div style="float: left">
                        <a href="{{ url('/add_package') }}" class="btn btn-block btn-info btn-lg">أضافة</a>
                    </div>
                    <h3 class="card-title">الاعضاء</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow: scroll;">
                    <table class="table table-bordered">
                        <th> الكود</th>

                        <th>الاسم</th>
                        <th>السعر</th>
                        <th>المدة بالشهر</th>

                        <th>التحكم</th>
                        @foreach ($packages as $package)
                        <tr>
                            <td>{{ $package->id }}</td>
                            <td>{{ $package->name }}</td>
                            <td>{{ $package->price }}</td>

                            <td>{{ $package->duration }}</td>



                            <td>
                                <table class="table table-bordered">
                                    <tr>

                                        <td>
                                            <div class="btn-group">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success dropdown-toggle"
                                                        data-toggle="dropdown">التحكم</button>

                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        <a class="dropdown-item"
                                                            href="{{ url('/edit_package') }}/{{ $package->id }}">تعديل</a>
                                                        <a class="dropdown-item delete"
                                                            href="{{ url('/delete_package') }}/{{ $package->id }}">حذف</a>


                                                    </div>
                                                </div>
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
            {{ $packages->links() }}

        </div>
    </div>
</div>