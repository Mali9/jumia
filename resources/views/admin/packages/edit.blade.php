@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">تعديل باقة </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form class="form-horizontal" enctype='multipart/form-data' method="POST" action="{{ url('/update_package') }}">
            @csrf
            <div class="card-body">

                <input type="hidden" name="package_id" value="{{$package->id}}">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label"> اسم الباقة </label>

                    <div class="col-sm-10">
                        <input type="text" name="name" value="{{ $package->name ?? '' }}" class="form-control" id="name"
                            placeholder="اسم الباقة ">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="form-group">
                    <label for="price" class="col-sm-2 control-label"> السعر </label>

                    <div class="col-sm-10">
                        <input type="number" step="any" name="price" value="{{ $package->price ?? '' }}"
                            class="form-control" id="price" placeholder="السعر " min="1">
                        @error('price')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="form-group">
                    <label for="duration" class="col-sm-2 control-label"> المدة بالشهر </label>

                    <div class="col-sm-10">
                        <input type="number" step="any" name="duration" value="{{ $package->duration ?? '' }}"
                            class="form-control" id="duration" placeholder="المدة بالشهر " min="1">
                        @error('duration')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


            </div>


    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"> تعديل </button>
        <a class="btn btn-danger float-left" href="{{ url('/all-packages') }}"> إلغاء </a>
    </div>
    <!-- /.card-footer -->
    </form>
</div>
</div>


@endsection
@section('scripts')
<script>
    $(".packages").addClass('active');

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