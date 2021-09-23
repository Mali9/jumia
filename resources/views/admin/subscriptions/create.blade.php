@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{asset('admin')}}/plugins/select2/select2.min.css">
@endsection
@section('content')
<div class="col-md-12">
    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">أضف إشتراك جديد </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form class="form-horizontal" enctype='multipart/form-data' method="POST"
            action="{{ url('/store_subscription') }}">
            @csrf
            <div class="card-body">

                <div class="form-group">

                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="exampleInputEmail1">أختر الباقة</label>
                            <select name="package_id" id="select2"
                                class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                                tabindex="-1" aria-hidden="true" required>
                                <option value="أختر الباقة"></option>
                                @foreach ($packages as $package)
                                <option value="{{ $package->id }}">
                                    {{ $package->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-10">
                    <div class="form-group">
                        <label for="exampleInputEmail1">أختر المستخدم</label>
                        <select name="user_id" id="select2" class="form-control select2 select2-hidden-accessible"
                            style="width: 100%;" tabindex="-1" aria-hidden="true" required>
                            <option value="أختر الباقة"></option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->username }}</option>
                            @endforeach
                        </select>

                    </div>
                    @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>


                {{-- <div class="col-sm-10">
                    <div class="form-group">
                        <div class="form-check">
                            <input id="staff" class="form-check-input" type="checkbox" name="staff" value="true">
                            <label for="staff" class="form-check-label">staff</label>
                        </div>

                    </div>
                    @error('started_at')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div> --}}




            </div>


    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"> إضافة </button>
        <a class="btn btn-danger float-left" href="{{ url('/all-subscriptions') }}"> إلغاء </a>
    </div>
    <!-- /.card-footer -->
    </form>
</div>
</div>


@endsection
@section('scripts')
<script src="{{asset('admin')}}/plugins/select2/select2.full.min.js"></script>
<script>
    $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()


    $('.normal-example').persianDatepicker();




  })
</script>
<script>
    $(".subscriptions").addClass('active');

        $("#checkAll").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        $('#type').on('change', function() {
            if (this.value == 'sub_admin') {
                $(".roles").css('display', 'block');
            } else {
                $(".roles").css('display', 'none');

            }
        });

</script>
@endsection