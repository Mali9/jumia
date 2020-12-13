@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <!-- Horizontal Form -->
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">أضف تصنيف جديد </h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
    <form class="form-horizontal" method="POST" action="{{ action('CategoryController@store') }}">
        <div class="card-body">
          <div class="form-group">
            <label for="categoryName" class="col-sm-2 control-label"> إسم التصنيف </label>

            <div class="col-sm-10">
              <input type="text" name="name" class="form-control" id="categoryName" placeholder="ادخل اسم التصنيف هنا ">
            </div>
          </div>

            <div class="form-group">
                <label> التصنيف الرئيسي </label>
                <select class="form-control" name="parentCategory">
                    <option value = 0> إختر </option>
                  @foreach ($parents as $parent)
                <option value="{{$parent->id}}"> {{$parent->name}} </option> 
                  @endforeach
                </select>
              </div>
              <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary"> إضافة </button>
          <a class="btn btn-danger float-left" href=" {{ action('CategoryController@index') }} "> إلغاء </a>
        </div>
        <!-- /.card-footer -->
      </form>
    </div>
</div>


@endsection