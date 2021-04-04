<div class="container-fluid content">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-hecredit_carder">
                    <h3 class="card-title">سجل البيانات البنكية للمستخدمين</h3>
                </div>
                <!-- /.card-hecredit_carder -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>

                            <th>كود المستخدم</th>
                            <th>اسم المستخدم </th>
                            <th>نوع البطاقة</th>

                        </tr>

                        @foreach ($credit_cards as $credit_card)
                            <tr>
                                <td>{{ $credit_card->user->id ?? '' }}</td>
                                <td>{{ $credit_card->user->fullname ?? '' }}</td>
                                <td>{{ $credit_card->credit_card_type }}</td>

                            </tr>
                        @endforeach

                    </table>
                </div>

            </div>
            {{ $credit_cards->links() }}

        </div>
    </div>
</div>
