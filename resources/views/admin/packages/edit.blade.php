@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{asset('admin')}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

@endsection
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
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            وصف الباقة
                        </h3>
                        <!-- tools box -->
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool btn-sm" data-widget="collapse"
                                data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool btn-sm" data-widget="remove" data-toggle="tooltip"
                                title="Remove">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">



                        <div class="col-md-6 form-group mb-3 rawy">

                            @if (isset($package->description))
                            @foreach ($package->description as $item)
                            <input required class="form-control" style="margin-bottom: 20px" name="description[]"
                                type="text" value="{{ $item }}" id="name">
                            @endforeach
                            @endif



                        </div>

                        <p style="color: red"> @if ($errors->has('description')) {{ $errors->first('description') }}
                            @endif</p>



                        <div class="col-md-6 form-group mb-3">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" id="btn2"> حذف </a>

                                <a href="#" class="btn btn-primary" id="btn1"> إضافة </a>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="form-group">
                    <label for="description" class="col-sm-2 control-label"> وصف الباقة </label>

                    <div class="col-sm-10">
                        <textarea name="description" rows="15" class="form-control" id="description"
                            placeholder="وصف الباقة ">{{ $package->description ?? '' }}</textarea>
                @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
    </div> --}}


    <div class="form-group">
        <label for="price" class="col-sm-2 control-label"> السعر </label>

        <div class="col-sm-10">
            <input type="number" step="any" name="price" value="{{ $package->price ?? '' }}" class="form-control"
                id="price" placeholder="السعر " min="1">
            @error('price')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>


    <div class="form-group">
        <label for="duration" class="col-sm-2 control-label"> المدة بالشهر </label>

        <div class="col-sm-10">
            <input type="number" step="any" name="duration" value="{{ $package->duration ?? '' }}" class="form-control"
                id="duration" placeholder="المدة بالشهر " min="1">
            @error('duration')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group">

        <label>
            <div class="icheckbox_flat-green disabled" aria-checked="false" aria-disabled="true"
                style="position: relative;">
            </div>

            <input type="checkbox" name="favourit" {{$package->favourit ? 'checked' : ''}}>
            مفضلة
        </label>
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
    var div ='<input required class="form-control" style="margin-bottom: 20px" name="description[]" type="text" id="name">';
  $("#btn1").click(function(e){
           e.preventDefault();
         $(".rawy").append(div);
        });

    $('#btn2').click(function(e){
        e.preventDefault();
     
       $('.rawy').children().last().remove();
    })
     
</script>

<style>
    #btn1 {
        float: left;
        margin-top: 20px;
        margin-left: 20px;
    }

    #btn1:before {
        content: "+";
    }

    #btn2 {
        float: left;
        margin-top: 20px;
    }

    #btn2:before {
        content: "-";
    }
</style>
<script src="{{asset('admin')}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
{{-- <script src="{{asset('admin')}}/plugins/ckeditor/ckeditor.js"></script> --}}
<script>
    $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    // ClassicEditor
    //   .create(document.querySelector('#editor1'))
    //   .then(function (editor) {
    //     // The editor instance
    //   })
    //   .catch(function (error) {
    //     console.error(error)
    //   })

    // bootstrap WYSIHTML5 - text editor

      $('.textarea').wysihtml5({
          toolbar: { fa: true }
      })
  })
</script>
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
<style>
    .wysihtml5-toolbar li {
        float: left !important;
    }
</style>