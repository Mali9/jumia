@extends('layouts.app')
@section('styles')
    <script src="{{ asset('admin') }}/plugins/ckeditor/ckeditor.js"></script>

@endsection
@section('content')
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">الرد على الشكوى </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" enctype='multipart/form-data' method="POST" action="{{ url('/store_reply') }}">
                <div class="card-body">
                    <div class="form-group">
                        {{-- <label for="adName" class="col-sm-2 control-label"> محتوى شريط
                            الأخبار </label> --}}

                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    محتوى الرد
                                </h3>
                                <!-- tools box -->
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool btn-sm" data-widget="collapse"
                                        data-toggle="tooltip" title="Collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool btn-sm" data-widget="remove"
                                        data-toggle="tooltip" title="Remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                                <!-- /. tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="mb-5">
                                    <textarea id="editor1" name="reply" style="width: 100%"></textarea>
                                </div>

                            </div>
                        </div>
                    </div>



                    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                    <input name="complaint_id" type="hidden" value="{{ $complaint_id }}" />
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"> رد </button>
                    <a class="btn btn-danger float-left" href=" {{ action('Admin\ComplaintController@index') }} "> إلغاء
                    </a>
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
                toolcomplaint: {
                    fa: true
                }
            })
        })

    </script>
    <script>
        $(".complaints").addClass('active');

    </script>
@endsection
