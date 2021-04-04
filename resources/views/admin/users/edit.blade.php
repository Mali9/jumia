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
                    <label for="phone" class="col-sm-2 control-label"> الجوال </label>

                    <div class="col-sm-10">
                        <input type="text" value="{{ $user->phone }}" name="phone" class="form-control" id="phone"
                            placeholder="الجوال ">
                        @error('phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="gender" class="col-sm-2 control-label"> الجنس </label>

                    <div class="col-sm-10">
                        <select name="gender" id="gender" class="form-control">
                            <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>ذكر</option>
                            <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>أنثى
                            </option>
                        </select>
                        @error('gender')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>



                <div class="form-group">
                    <label for="country_id" class="col-sm-2 control-label"> البلد </label>

                    <div class="col-sm-10">
                        <select name="country_id" id="country_id" class="form-control">
                            @foreach ($countries as $country)
                            <option value="{{ $country->id }}"
                                {{ $user->country_id == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                            @endforeach


                        </select>
                        @error('country_id')
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
                <div class="form-group">
                    <label for="type" class="col-sm-2 control-label"> نوع المستخدم </label>

                    <div class="col-sm-10">
                        <select name="type" id="type" class="form-control">
                            {{-- <option value="user" {{ $user->type == 'user' ? 'selected' : '' }}>مستخدم عادي
                            </option> --}}
                            <option value="sub_admin" {{ $user->type == 'sub_admin' ? 'selected' : '' }}>مشرف
                            </option>
                            <option value="admin" {{ $user->type == 'admin' ? 'selected' : '' }}>مدير نظام
                            </option>
                        </select>
                        @error('type')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group roles" @if ($user->type != 'sub_admin') style="display: none" @endif>
                    <label for="roles" class="col-sm-2 control-label"> الصلاحيات </label>

                    <div class="col-md-12 form-group mb-3">
                        <div class="form-group">

                            <div style="margin-top: 15px;margin-bottom: 20px;">
                                <span style="font-size: 14px;font-style: bold;font-weight: bold;margin-left: 5px">
                                    تحديد الكل</span>
                                <input type="checkbox" name="" id="checkAll">
                            </div>
                            <div class="row">


                                @if ($roles)
                                @foreach ($roles as $role)
                                <div class="col-md-2 form-group mb-4">

                                    <label style="width:240px;" class="" for="permisson-{{ $role->id }}">
                                        {{-- <span> {{ $role->name }}</span>
                                        --}}
                                        <input id="permisson-{{ $role->id }}" style="margin-right: 5px" type="checkbox"
                                            name="roles[]" value="{{ $role->id }}" @if (isset($user))
                                            @foreach($user->roles as $user_role)
                                        @if ($role->id == $user_role->id)
                                        checked
                                        @endif
                                        @endforeach

                                        @endif>
                                        <span> {{ $role->role_name }}</span>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>


                                @endforeach
                                @endif
                            </div>

                        </div>
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