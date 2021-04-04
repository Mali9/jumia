<div class="container-fluid content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">

                <div class="card-header">
                    <div style="float: left">
                    </div>
                    <h3 class="card-title">الرصيد الاجمالي للأعضاء</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow: scroll;">
                    <table class="table table-bordered">
                        <th> الكود</th>

                        <th> الاسم الكامل</th>
                        <th>الرصيد الاجمالي</th>

                        {{-- <th>التحكم</th> --}}
                        @if (count($users))

                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->fullname }}</td>
                            <td>{{ $user->credit }}</td>



                        </tr>
                        @endforeach
                        @endif
                    </table>
                </div>

            </div>
            {{ $users->links() }}

        </div>
    </div>
</div>