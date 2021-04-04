@extends('layouts.app')
@section('styles')

@endsection
@section('content')
{{-- <div class="content-wrapper"> --}}

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-8">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>أعدادات الموقع</h4>
                        </div>
                        <!-- /.card-header -->

                        <!-- form start -->

                        <form role="form" action="{{ url('update_site_settings') }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">عنوان الموقع</label>
                                    <input required type="text" name="site_title" class="form-control"
                                        value="{{ $settings->site_title }}" id="exampleInputEmail1">
                                </div>


                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">مدة الإجابات</label>
                                    <input required type="number" name="answer_duration" class="form-control"
                                        value="{{ $settings->answer_duration }}" id="exampleInputEmail1">
                                </div>


                            </div>



                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">مدة المسابقات</label>
                                    <input required type="number" name="competition_duration" class="form-control"
                                        value="{{ $settings->competition_duration }}" id="exampleInputEmail1">
                                </div>


                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> قيمة التسجيل</label>
                                    <input required type="number" name="registration_value" class="form-control"
                                        value="{{ $settings->registration_value }}" id="exampleInputEmail1">
                                </div>


                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> قيمة التفعيل</label>
                                    <input required type="number" name="activation_value" class="form-control"
                                        value="{{ $settings->activation_value }}" id="exampleInputEmail1">
                                </div>


                            </div>







                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                            </div>
                        </form>



                    </div>


                </div>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
{{-- </div> --}}
@endsection
@section('scripts')
<script>
    $(".site_settings").addClass('active');

</script>
@endsection