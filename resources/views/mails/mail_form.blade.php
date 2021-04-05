@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">إرسال إشعار الى كل مستخدمي التطبيق </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form class="form-horizontal" enctype='multipart/form-data' method="POST" action="{{url('')}}/send_mail">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    {{-- <label for="adName" class="col-sm-2 control-label"> محتوى شريط
                            الأخبار </label> --}}

                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                نص الإشعار
                            </h3>
                            <!-- tools box -->
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool btn-sm" data-widget="collapse"
                                    data-toggle="tooltip" title="Collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                      
                            </div>
                            <!-- /. tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="mb-5">
                                <textarea cols="40" rows="15" name="message" style="width: 100%"></textarea>
                            </div>

                        </div>
                    </div>
                </div>




            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"> إرسال </button>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
</div>


@endsection
@section('scripts')
<script src="{{ asset('admin') }}/plugins/ckeditor/ckeditor.js"></script>

<script>
    $(".mails").addClass('active');

        $("#checkAll").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

</script>
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
                toolbar: {
                    fa: true
                }
            })
        })

</script>
@endsection