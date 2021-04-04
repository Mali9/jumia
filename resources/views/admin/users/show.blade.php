@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"> {{ $user->name }} </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <table class="table table-condensed">
                <tr>
                    <div>
                        Phone
                    </div>
                    <div>
                        {{ $user->phone }}
                    </div>
                </tr>

                <tr>
                    <div>
                        Image
                    </div>
                    <div>
                        {{ $user->image }}
                    </div>
                </tr>

                <tr>
                    <div style="margin: 10px">
                        Chats
                    </div>
                    <table class="table table-bordered" style="margin: 10px">
                        @foreach ($user['chats'] as $chat)
                            <tr>
                                <td>
                                    {{ $chat[0][0]->name }}
                                </td>
                                <td>
                                    <a class="btn btn-primary" style="margin-left: 5px;"
                                        href="{{ url("/user/chat/$id/" . $chat[0][0]->id . '/' . $chat[1]) }}"> الرسائل </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </tr>

                <tr>
                    @if ($user->is_blocked == 0)
                        <a class="btn btn-primary" style="margin-left: 5px;"
                            href="{{ url('/users' . '/' . $user->id . '/block') }}">تجميد الحساب </a>
                    @else
                        <a class="btn btn-primary" style="margin-left: 5px;"
                            href="{{ url('/users' . '/' . $user->id . '/unblock') }}">تفعيل الحساب </a>
                    @endif
                </tr>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

@endsection
@section('scripts')
    <script>
        $(".users").addClass('active');

    </script>
@endsection
