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
    <form class="form-horizontal" method="POST" action="{{ action('FieldController@update') }}">
        <div class="card-body">
          <div class="form-group">
            <label for="fieldName" class="col-sm-2 control-label"> إسم الحقل </label>

            <div class="col-sm-10">
              <input type="text" name="name" class="form-control" id="fieldName" value="{{$data['field']->name}}">
            </div>
          </div>

          <div class="form-group">
            <label for="display-name" class="col-sm-2 control-label"> إسم الحقل الظاهر للمستخدم</label>

            <div class="col-sm-10">
              <input type="text" name="display-name" class="form-control" id="display-name" value="{{$data['field']->display_name}}">
            </div>
          </div>

            <div class="form-group">
                <label> التصنيف التابع له الحقل </label>
                <select class="form-control" name="category_id">
                  <option selected value=" {{$data['field']->category_id }} "> {{$data['category']->name }} </option>
                  @foreach ($data['categories'] as $category)
                  @if($category->id == $data['field']->category_id)
                   @continue
                  @endif
                <option value="{{$category->id}}"> {{$category->name}} </option> 
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label> نوع الحقل </label>
                <select class="form-control" name="type">

                    @if($data['field']->type != 'text')
                      <option value = 'text'> Text </option>
                      @else
                      <option selected value = 'text'> Text </option>
                    @endif

                    @if($data['field']->type != 'textarea')
                    <option value = 'textarea'> Text Area </option>
                    @else
                    <option selected value = 'textarea'> Text Area </option>
                    @endif

                    @if($data['field']->type != 'select')
                    <option value = 'select'> Select </option>
                    @else 
                    <option selected value = 'select'> Select </option>

                    @endif

                    @if($data['field']->type != 'radio')
                    <option value = 'radio'> Radio Button </option>
                    @else 
                    <option selected value = 'radio'> Radio Button </option>
                    @endif

                    @if($data['field']->type != 'checkbox')
                    <option value = 'checkbox'> Checkbox </option>
                    @else 
                    <option selected value = 'checkbox'> Checkbox </option>
                    @endif

                    @if($data['field']->type != 'date')
                    <option value = 'date'> Date </option>
                    @else 
                    <option selected value = 'date'> Date </option>
                    @endif

                    @if($data['field']->type != 'number')
                    <option value = 'number'> Number </option>
                    @else 
                    <option selected value = 'number'> Number </option>                    
                    @endif

                    @if($data['field']->type != 'file')
                    <option value = 'file'> File </option>
                    @else 
                    <option selected value = 'file'> File </option>
                    @endif

                </select>
              </div>

              <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
              <input name="field_id" type="hidden" value="{{ $data['field']->id }}"/>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary"> حفظ </button>
          <a class="btn btn-danger float-left" href=" {{ action('FieldController@index') }} "> إلغاء </a>
        </div>
        <!-- /.card-footer -->
      </form>
    </div>
</div>


@endsection