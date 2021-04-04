@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">تعديل الإجابة </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form class="form-horizontal" enctype='multipart/form-data' method="POST" action="{{ url('/update_answer') }}">
            <div class="card-body">

                <div class="form-group">
                    <label for="answerName" class="col-sm-2 control-label"> الاجابة </label>

                    <div class="col-sm-10">
                        <textarea required name="answer" id="" cols="40" rows="8" class="form-control" id="answerName"
                            placeholder="ادخل  الاجابة هنا ">{{ $answer->answer }}</textarea>
                        @error('answer')
                        <div class=" alert alert-danger">{{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                <input name="answer_id" type="hidden" value="{{ $answer->id }}" />
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"> تعديل </button>
                <a class="btn btn-danger float-left" href="{{ url('/all-answers') }}"> إلغاء </a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
</div>


@endsection
@section('scripts')
<script>
    $(".answers").addClass('active');

</script>
@endsection