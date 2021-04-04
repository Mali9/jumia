<div class="container-fluid content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-hetransferer">
                    <h3 class="card-title">سجل التحويلات بين المشتركين</h3>
                </div>
                <!-- /.card-hetransferer -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>

                            <th>كود المحول</th>
                            <th>اسم المحول </th>
                            <th> كود المحول اليه</th>
                            <th>اسم المحول اليه</th>
                            <th>وقت التحويل</th>
                            <th>المبلغ المحول</th>

                        </tr>

                        @foreach ($transfers as $transfer)
                            <tr>
                                <td>{{ $transfer->sender->id??'' }}</td>
                                <td>{{ $transfer->sender->fullname??'' }}</td>
                                <td>{{ $transfer->reciever->id??'' }}</td>
                                <td>{{ $transfer->reciever->fullname??'' }}</td>

                                <td>{{ $transfer->created_at }}</td>
                                <td>{{ $transfer->total_transfer }}</td>

                            </tr>
                        @endforeach

                    </table>
                </div>

            </div>
            {{ $transfers->links() }}

        </div>
    </div>
</div>
