@extends('layouts.app')

@section('content')


    @include('admin.violations.partial.partial')

@section('scripts')
    <script src="{{ asset('admin') }}/plugins/ckeditor/ckeditor.js"></script>

    <script>
        $(".violations").addClass('active');

        var keyword = '';
        $('#search').keyup(function() {
            keyword = $.trim($(this).val());
            fetch_data(1);
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        function fetch_data(page) {
            keyword = $.trim(keyword);
            var url = "{{url('')}}/all-violations";
            var url = url + '?keyword=' + keyword + '&page=' + page;
            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    console.log(data);
                    $('.content').html(data);
                }
            });
        }

    </script>
@endsection

@endsection
