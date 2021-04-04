@extends('layouts.app')
@section('content')
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">عدل البلد </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" action="{{ url('/update_country') }}">
                <div class="card-body">
                    <div class="form-group">
                        <label for="countryName" class="col-sm-2 control-label"> إسم البلد </label>

                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" id="countryName"
                                value="{{ $country->name }}">
                        </div>
                    </div>



                    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                    <input name="country_id" type="hidden" value="{{ $country->id }}" />

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"> حفظ </button>
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
