@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">أضف سؤال جديد </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form class="form-horizontal" enctype='multipart/form-data' method="POST" action="{{ url('/store_question') }}">
            <div class="card-body">

                <div class="form-group">
                    <label for="questionName" class="col-sm-2 control-label"> السؤال </label>

                    <div class="col-sm-10">
                        <textarea required name="question" id="" cols="40" rows="8" class="form-control"
                            id="questionName" placeholder="ادخل  السؤال هنا ">{{ old('question') }}</textarea>
                        @error('question')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="A" class="col-sm-2 control-label"> الاجابة A </label>

                            <div class="col-sm-10">
                                <textarea required name="answers[]"  cols="30" rows="8" class="form-control" id="A"
                                    placeholder="ادخل  الاجابة A هنا "></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="B" class="col-sm-2 control-label"> الاجابة B </label>

                            <div class="col-sm-10">
                                <textarea required name="answers[]" cols="30" rows="8" class="form-control" id="B"
                                    placeholder="ادخل  الاجابة B هنا "></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="C" class="col-sm-2 control-label"> الاجابة C </label>

                            <div class="col-sm-10">
                                <textarea required name="answers[]"  cols="30" rows="8" class="form-control" id="C"
                                    placeholder="ادخل  الاجابة C هنا "></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="D" class="col-sm-2 control-label"> الاجابة D </label>

                            <div class="col-sm-10">
                                <textarea required name="answers[]"  cols="30" rows="8" class="form-control"
                                    id="D" placeholder="ادخل  الاجابة D هنا "></textarea>
                            </div>
                        </div>
                    </div>

                    @error('answers')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="right_answer" class="col-sm-2 control-label"> الاجابة الصحيحة </label>

                    <div class="col-sm-10">
                        <select required name="right_answer" id="right_answer" class="form-control">
                            <option value="A" {{ old('right_answer' == 'A' ? 'selected' : '') }}>A</option>
                            <option value="B" {{ old('right_answer' == 'B' ? 'selected' : '') }}>B</option>
                            <option value="C" {{ old('right_answer' == 'C' ? 'selected' : '') }}>C</option>
                            <option value="D" {{ old('right_answer' == 'D' ? 'selected' : '') }}>D</option>
                        </select>
                        @error('answers')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"> إضافة </button>
                <a class="btn btn-danger float-left" href="{{ url('/all-questions') }}"> إلغاء </a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
</div>


@endsection
@section('scripts')
<script>
    $(".questions").addClass('active');

</script>
@endsection