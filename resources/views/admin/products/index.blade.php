@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">المنتجات</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tr>
                    <th style="width: 50%">المنتج</th>
                    <th style="width: 50%">التحكم</th>
                  </tr>

                  @foreach ($products as $product)
                  <tr>
                  <td>{{$product->title}}</td>
                    <td>
                        <table class="table table-bordered">
                            <tr>
                                <td>
                                  <div class="btn-group">
                                    <a class="btn btn-primary" style="margin-left: 5px;" href="{{ url('/product'.'/'. $product->id . '/show') }}">المزيد </a>
                                  </div>
                                </td>
                            </tr>
                        </table>
                    </td>                    
                  </tr>
                  @endforeach

                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                {{-- <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul> --}}
              </div>
            </div>
          </div>
        </div>
    </div>
    
@endsection