@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <!-- Horizontal Form -->
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">عدل التصنيف </h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
    <form class="form-horizontal" method="POST" action="/update-category">
        <div class="card-body">
          <div class="form-group">
            <label for="categoryName" class="col-sm-2 control-label"> إسم التصنيف </label>

            <div class="col-sm-10">
            <input type="text" name="name" class="form-control" id="categoryName" value="{{$data['category']->name}}">
            </div>
          </div>

            <div class="form-group">
                <label> التصنيف الرئيسي </label>
                <select class="form-control" name="parentCategory">
                    @if($data['parent'] != null)
                    <option selected value=" {{$data['parent']->id }} "> {{$data['parent']->name }} </option>
                    @endif
                    <option value = 0> إختر </option>
                  @foreach ($data['parents'] as $parent)
                  @if((($data['parent'] != null) && ($parent->id == $data['parent']->id)) || $parent->id == $data['category']->id)
                    @continue
                  @endif
                <option value="{{$parent->id}}"> {{$parent->name}} </option> 
                  @endforeach
                </select>
              </div>
              <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
              <input name="cat_id" type="hidden" value="{{ $data['category']->id }}"/>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary"> حفظ </button>
          <a class="btn btn-danger float-left" href=" {{ action('CategoryController@index') }} "> إلغاء </a>
        </div>
        <!-- /.card-footer -->
      </form>
    </div>
</div>


@endsection