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
                    <h2 class="card-title">إحصائيات المرصد</h2><br>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$app_users ?? ''}}</h3>

                                <p>عدد مستخدمين الابلكيشن</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>

                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$news_users ?? ''}}<sup style="font-size: 20px"></sup></h3>

                                <p>عدد مستخدمين المرصد الأخباري</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{$sport_users ?? ''}}<sup style="font-size: 20px"></sup></h3>
                                <p>عدد مستخدمين المرصد الرياضي</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3 style="color: white">{{$sport_post ?? ''}}<sup style="font-size: 20px"></sup></h3>
                                <p style="color: white">عدد أخبار المرصد الرياضي</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>

                        </div>
                    </div>




                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$news_post ?? ''}}</h3>

                                <p>عدد أخبار المرصد الأخباري </p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>

                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$news_comments ?? ''}}<sup style="font-size: 20px"></sup></h3>

                                <p>عدد تعليقات المرصد الأخباري</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{$sport_comments ?? ''}}<sup style="font-size: 20px"></sup></h3>
                                <p>عدد تعليقات المرصد الرياضي</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3 style="color: white">{{$subscripers ?? 0}}<sup style="font-size: 20px"></sup></h3>
                                <p style="color: white">عدد المشتركين</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>

                        </div>
                    </div>
                    <!-- ./col -->

                </div>
            </div>

        </div>
    </div>
</div>
@endsection