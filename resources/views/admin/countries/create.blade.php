@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">أضف بلد جديد </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" enctype='multipart/form-data' method="POST" action="{{ url('/add_country') }}">
                <div class="card-body">
                    <div class="form-group">
                        <label for="countryName" class="col-sm-2 control-label"> إسم البلد </label>

                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" id="countryName"
                                placeholder="ادخل اسم البلد هنا ">
                        </div>
                    </div>




                    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"> إضافة </button>
                    <a class="btn btn-danger float-left" href=" {{ action('Admin\CountryController@index') }} "> إلغاء </a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>


@endsection
@section('scripts')
    <script>
        $(".countries").addClass('active');

    </script>
@endsection
