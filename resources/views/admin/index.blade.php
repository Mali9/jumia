@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('')}}/dist/css/adminlte.min.css">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

<!-- bootstrap rtl -->
<link rel="stylesheet" href="../dist/css/bootstrap-rtl.min.css">
<link rel="stylesheet" href="{{asset('')}}/dist/css/custom-style.css">
@endsection
@section('content')

<div class="container-fluid content" style="margin-top: 30px">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-hewithdrawaler">
                    <h3 class="card-title">إحصائيات الموقع</h3>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$countries ?? ''}}</h3>

                                <p>عدد البلدان المشتركة</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{url('')}}/all-countries" class="small-box-footer">كل البلدان<i
                                    class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$males ?? ''}}<sup style="font-size: 20px"></sup></h3>

                                <p>عدد المشتركين الذكور</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{url('/all-competitors','males')}}" class="small-box-footer">كل الذكور<i
                                    class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{$females ?? ''}}</h3>
                                <p>عدد المشتركين الإناث</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{url('/all-competitors','females')}}" class="small-box-footer">كل الإناث<i
                                    class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{$users ?? ''}}</h3>

                                <p>عدد المتسابقين</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{url('')}}/all-competitors" class="small-box-footer">كل المتسابقين<i
                                    class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->



                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3 style="margin-bottom: 15px">{{$best_earned->credit ?? ''}}</h3>

                                <h4>{{$best_earned->username ?? ''}}</h>

                                    <p>أعلى المشتركين قيمة</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>

                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$violations ?? ''}}<sup style="font-size: 20px"></sup></h3>

                                <p>عدد المخالفات</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{url('')}}/all-violations" class="small-box-footer">كل المخالفات<i
                                    class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{$complaints ?? ''}}</h3>
                                <p>عدد الشكاوى</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{url('')}}/all-complaints" class="small-box-footer">كل الشكاوى<i
                                    class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{$total_earned_today ?? ''}}</h3>

                                <p>الرصيد العام المكتسب لليوم</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{url('')}}/all-competitors-credits" class="small-box-footer">كل أرصدة المتسابقين<i
                                    class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$questions ?? ''}}</h3>

                                <p>إجمالي عدد الأسئلة </p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ url('/all-questions') }}" class="small-box-footer">كل الأسئلة
                                <i class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div>


                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$total_users_credits ?? ''}}</h3>

                                <p>إجمالي رصيد المشتركين</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ url('/all-competitors-credits') }}" class="small-box-footer">كل أرصدة
                                المتسابقين<i class="fa fa-arrow-circle-left"></i></a>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>
@endsection