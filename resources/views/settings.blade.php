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
                                <label for="exampleInputEmail1">مدة تصفح الأبلكيشن المجانية بالساعة </label>
                                <input required type="number" step="any" min="1" name="browsing_duration"
                                    class="form-control" value="{{ $settings->browsing_duration }}"
                                    id="exampleInputEmail1">
                            </div>


                        </div>





                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">نص إنتهاء مدة التصفح المجانية</label>
                                <textarea required cols="20" rows="20" name="bob_up_text" class="form-control"
                                    id="exampleInputEmail1">{{ $settings->bob_up_text }}</textarea>
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