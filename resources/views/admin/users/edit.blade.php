@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">تعديل مستخدم </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form class="form-horizontal" enctype='multipart/form-data' method="POST" action="{{ url('/update_user') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="card-body">
                <div class="form-group">
                    <label for="fullname" class="col-sm-2 control-label"> الاسم بالكامل </label>

                    <div class="col-sm-10">
                        <input type="text" name="fullname" class="form-control" id="fullname"
                            placeholder="ادخل اسم المستخدم هنا " value="{{ $user->fullname }}">
                        @error('fullname')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                    </div>
                </div>


                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label"> البريد الالكتروني </label>

                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="email"
                            placeholder="البريد الالكتروني " value="{{ $user->email }}">

                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label"> الاسم </label>

                    <div class="col-sm-10">
                        <input type="text" name="username" value="{{ $user->username }}" class="form-control"
                            id="username" placeholder="الاسم ">
                        @error('username')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label"> كلمة المرور </label>

                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" id="password"
                            placeholder="كلمة المرور ">
                        @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


  
       


         
                <div class="form-group">
                    <label for="image" class="col-sm-2 control-label"> صورة المستخدم </label>

                    <div class="col-sm-10">
                        <input type="file" name="image" id="image">
                        <img src="{{ asset('/uploads/users') . '/' . $user->image }}" alt="">
                        @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>


                </div>
          
           

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"> تعديل </button>
                <a class="btn btn-danger float-left" href="{{ url('/all-users') }}"> إلغاء </a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
</div>


@endsection
@section('scripts')
<script>

    $(".users").addClass('active');

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