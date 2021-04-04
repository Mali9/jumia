</div>
<!-- Main Footer -->

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('admin') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('admin') }}/plugins/jquery/jquery.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin') }}/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('admin') }}/dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- SparkLine -->
<script src="{{ asset('admin') }}/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jVectorMap -->
<script src="{{ asset('admin') }}/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{{ asset('admin') }}/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="{{ asset('admin') }}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.2 -->
<script src="{{ asset('admin') }}/plugins/chartjs-old/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
{{-- <script src="{{ asset('') }}/dist/js/pages/dashboard2.js"></script>
--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
{{-- <script
    src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
--}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@yield('scripts')

<script>
    $('.printPage').click(function(e){
        e.preventDefault();
    window.print();
    return false;
    });
    $("body").on('click', '.delete', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'هل تريد الحذف ؟ ',
            text: "سيتم حذف أي شيء متعلق",
            icon: 'تحذير',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'إلغاء',
            confirmButtonText: 'نعم احذف'
        }).then((result) => {
            if (result.value) {
                window.location.href = $(this).attr('href');
                Swal.fire(
                    // 'تم الحذف',
                    'تم الحذف بنجاح',
                    // 'نجاح'
                )
            }
        })
    })

</script>

@if (Session::has('success'))

<script>
    Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{ Session::get('success') }}",
            showConfirmButton: false,
            timer: 1500
        })

</script>
@endif

@if (Session::has('error'))

<script>
    Swal.fire({
            icon: 'error',
            text: "{{ Session::get('error') }}!",
            title: "خطأ",
            // footer: '<a href>ok</a>'
        })

</script>
@endif
</body>

</html>