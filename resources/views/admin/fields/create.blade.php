@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <!-- Horizontal Form -->
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">أضف حقل جديد </h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
    <form class="form-horizontal" method="POST" action="{{ action('FieldController@store') }}">
        <div class="card-body">
          <div class="form-group">
            <label for="fieldName" class="col-sm-2 control-label"> إسم الحقل </label>

            <div class="col-sm-10">
              <input type="text" name="name" class="form-control" id="fieldName" placeholder="ادخل اسم الحقل هنا ">
            </div>
          </div>

          <div class="form-group">
            <label for="display-name" class="col-sm-2 control-label"> إسم الحقل الظاهر للمستخدم</label>

            <div class="col-sm-10">
              <input type="text" name="display-name" class="form-control" id="display-name" placeholder="ادخل إسم الحقل الظاهر للمستخدم هنا ">
            </div>
          </div>

            <div class="form-group">
                <label> التصنيف التابع له الحقل </label>
                <select class="form-control" name="category_id">
                  @foreach ($categories as $category)
                <option value="{{$category->id}}"> {{$category->name}} </option> 
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label> نوع الحقل </label>
                <select class="form-control" name="type">
                    <option value = 'text'> Text </option>
                    <option value = 'textarea'> Text Area </option>
                    <option value = 'select'> Select </option>
                    <option value = 'radio'> Radio Button </option>
                    <option value = 'checkbox'> Checkbox </option>
                    <option value = 'date'> Date </option>
                    <option value = 'number'> Number </option>
                    <option value = 'file'> File </option>
                </select>
              </div>

              <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary"> إضافة </button>
          <a class="btn btn-danger float-left" href=" {{ action('FieldController@index') }} "> إلغاء </a>
        </div>
        <!-- /.card-footer -->
      </form>
    </div>
</div>


@endsection