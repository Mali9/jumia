@extends('layouts.app')

@section('content')


    <div class="container-fluid content">
        <div class="row">
            <div class="col-md-12 ">
                <div class="card">

                    <div class="card-header">
                        <div style="float: left">
                            <a href="{{ url('/all-users') }}" class="btn btn-block btn-info btn-lg">كل المستخدمين</a>
                        </div>
                        <h3 class="card-title">الاعضاء</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <th> الكود</th>

                            <th> الاسم الكامل</th>
                            <th> الصلاحيات</th>

                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->fullname }}</td>
                                <td>
                                    {{-- @dd(count($user->roles))
                                    --}}

                                    @foreach ($user->roles as $key => $role)
                                        @if (count($user->roles) != $key + 1)
                                            {{ $role->role_name }} ,
                                        @else
                                            {{ $role->role_name }}

                                        @endif
                                    @endforeach

                                </td>



                            </tr>

                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>



@endsection
@section('scripts')
    <script>
        $(".users").addClass('active');

    </script>
@endsection
