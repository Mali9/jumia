@extends('layouts.app')
@section('styles')
<script src="{{ asset('admin') }}/plugins/ckeditor/ckeditor.js"></script>

@endsection
@section('content')
<div class="col-md-12">
    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">أضف غرفة جديدة </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form class="form-horizontal" enctype='multipart/form-data' method="POST" action="{{ url('/store_room') }}">
            <div class="card-body">
                <div class="form-group">
                    <label for="questionName" class="col-sm-2 control-label"> المبلغ المرصود للغرفة </label>

                    <input type="number" step="any" required name="room_credit" id="questionName" class="form-control"
                        id="questionName" placeholder="ادخل  المبلغ المرصود للغرفة " value="{{ old('room_credit') }}">
                    @error('room_credit')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="questionName" class="col-sm-2 control-label"> المبلغ المرصود للسؤال </label>

                    <input type="number" step="any" required name="credit_per_question" id="questionName"
                        class="form-control" id="questionName" placeholder="ادخل  المبلغ المرصود للسؤال "
                        value="{{ old('credit_per_question') }}">
                    @error('credit_per_question')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="questionName" class="col-sm-2 control-label"> نوع الغرفة </label>

                    <select required name="type" id="questionName" class="form-control" id="questionName">
                        <option value="free">free</option>
                        <option value="credit">credit</option>
                    </select>

                </div>

                <div class="form-group">
                    <label for="questionName" class="col-sm-2 control-label"> حالة الغرفة </label>

                    <select required name="status" id="questionName" class="form-control" id="questionName">
                        <option value="opened">مفتوحة</option>
                        <option value="closed">مغلقة</option>
                    </select>

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

<script src="{{ asset('admin') }}/plugins/ckeditor/ckeditor.js"></script>
<script>
    $(function() {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            ClassicEditor
                .create(document.querySelector('#editor1'))
                .then(function(editor) {
                    // The editor instance
                })
                .catch(function(error) {
                    console.error(error)
                })

            // bootstrap WYSIHTML5 - text editor

            $('.textarea').wysihtml5({
                toolroom: {
                    fa: true
                }
            })
        })

</script>
<script>
    $(".rooms").addClass('active');

</script>
@endsection