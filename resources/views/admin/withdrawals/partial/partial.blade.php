<div class="container-fluid content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-hewithdrawaler">
                    <h3 class="card-title">سجل سحوبات المشتركين</h3>
                </div>
                <!-- /.card-hewithdrawaler -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>

                            <th>كود المستخدم</th>
                            <th>اسم المستخدم </th>
                            <th>وقت السحب</th>
                            <th>المبلغ المسحوب</th>

                        </tr>

                        @foreach ($withdrawals as $withdrawal)
                            <tr>
                                <td>{{ $withdrawal->user->id ?? '' }}</td>
                                <td>{{ $withdrawal->user->fullname ?? '' }}</td>
                                <td>{{ $withdrawal->created_at }}</td>
                                <td>{{ $withdrawal->total_withdrawal }}</td>

                            </tr>
                        @endforeach

                    </table>
                </div>

            </div>
            {{ $withdrawals->links() }}

        </div>
    </div>
</div>
