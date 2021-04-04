@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">أضف اعلان جديد </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form class="form-horizontal" enctype='multipart/form-data' method="POST" action="{{ url('/store_ad') }}">
            <div class="card-body">
                <div class="form-group">
                    <label for="adName" class="col-sm-2 control-label"> وصف الاعلان </label>

                    <div class="col-sm-10">
                        <textarea name="title" cols="10" rows="20" class="form-control" id="adName"></textarea>
                    </div>
                </div>


                <div class="form-group">
                    <label for="adName" class="col-sm-2 control-label"> رابط الاعلان </label>

                    <div class="col-sm-10">
                        <input type="text" name="url" class="form-control" id="adName"
                            placeholder="ادخل رابط الاعلان هنا ">
                    </div>
                </div>
                <div class="form-group">
                    <label for="adName" class="col-sm-2 control-label"> صورة الاعلان </label>

                    <div class="col-sm-10">
                        <input type="file" name="image" class="form-control" id="adName">
                    </div>
                </div>

                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"> إضافة </button>
                <a class="btn btn-danger float-left" href=" {{ action('Admin\AdController@index') }} "> إلغاء </a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
</div>


@endsection
@section('scripts')
<script>
    $(".ads").addClass('active');

</script>
@endsection